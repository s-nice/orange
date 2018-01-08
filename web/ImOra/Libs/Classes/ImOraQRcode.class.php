<?php
/**
 * 二维码增加主题颜色参数
 * @author jiyl
 * 引入PHP ImOraQR库文件
		include_once LIB_ROOT_PATH."Classes/ImOraQRcode.class.php";
		\ImOraQRcode::png('二维码携带信息','二维码颜色的rgb数组值','输出二维码信息到指定文件','容错率','二维码图片大小','二维码边框空白区域值','是否保存生成文件');
 */
include_once LIB_ROOT_PATH."3rdParty/phpqrcode/phpqrcode.php";
class ImOraQRcode extends QRcode{
	public static function png($text, $color=array(), $outfile = false, $level = QR_ECLEVEL_L, $size = 3, $margin = 4, $saveandprint=false)
	{
		$enc = ImOraQRencode::ImOraFactory($level, $size, $margin,$color);
		return $enc->ImOraEncodePNG($text, $outfile, $saveandprint=false);
	}
}
class ImOraQRencode extends QRencode{
	public $color;
	public static function ImOraFactory($level = QR_ECLEVEL_L, $size = 3, $margin = 4,$color=array())
	{
		$enc = new ImOraQRencode();
		$enc->size = $size;
		$enc->margin = $margin;
		$enc->color = count($color) != 3?array('0','0','0'):$color;
	
		switch ($level.'') {
			case '0':
			case '1':
			case '2':
			case '3':
				$enc->level = $level;
				break;
			case 'l':
			case 'L':
				$enc->level = QR_ECLEVEL_L;
				break;
			case 'm':
			case 'M':
				$enc->level = QR_ECLEVEL_M;
				break;
			case 'q':
			case 'Q':
				$enc->level = QR_ECLEVEL_Q;
				break;
			case 'h':
			case 'H':
				$enc->level = QR_ECLEVEL_H;
				break;
		}
	
		return $enc;
	}
	public function ImOraEncodePNG($intext, $outfile = false,$saveandprint=false)
	{
		try {
	
			ob_start();
			$tab = $this->encode($intext);
			$err = ob_get_contents();
			ob_end_clean();
	
			if ($err != '')
				QRtools::log($outfile, $err);
	
			$maxSize = (int)(QR_PNG_MAXIMUM_SIZE / (count($tab)+2*$this->margin));
	
			ImOraQRimage::png($tab, $outfile, min(max(1, $this->size), $maxSize), $this->margin,$saveandprint,$this->color);
	
		} catch (Exception $e) {
	
			QRtools::log($outfile, $e->getMessage());
	
		}
	}
}
class ImOraQRimage extends QRimage{

	//----------------------------------------------------------------------
	public static function png($frame, $filename = false, $pixelPerPoint = 4, $outerFrame = 4,$saveandprint=FALSE,$color=array('0','0','0'))
	{
		$image = self::imageForColor($frame, $pixelPerPoint, $outerFrame,$color);
	
		if ($filename === false) {
			Header("Content-type: image/png");
			ImagePng($image);
		} else {
			if($saveandprint===TRUE){
				ImagePng($image, $filename);
				header("Content-type: image/png");
				ImagePng($image);
			}else{
				ImagePng($image, $filename);
			}
		}
	
		ImageDestroy($image);
	}
	//----------------------------------------------------------------------
	private static function imageForColor($frame, $pixelPerPoint = 4, $outerFrame = 4,$color)
	{
		$h = count($frame);
		$w = strlen($frame[0]);
	
		$imgW = $w + 2*$outerFrame;
		$imgH = $h + 2*$outerFrame;
	
		$base_image =ImageCreate($imgW, $imgH);
	
		$col[0] = ImageColorAllocate($base_image,255,255,255);
		$col[1] = ImageColorAllocate($base_image,$color[0],$color[1],$color[2]);
	
		imagefill($base_image, 0, 0, $col[0]);
	
		for($y=0; $y<$h; $y++) {
			for($x=0; $x<$w; $x++) {
				if ($frame[$y][$x] == '1') {
					ImageSetPixel($base_image,$x+$outerFrame,$y+$outerFrame,$col[1]);
				}
			}
		}
	
		$target_image =ImageCreate($imgW * $pixelPerPoint, $imgH * $pixelPerPoint);
		ImageCopyResized($target_image, $base_image, 0, 0, 0, 0, $imgW * $pixelPerPoint, $imgH * $pixelPerPoint, $imgW, $imgH);
		ImageDestroy($base_image);
	
		return $target_image;
	}
	
}