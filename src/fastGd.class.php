<?php
/**
 * Class to word with GD library.
 * example: fastGd::source('/my/file.gif')->thumb(100)->output();
 * @author karrikas
 * @package fast-code-php
 * @subpackage fastGd
 * @category class
 */
class fastGd
{
	/**
	 * Original image path.
	 * @var string
	 */
	var $strPath;
	
	/**
	 * Original image width.
	 * @var integer
	 */
	var $intWidth;
	
	/**
	 * Original image height.
	 * @var integer
	 */
	var $intHeight;
	
	/**
	 * Original image type: 
	 * 1 = gif
	 * 2 = jpg
	 * 3 = png
	 * @var integer
	 */
	var $intType;
	
	/**
	 * Mine type from image source.
	 * @var string
	 */
	var $strMine;
	
	/**
	 * Original gd source
	 * @var binary
	 */
	var $bSource;
	
	/**
	 * Transformed image source.
	 * @var binary
	 */
	var $bNewSource;

	/**
	 * Get source from image path. Initial method.
	 * 
	 * @param 	string 		$strPath 	Original file path
	 * @return fastGd
	 */
	static public function source($strPath){
		$fastGd = new fastGd();
		$fastGd->getSource($strPath);
		return $fastGd;
	}
	
	/**
	 * Get image with fixed size.
	 * @param integer $intWidth
	 * @param integer $intHeight
	 * @return fastGd
	 */
	public function fixedSize($intWidth, $intHeight) {
		
		if($intWidth < $this->intWidth || $this->intHeight > $intHeight) {
			
			if($this->intWidth / $intWidth > $this->intHeight / $intHeight){
				$ratio = $intWidth / $this->intWidth;
			}else{
				$ratio = $intHeight / $this->intHeight;
			}
		
			$img_w 	= round($ratio * $this->intWidth);
			$img_h 	= round($ratio * $this->intHeight);
			
			$dist_x = ($intWidth - $img_w) / 2;
			$dist_y = ($intHeight - $img_h) / 2;
			
		} else {
			
			$img_w = $this->intWidth;
			$img_h = $this->intHeight;
			
			$dist_x = ($intWidth - $img_w) / 2;
			$dist_y = ($intHeight - $img_h) / 2;
		}
		
		// create empty image
		$bNewSource = imagecreatetruecolor( $intWidth, $intHeight );
		
		// set background color
		$color = imagecolorallocate($bNewSource, 0xFF, 0xFF, 0xFF);
		imagefilledrectangle($bNewSource, 0, 0, $intWidth, $intHeight, $color);
		
		// Image with new size
		imagecopyresampled($bNewSource, $this->bSource, $dist_x, $dist_y, 0, 0, $img_w, $img_h, $this->intWidth, $this->intHeight);
		
		$this->bNewSource = $bNewSource;
		
		return $this;
	}
	
	/**
	 * Get image with fixed size, original image will be cut in center.
	 * @param integer $intWidth
	 * @param integer $intHeight
	 */
	public function fixedSizeCrop($intWidth, $intHeight) {
		
		$src_x = ($this->intWidth - $intWidth) / 2;
		$src_y = ($this->intHeight - $intHeight) / 2;;
		
		// create empty image
		$bNewSource = imagecreatetruecolor( $intWidth, $intHeight );
		
		// set background color
		$color = imagecolorallocate($bNewSource, 0xFF, 0xFF, 0xFF);
		imagefilledrectangle($bNewSource, 0, 0, $intWidth, $intHeight, $color);
		
		// Image with new size
		imagecopyresampled($bNewSource, $this->bSource, 0, 0, $src_x, $src_y, $this->intWidth, $this->intHeight, $this->intWidth, $this->intHeight);
		
		$this->bNewSource = $bNewSource;
		
		return $this;
	}

	/**
	 * Get a square image.
	 *
	 * @param 	integer 	$intSize	Square size in px
	 * @return fastGd
	 */
	public function thumb($intSize){

		// get size for cut image without deformation
		$x = ($intSize * 100) / $this->intWidth;
		$y = ($intSize * 100) / $this->intHeight;
		
		if ($x == $y){
			$intWidth = $this->intWidth;
			$intHeight = $this->intHeight;
		} elseif ($x > $y){
			$intWidth = $this->intWidth;
			$intHeight = ((($intSize * 100) / $intSize) * $this->intWidth) / 100;
		} elseif ($x < $y){
			$intWidth = ((($intSize * 100) / $intSize) * $this->intHeight) / 100;
			$intHeight = $this->intHeight;
		}
		
		// create empty image
		$bNewSource = imagecreatetruecolor($intSize, $intSize);

		// Image with new size
		imagecopyresampled($bNewSource, $this->bSource, 0, 0, 0, 0,
		$intSize, $intSize, $intWidth, $intHeight);

		$this->bNewSource = $bNewSource;

		return $this;
	}
	
	/**
	 * Rotate image
	 * @param string left|right
	 */
	public function rotate($angle) {		
		
		// rotate	
		$bNewSource = imagerotate($this->bSource, $angle, 0);
		
		// define output
		$this->bNewSource = $bNewSource;
		
		return $this;
	}

	/**
	 * Out image in script.
	 * @see setOutput();
	 */
	public function output($intQuality = 100){
		header("Content-Type: {$this->strMine}");
		$this->setOutput('', $intQuality);
	}
	
	/**
	 * Save result in a file.
	 * @param 	string 		$strName	New image name.
	 * @see setOutput()
	 */
	public function save($strName = '', $intQuality = 100){
		
		if (empty($strName)){
			$strName = $this->strPath;
		} else {
			
			// XXX isn't the best solution
			$strName = preg_replace('/\.[^.]{3,4}$/', '', $strName);
			
			switch( $this->intType ){
				case 1:
					$strName = "$strName.gif";
					break;
				case 2:
					$strName = "$strName.jpg";
					break;
				case 3:
					$strName = "$strName.png";
					break;
				default:
					// none;
			}
		}
		
		$this->setOutput($strName, $intQuality = 100);
		
		return $strName;
	}

	/**
	 * End output method.
	 *
	 * @param 	string		$strName		Name to save image, empty for output.
	 * @param 	integer 	$intQuality		Image quality.
	 */
	private function setOutput($strName = '', $intQuality = 100){
		switch( $this->intType ){
			case 1:
				imagegif($this->bNewSource, $strName);
				break;
			case 2:
				imagejpeg($this->bNewSource, $strName, $intQuality);
				break;
			case 3:
				imagepng($this->bNewSource, $strName, $intQuality);
				break;
			default:
				// none;
		}
		
		return $strName;
	}

	/**
	 * Get image source from GD.
	 *
	 * @param 	string 		$strPath 	Original file path
	 * @return 	void
	 */
	private function getSource($strPath){
		$this->strPath = $strPath;
		$this->getInfo();

		switch( $this->intType ){
			case 1:
				$bSource = imagecreatefromgif($this->strPath);
				break;
			case 2:
				$bSource = imagecreatefromjpeg($this->strPath);
				break;
			case 3:
				$bSource = imagecreatefrompng($this->strPath);
				break;
			default:
				throw new Exception("Dont know image type [$type]");
		}
		$this->bSource = $bSource;
	}

	/**
	 * Get image information to share with class.
	 */
	private function getInfo(){
		
		list(
			$this->intWidth, 
			$this->intHeight,
			$this->intType, 
			$attr
		) = getimagesize( $this->strPath );
	}
}