<?php
/**
 * 根据名片信息生成图片
 * @author Kilin WANG <wangkilin@126.com>
 *
 */

/**
 * 名片图片生成类
 *
 */
class CardImage
{
    protected $dirHandler = null; // the dir operatation handler. used to check new image store path
    /*
     * 图片操作句柄
     * @var resource
     */
    protected $imgResource = null;

    /*
     * 名片数据信息
     * @var array
     */
    protected $cardInfo = array();

    /*
     * 名片原始宽度
     * @var int
     */
    protected $cardOriginalWidth = 1200; // in px
    /*
     * 名片原始高度
     * @var int
     */
    protected $cardOriginalHeight = 720; // in px
    /*
     * 待生成的名片图片宽度
     * @var int
     */
    protected $cardNewWidth = 1200;       // in px
    /*
     * 待生成的名片图片高度
     * @var int
     */
    protected $cardNewHeight = 720;      // in px

    /*
     * 默认字颜色
     * @var string
     */
    protected $defaultFontColor = "#000000"; // 水印文字颜色
    /*
     * 默认字体
     * @var int|string
     */
    protected $defaultFont = 2; // 水印字体
    /*
     * 默认字号
     * @var int
     */
    protected $defaultFontSize = 12; // 字号

    /*
     * 字体存放路径
     * @var string
     */
    protected $fontFileDir = './';

    /*
     * 字体文件映射关系数据
     * @var array
     */
    protected $_fontMaps = array();

    /**
     * 构造函数, 初始化名片的size, 初始化画布
     *
     * @param int $toWidth 名片图片的宽度
     * @param int $toHeight 名片图片的高度
     * @param int $fromWidth 名片原始宽度
     * @param int $fromHeight 名片原始高度
     */
    public function __construct ($toWidth=null, $toHeight=null, $fromWidth=null, $fromHeight=null)
    {
        $this->setCardWidth ($fromWidth);
        $this->setCardHeight ($fromHeight);
        $this->setCardNewWidth ($toWidth);
        $this->setCardNewHeight($toHeight);

    }

    /**
     * 获取名片背景颜色， 转换成RGB数据
     * @return array
     */
    protected function _getCardBgColor ()
    {
        $color = array('red'=>255, 'green'=>255, 'blue'=>255);
        if (isset($this->cardInfo['templateInfo'], $this->cardInfo['templateInfo']['BGCOLOR'])) {
           if(strlen($this->cardInfo['templateInfo']['BGCOLOR'])== 7){
           	$_tmpColor = \Classes\GFunc::hex2rgb($this->cardInfo['templateInfo']['BGCOLOR']);
           	$color = $_tmpColor ? $_tmpColor : $color;
           }else{
           	$_tmpColor = trim(trim($this->cardInfo['templateInfo']['BGCOLOR']), 'rgb()');
           	$_tmpColor = explode(',', $_tmpColor);
           	return array (
           			'red' => $_tmpColor[0],
           			'green' => $_tmpColor[1],
           			'blue' => $_tmpColor[2]
           	);
           }
            

        }

        return $color;
    }

    /**
     * 获取名片背景图片信息
     * @return string 名片背景图片的路径
     */
    protected function _getCardBgImage ()
    {

        $bgImagePath = '';
        if (! isset($this->cardInfo['templateInfo'], $this->cardInfo['templateInfo']['BGURL'])) {
            return $bgImagePath;
        }
        if(is_dir(C('CARD_STORAGE_PATH'))){
            $_filePath = C('CARD_STORAGE_PATH');
        }else{
            $_filePath = WEB_ROOT_DIR . 'temp/cards';
        }
        $_filePath .= '/'.$this->cardInfo['templateInfo']['cardFolder'] . '/Images/'
            . $this->cardInfo['templateInfo']['BGURL'];
//        print_r($_filePath);die;
        if (is_file($_filePath)) {
            $bgImagePath = $_filePath;
            $bgImagePath =str_replace('\\','/',$bgImagePath);
        }

        return $bgImagePath;
    }


    /**
     * 从图片载入图片信息
     *
     * @param    string    $imagePath   图片路径
     * @return array 包含图片的高度，宽度，类型和操作句柄
     */
    protected function _loadImageInfo($imagePath)
    {
        $imageInfo = @getimagesize($imagePath);
        if(!$imageInfo) {
            trigger_error('Image file does not exist: ' . $imagePath, E_USER_ERROR);
            return;
        }

        $imageWidth = $imageInfo[0];
        $imageHeight = $imageInfo[1];
        $imageType = $imageInfo[2];
        //1 = GIF，2 = JPG，3 = PNG，4 = SWF，5 = PSD，
        //6 = BMP，7 = TIFF(intel byte order)，8 = TIFF(motorola byte order)，
        //9 = JPC，10 = JP2，11 = JPX，12 = JB2，13 = SWC，14 = IFF，15 = WBMP，
        //16 = XBM

        $typeList = array (1 => "gif", 2 => "jpeg", 3 => "png", 4 => "swf",
            5 => "psd", 6 => "bmp", 15 => "wbmp" );
        switch($imageType) {
            case 1:
            case 2:
            case 3:
            case 15:
                $funcName = 'imagecreatefrom' . $typeList[$imageType];
                $imageHandler = $funcName($imagePath);
                $imageType = $typeList[$imageInfo[2]];
                break;

            case 4:
            case 5:
            case 6:
                $imageContent = file_get_contents($imagePath);
                $imageHandler = @imageCreateFromString ( $imageContent );
                $imageType = $typeList[$imageInfo[2]];
                break;

            default:
                return;
                break;
        }
        $imageWidth = imagesx($imageHandler);
        $imageHeight = imagesy($imageHandler);

        $return = array('type'=>$imageType,
            'width'=>$imageWidth,
            'height'=>$imageHeight,
            'resource'=>$imageHandler
        );

        return $return;
    }

    /**
     * 将指定图片叠加到图像中，并允许缩放
     * @param string $imagePath 图片路径
     * @param bool $isBgImage 是否是背景图片， 背景图片将做平铺处理
     * @param int $startX 图片将要放置的 x轴信息
     * @param int $startY  图片将要放置的y轴信息
     * @param int $fromImageWidth 图片原来实际的显示宽度
     * @param int $fromImageHeight 图片原来实际的显示高度
     * @return boolean
     */
    protected function resizeAndMergeImage ($imagePath, $isBgImage=false,
                                            $startX=0, $startY=0,
                                            $fromImageWidth=0, $fromImageHeight=0,$rotate=0)
    {
        // 早入图片信息
        $imgInfo = $this->_loadImageInfo($imagePath);
        // 图像是否是原尺寸显示， 如果不是，用实际显示尺寸处理
        $imageOriginalWidth = $fromImageWidth ? $fromImageWidth : $imgInfo['width'];
        $imageOrginalHeight = $fromImageHeight ? $fromImageHeight : $imgInfo['height'];

        if ($isBgImage) { // 背景保持缩放
            $scale = 1;
        } else {
            $scale = $this->cardNewWidth / $this->cardOriginalWidth; // 设定等比例缩放
        }
        // 等比例计算缩放尺寸
        $newImgWidth = $imageOriginalWidth * $scale;
        $newImgHeight = $imageOrginalHeight * $scale;
        // 现将宽度进行缩放
        if ($newImgWidth > $this->cardNewWidth) {
            $newScale = $this->cardNewWidth / $newImgWidth;
            $newImgWidth = $this->cardNewWidth;
            $newImgHeight = $newImgHeight * $newScale; // 计算缩放后的图像高度
        }
        // 缩放后的图片高度， 仍然大于图像尺寸， 进一步缩放
        if ($newImgHeight > $this->cardNewHeight) {
            $newScale = $this->cardNewHeight / $newImgHeight;
            $newImgWidth = $newImgWidth * $newScale;
            $newImgHeight = $this->cardNewHeight;
        }
        if($isBgImage){//如果是背景图  需要使用平铺效果
            $heightnum = ceil($this->cardNewHeight / $newImgHeight);//判断垂直方向要平铺多少
            $widthnum = ceil($this->cardNewWidth / $newImgWidth);//判断水平方向要平铺多少
            for($i=0;$i<=$widthnum;$i++){
                $result = imagecopyresampled ( $this->imgResource, $imgInfo['resource'] , // resource $dst_image , resource $src_image ,
                    $startX+($i*$newImgWidth), $startY, //int $dst_x , int $dst_y ,
                    0, 0, //int $src_x , int $src_y ,
                    $newImgWidth, $newImgHeight, //int $dst_w , int $dst_h ,
                    $imgInfo['width'], $imgInfo['height']//int $src_w , int $src_h
                );
                for($j=0;$j<=$heightnum;$j++){
                    $result = imagecopyresampled ( $this->imgResource, $imgInfo['resource'] , // resource $dst_image , resource $src_image ,
                        $startX+($i*$newImgWidth), $startY+($j*$newImgHeight), //int $dst_x , int $dst_y ,
                        0, 0, //int $src_x , int $src_y ,
                        $newImgWidth, $newImgHeight, //int $dst_w , int $dst_h ,
                        $imgInfo['width'], $imgInfo['height'] //int $src_w , int $src_h
                    );
                }
            }
            return $result;

        }


//         $result = imagecopyresized ( $this->imgResource, $imgInfo['resource'] , // resource $dst_image , resource $src_image ,
//                            $startX, $startY, //int $dst_x , int $dst_y ,
//                            0, 0, //int $src_x , int $src_y ,
//                            $newImgWidth, $newImgHeight, //int $dst_w , int $dst_h ,
//                            $imgInfo['width'], $imgInfo['height'] //int $src_w , int $src_h
//         );
        // 这个函数效果更好
        list($thiswidth,$thisheight,$type) = @getimagesize($imgInfo['resource']);
        switch ($type) {
            case IMAGETYPE_GIF:
                $imgInfo['resource'] = imagecreatefromgif($imgInfo['resource']);
                break;
            case IMAGETYPE_JPEG:
                $imgInfo['resource']= imagecreatefromjpeg($imgInfo['resource']);
                break;
            case IMAGETYPE_PNG:
                $imgInfo['resource']= imagecreatefrompng($imgInfo['resource']);
                break;
        }
        $rotate = abs($rotate-360);
        $imgInfo['resource'] = imagerotate($imgInfo['resource'], $rotate,imageColorAllocateAlpha($imgInfo['resource'],0,0,0,127));

        $result = imagecopyresampled ( $this->imgResource, $imgInfo['resource'] , // resource $dst_image , resource $src_image ,
            $startX, $startY, //int $dst_x , int $dst_y ,
            0, 0, //int $src_x , int $src_y ,
            $newImgWidth, $newImgHeight, //int $dst_w , int $dst_h ,
            imagesx($imgInfo['resource']), imagesy($imgInfo['resource'])//int $src_w , int $src_h
        );

        return $result;
    }

    /**
     * 初始化画布
     */
    protected function _initCanvas ()
    {
        // Create the image
        $this->imgResource = imagecreatetruecolor($this->cardNewWidth, $this->cardNewHeight);
        $bg = $this->_getCardBgColor();
        $this->drawBackground($bg);
    }

    /**
     * 设置名片信息数据
     * @param array $cardInfo 名片信息数据： 可以是解析后的名片数据， 或者是用vcard和zip文件，重新解析
     * @return CardImage
     */
    public function setCardInfo ($cardInfo)
    {
        if (is_array($cardInfo)) {
            if (isset($cardInfo['templateInfo'])) { // 设置解析后的图片数据
                $this->cardInfo = $cardInfo;
            } else if (isset($cardInfo['vcf'], $cardInfo['cardZipPath'])
                && is_file($cardInfo['cardZipPath']) ) { // 解析vcard和zip
                import('CardOperator', LIB_ROOT_PATH . '/Classes');
                $cardOperator = new CardOperator(array('cardBgurlThumb'=>false));
                $this->cardInfo = $cardOperator->parseCard($cardInfo['vcf'], $cardInfo['cardZipPath']);
            }
        }
// 初始化画布
        $this->_initCanvas();
        return $this;
    }

    /**
     * 修改名片的原始宽度
     * @param int $fromWidth 名片的原始宽度
     * @return CardImage
     */
    public function setCardWidth($fromWidth)
    {
        if (is_numeric($fromWidth)) {
            $this->cardOriginalWidth = intval($fromWidth);
        }

        return $this;
    }

    /**
     * 修改名片的原始高度
     * @param int $fromHeight 名片的原始高度
     * @return CardImage
     */
    public function setCardHeight($fromHeight)
    {
        if (is_numeric($fromHeight)) {
            $this->cardOriginalHeight = intval($fromHeight);
        }

        return $this;
    }

    /**
     * 设置名片图像的宽度
     * @param int $toWidth 名片图片的宽度
     * @return CardImage
     */
    public function setCardNewWidth($toWidth)
    {
        if (is_numeric($toWidth)) {
            $this->cardNewWidth = intval($toWidth);
        }

        return $this;
    }

    /**
     * 设置名片图像的高度
     * @param int $toHeight 名片图片的高度
     * @return CardImage
     */
    public function setCardNewHeight($toHeight)
    {
        if (is_numeric($toHeight)) {
            $this->cardNewHeight = intval ($toHeight);
        }

        return $this;
    }

    /**
     * 画背景： 颜色或者背景图像
     * @param mixed $background 颜色的RGB数组或者是背景图片路径
     */
    public function drawBackground($background)
    {

        // 背景图片
        if (is_string($background) && is_file($background)) {
            $this->resizeAndMergeImage($background, true);
            return;
        }

        // 背景颜色
        if (!is_array($background) || !isset($background['red'])) {
            $background = array('red'=>255, 'green'=>255, 'blue'=>255);
        }

        // Create some colors
        $bgColor = imagecolorallocate($this->imgResource, $background['red'], $background['green'], $background['blue']);
//        $alpha = imagecolorallocatealpha($this->imgResource, 255, 255, 255, 0.795);
        imagefilledrectangle($this->imgResource, 0, 0, $this->cardNewWidth, $this->cardNewHeight, $bgColor);

        return;
    }

    /**
     * 保存生成的名片图片到指定路径
     */
    public function saveCardImageIntoFile ($imagePath)
    {

    }

    /**
     * 将名片数据画入名片图片
     */
    protected function _drawCard()
    {
        // draw background
        $bg = $this->_getCardBgImage();
        if (! $bg) {

            $bg = $this->_getCardBgColor();
        }
        if (!is_array($bg) || $bg['red']!=255 || $bg['green']!=255 || $bg['blue']!=255) {
            $this->drawBackground($bg);
        }
        //var_dump($this->cardInfo);exit;
        // draw card pictures
        $this->drawCardPictures();
        // draw text
        $this->drawCardText();

    }
    /**
     * 直接输出图片
     * @param string $savename 图片保存的路径
     * @param boolean $re 是否直接展示： 默认展示
     */
    public function printCardImage ($savename='',$re=true)
    {
        $this->_drawCard();
        if (is_resource($this->imgResource)) {
            // 判断浏览器,若是IE就不发送头
            
            if ($re && isset ( $_SERVER ['HTTP_USER_AGENT'] )) {
                $ua = strtoupper ( $_SERVER ['HTTP_USER_AGENT'] );
                if (! preg_match ( '/^.*MSIE.*\)$/i', $ua )) {
                    header ( "Content-type: image/png" );
                }
            }
            if(empty($savename)){
                $savename = './temp/upload/background.png';
            }
            //对整个名片设置不透明度度
            $templateInfo = $this->cardInfo['templateInfo'];
            $templateInfo = isset($templateInfo['ALPHA'])?$templateInfo['ALPHA']:0;
            $opacity = round((1-$templateInfo)*100);
            $imgsrc = imagecreatetruecolor($this->cardNewWidth,$this->cardNewHeight);
            $yellow = imagecolorallocate($imgsrc, 255, 255, 255);
            imagefilledrectangle($imgsrc, 0, 0, $this->cardNewWidth, $this->cardNewHeight, $yellow);
            imagecopymerge($this->imgResource,$imgsrc,0,0,0,0,$this->cardNewWidth,
                $this->cardNewHeight,$opacity);
            imagepng($this->imgResource,$savename);
        }
    }

    /**
     * 画名片的文本信息
     */
    protected function drawCardText ()
    {

        if (! isset($this->cardInfo['textGroupStyle'], $this->cardInfo['textItem'])) {
            return;
        }
        // 根据名片文本的分组信息，画文本
        foreach ($this->cardInfo['textGroupStyle'] as $_textInfo) {
            // 转换数组键值大小写： i DO really not like the upper case key name
            $style = array_change_key_case($_textInfo['style'], CASE_LOWER);
            $textList = array();
            foreach ($_textInfo['items'] as $_itemKey) {
                if (! isset($this->cardInfo['textItem'][$_itemKey])) {
                    continue;
                }
                $_tmpTextInfo = $this->cardInfo['textItem'][$_itemKey];
//                print_r($_tmpTextInfo);die;
                // 不可编辑 或者不可见的文本， 略过
//                if (!$_tmpTextInfo['editable'] || !$_tmpTextInfo['visible']) {
                /*目前数据只要有visible的就显示到图片上  所以我先把“或”的前半部分去掉了*/
                if (($_tmpTextInfo['visible'] ==false || $_tmpTextInfo['visible'] =='false') && $_tmpTextInfo['visible'] != 1 ){
                    continue;
                }
                // 空文本略过
                if (''===$_tmpTextInfo['value']) {
                    continue;
                }
                $_tmpString = $_tmpTextInfo['value'];
                // 需要label， 将label加入到文本中
                if ($style['label']=='true') {
                    $_tmpString = $_tmpTextInfo['label'] . ':' . $_tmpString;
                }
                $textList[] = $_tmpString;
            }
            if ($textList) {
                $this->drawText($textList, $style);
            }
        }
        //exit;
    }

    /**
     * 设置字体存放的路径
     * @param string $dirPath 字体存放路径
     * @return CardImage
     */
    public function setFontDir ($dirPath)
    {
        if (is_dir($dirPath)) {
            $this->fontFileDir = realpath($dirPath) . DIRECTORY_SEPARATOR;
        }

        return $this;
    }

    /**
     * 设置字体关键字和字体文件的影射关系
     * @param array $fontMaps 字体映射数组
     * @return CardImage
     */
    public function setFontMaps ($fontMaps)
    {
        if (is_array($fontMaps)) {
            $this->_fontMaps = $fontMaps;
        }
        return $this;
    }

    /**
     * 根据指定的字体， 获取字体文件的路径信息
     * @param string $font 字体文件名
     * @return int|string
     */
    protected function getFont ($font=null)
    {
        $_font = $this->defaultFont;
        if (!$font) {
            $_font = $this->defaultFont;
        }else if (in_array($font, array(1,2,3,4,5)) ) { // php 内置字体
            $_font = $font;
        }else if (file_exists($this->fontFileDir . $font)) {
            $_font = $this->fontFileDir . $font;
        }else if (is_string($font) && isset($this->_fontMaps[$font])
            && file_exists($this->fontFileDir . $this->_fontMaps[$font]) ) {
            $_font = $this->fontFileDir . $this->_fontMaps[$font];
        }
//        if(!file_exists($_font)){
//            $_font = $this->fontFileDir.'CFangSongPRC-Light.ttf';
//        }
        return $_font;
    }

    /**
     * 转换字号的表示形式， 将pixel转成point.
     * 因为GD1用pixel， GD2用point
     * @param int $pixel 字号的pixel值
     * @return number
     */
    public function fontPixel2Point ($pixel)
    {
        $point = $pixel = intval($pixel);
        for ($i=$pixel; $i>0; $i=$i-0.5) {
            if (intval(($i/72)*96)==$pixel) {
                $point = $i;
                break;
            }
        }

        return $point;
    }

    /**
     * 将文本画到的图像中
     * @param array $textContent 文本数组列表
     * @param array $styleInfo 文本的样式列表
     */
    public function drawText ($textContent, $styleInfo)
    {
        // 获取字体文件
//        if(isset($styleInfo['font'])){
//            $font = $this->getFont($styleInfo['font']);
//        }else{
//            $font = $this->getFont(null);
//        }
		if(is_file(C('CARD_DEFAULT_FONT'))){
			$font = C('CARD_DEFAULT_FONT');
		}else{
			$font = $this->getFont(null);
		}
        
//         print_r($font);die;
        // 获取原始的字号， 文字颜色， 位置信息
        $fontSize = empty($styleInfo['size']) ? $this->defaultFontSize : $styleInfo['size'];
        $fontColor = empty($styleInfo['color']) ? $this->defaultFontColor : $styleInfo['color'];
        if(strpos($fontColor, 'rgb') !==false){
            $fontColor = strtolower($fontColor);
            $fontColor = trim(trim($fontColor), 'rgb()');
            $fontColor = explode(',', $fontColor);
            list($r,$g,$b) = $fontColor;
            $fontColor = array('red'=>$r,'green'=>$g,'blue'=>$b);
        }else{
            $fontColor = \Classes\GFunc::hex2rgb($fontColor);
        }
        $textSizeList = array();
        $startX = $styleInfo['minx'] > 0 ? $styleInfo['minx'] : 0;
        $startY = $styleInfo['miny'] > 0 ? $styleInfo['miny'] : 0;
        //var_dump($startX, $startY,$textContent);
        // 计算缩放比例
        $heightScale = $this->cardNewHeight / $this->cardOriginalHeight;
        $widthScale  = $this->cardNewWidth / $this->cardOriginalWidth;
        // 计算实际的位置信息， 字号
        $startX = $startX * $widthScale;
        $startY = $startY * $heightScale;
        $fontSize = $fontSize * $widthScale;
        if (intval(GD_VERSION)>1) { // GD 版本 >=2, 字体大小用 point 单位， <1, 用pixel
            $fontSize = $this->fontPixel2Point($fontSize);
        }
        $maxWidth = 0;
        $maxHeight = 0;
        $previousLineHeight = 0;
        foreach ($textContent as $_textString) {
            if (is_numeric ( $font )) {
                // 计算字体所占宽高
                $_width = imagefontwidth ( $fontSize ) * strlen ( $_textString );
                $_height = imagefontheight ( $fontSize )+5;//5是行间距
            } else {
                $fontSizes = imagettfbbox ( intval($fontSize), 0, $font, $_textString );
                $_width = abs ( $fontSizes [0] - $fontSizes [2] );
                $_height = abs ( $fontSizes [7] - $fontSizes [1] )+5*4;//5是行间距
            }
            $maxWidth = $maxWidth > $_width ? $maxWidth : $_width;//分组中最长的宽度
            $textSizeList[] = array($_width, $_height);
        }
        // 设定文字颜色
        $color =imagecolorallocate($this->imgResource, $fontColor['red'], $fontColor['green'], $fontColor['blue']);
        $black=imagecolorallocate($this->imgResource,50,50,50);
        // 文本画入图像
        $index = 0;
        //var_dump($font);
        $styleInfo['align'] = strtolower($styleInfo['align']);
        foreach ($textContent as $_textString) {
            $textSizeInfo = $textSizeList[$index++];
            $previousLineHeight = $previousLineHeight + $textSizeInfo[1];
            /*设置右对齐*/
            if($styleInfo['align'] == 'right'){
//  开始数据               $_startX = $startX + $maxWidth - $textSizeInfo[0];   
                $_startX = $this->cardNewWidth - $textSizeInfo[0] - 55*$widthScale; // 临时修改适合当前模板
            }else if($styleInfo['align'] == 'center'){
                /*设置居中对齐*/
                $_startX = $startX + ($maxWidth-$textSizeInfo[0])/2;
            }else{
                /*设置左对齐*/
                $_startX = $startX;
            }
            $_startY = $startY + $previousLineHeight;
            if (is_numeric ($font)) {
                imagestring ( $this->imgResource, $font, $_startX, $_startY, $_textString, $color);
                /*给文字添加阴影*/
                if($styleInfo['shadow']=='true'){
                    imagestring ( $this->imgResource, $font, $_startX+1, $_startY+1, $_textString, $black);
                }
            } else {
                imagettftext ( $this->imgResource, $fontSize, 0, $_startX, $_startY, $color, $font, $_textString);
                /*给文字添加阴影*/
                if($styleInfo['shadow']=='true'){
                    imagettftext ( $this->imgResource, $fontSize, 0, $_startX+1, $_startY+1, $black, $font, $_textString);
                }

            }
        }
        //exit;
    }

    /**
     * 将名片中的图片， 画入图像
     * @return void
     */
    protected function drawCardPictures ()
    {
        if (empty($this->cardInfo['picGroup'])) {
            return;
        }
        // 计算缩放尺寸
        $heightScale = $this->cardNewHeight / $this->cardOriginalHeight;
        $widthScale  = $this->cardNewWidth / $this->cardOriginalWidth;
        $picturesList = & $this->cardInfo['picGroup'];
        $imageFolder = WEB_ROOT_DIR . 'temp/cards/'
            . $this->cardInfo['templateInfo']['cardFolder'] . '/Images/';

        // 等比例将图片画入图像
        $isBgImage = false;
        foreach ($picturesList as $_picInfo) {
            $startX = $_picInfo['style']['MINX'] * $widthScale;
            $startY = $_picInfo['style']['MINY'] * $heightScale;
            $width = $_picInfo['style']['WIDTH'];
            $height = $_picInfo['style']['HEIGHT'];
            $rotate = $_picInfo['style']['ROTATE'];
            $imagePath = $imageFolder . $_picInfo['items'][0]['path'];
            $imagePath =str_replace('\\','/',$imagePath);
//            print_r($imagePath);die;
            if (! is_file($imagePath)) {
                continue;
            }
            $this->resizeAndMergeImage($imagePath, $isBgImage, $startX, $startY, $width, $height,$rotate);
        }
    }

}

/* EOF */
