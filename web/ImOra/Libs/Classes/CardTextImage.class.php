<?php
/**
 * 根据名片文字信息生成图片
 *
 */

/**
 * 名片文字图片生成类
 *
 */
class CardTextImage
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
    protected $cardOriginalWidth = 100; // in px
    /*
     * 名片原始高度
     * @var int
     */
    protected $cardOriginalHeight = 100; // in px
    /*
     * 待生成的名片图片宽度
     * @var int
     */
    protected $cardWidth = 87;       // in px
    /*
     * 待生成的名片图片高度
     * @var int
     */
    protected $cardHeight = 44;      // in px

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
    public function __construct ($cardWidth=null, $cardHeight=null)
    {
        $this->setCardWidth ($cardWidth);
        $this->setCardHeight ($cardHeight);

    }

    /**
     * 获取名片背景颜色， 转换成RGB数据
     * @return array
     */
    protected function _getCardBgColor ()
    {
        $color = array('red'=>255, 'green'=>255, 'blue'=>255);
//        if (isset($this->cardInfo['templateInfo'], $this->cardInfo['templateInfo']['BGCOLOR'])) {
//            if(strlen($this->cardInfo['templateInfo']['BGCOLOR'])== 7){
//                $_tmpColor = GFunc::hex2rgb($this->cardInfo['templateInfo']['BGCOLOR']);
//                $color = $_tmpColor ? $_tmpColor : $color;
//            }else{
//                $_tmpColor = trim(trim($this->cardInfo['templateInfo']['BGCOLOR']), 'rgb()');
//                $_tmpColor = explode(',', $_tmpColor);
//                return array (
//                    'red' => $_tmpColor[0],
//                    'green' => $_tmpColor[1],
//                    'blue' => $_tmpColor[2]
//                );
//            }
//
//
//        }

        return $color;
    }



    /**
     * 初始化画布
     */
    protected function _initCanvas ()
    {
        // Create the image
        $this->imgResource = imagecreatetruecolor($this->cardWidth, $this->cardHeight);
//        $bg = $this->_getCardBgColor();
//        $this->drawBackground($bg);
    }

    /**
     * 设置名片信息数据
     * @param array $cardInfo 名片信息数据： 可以是解析后的名片数据， 或者是用vcard和zip文件，重新解析
     * @return CardImage
     */
    public function setCardInfo ($cardInfo)
    {
        if (is_array($cardInfo)) {
            $this->cardInfo = $cardInfo;
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
            $this->cardWidth = intval($fromWidth);
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
            $this->cardHeight = intval($fromHeight);
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
//        imagefilledrectangle($this->imgResource, 0, 0, $this->cardWidth, $this->cardHeight, $bgColor);
        //设置透明背景图
        imagecolortransparent($this->imgResource,$bgColor);

        imagefill($this->imgResource,0,0,$bgColor);
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
        $bg = $this->_getCardBgColor();
        $this->drawBackground($bg);
        $this->drawCardText();

    }
    /**
     * 直接输出图片
     */
    public function printCardImage ($savename='')
    {
        $this->_drawCard();
        if (is_resource($this->imgResource)) {
            // 判断浏览器,若是IE就不发送头
            if (isset ( $_SERVER ['HTTP_USER_AGENT'] )) {
                $ua = strtoupper ( $_SERVER ['HTTP_USER_AGENT'] );
                if (! preg_match ( '/^.*MSIE.*\)$/i', $ua )) {
                    header ( "Content-type: image/png" );
                }
            }
            if(empty($savename)){
                $savename = './temp/upload/background.png';
            }
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
//        foreach ($this->cardInfo['textGroupStyle'] as $_textInfo) {
            // 转换数组键值大小写： i DO really not like the upper case key name
            $style = array_change_key_case($this->cardInfo['textGroupStyle']['style'], CASE_LOWER);
            $textList = array();
            foreach ($this->cardInfo['textGroupStyle']['items'] as $_itemKey) {
                if (! isset($this->cardInfo['textItem'][$_itemKey])) {
                    continue;
                }
                $_tmpTextInfo = $this->cardInfo['textItem'][$_itemKey];
                // 不可编辑 或者不可见的文本， 略过
//                if (!$_tmpTextInfo['editable'] || !$_tmpTextInfo['visible']) {
                /*目前数据只要有visible的就显示到图片上  所以我先把“或”的前半部分去掉了*/
                if ($_tmpTextInfo['visible'] ==false || $_tmpTextInfo['visible'] =='false' ){
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
//        }
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
        if(isset($styleInfo['font'])){
            $font = $this->getFont($styleInfo['font']);
        }else{
            $font = $this->getFont(null);
        }
        $Scale = 556 / 1200;
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
            $fontColor = GFunc::hex2rgb($fontColor);
        }
        $textSizeList = array();
        $startX = $styleInfo['minx'] > 0 ? $styleInfo['minx'] : 0;
        $startY = $styleInfo['miny'] > 0 ? $styleInfo['miny'] : 0;
        $fontSize = $fontSize ;
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
                $_height = abs ( $fontSizes [7] - $fontSizes [1] )+5;//5是行间距
            }
            $maxWidth = $maxWidth > $_width ? $maxWidth : $_width;//分组中最长的宽度
            $maxWidth = $maxWidth+imagefontwidth ( $fontSize*4 );//中文字体宽度不够  所以多加两个字符宽度（写法不对，目前没找到方法先代替）
            $textSizeList[] = array($_width, $_height);
        }
        // 设定文字颜色
        $color =imagecolorallocate($this->imgResource, $fontColor['red'], $fontColor['green'], $fontColor['blue']);
        $black=imagecolorallocate($this->imgResource,50,50,50);
        // 文本画入图像
        $index = 0;
        //var_dump($font);
        foreach ($textContent as $_textString) {
            $textSizeInfo = $textSizeList[$index++];
            $previousLineHeight = $previousLineHeight + $textSizeInfo[1];
            /*设置右对齐*/
            if($styleInfo['align'] == 'right'){
                $_startX = $maxWidth - $textSizeInfo[0];
            }else if($styleInfo['align'] == 'center'){
                /*设置居中对齐*/
                $_startX = ($maxWidth-$textSizeInfo[0])/2;
            }else{
                /*设置左对齐*/
                $_startX = 0;
            }
            $_startX = $_startX;
            $_startY = $previousLineHeight;
            imagettftext ( $this->imgResource, $fontSize, 0, $_startX, $_startY, $color, $font, $_textString);

        }
        //exit;
    }


}

/* EOF */
