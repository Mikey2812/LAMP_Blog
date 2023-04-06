<?php
class vendor_simpleImage_component {
	public $image;
	public $new_image;
	//public $type;
	public $w;
	public $h;
	public $quality = 80;
	public $imgfunc = 'imagejpeg';
	//public $imgfunc_create = 'imagecreatefromjpeg';
	function __construct($filename) {
		$image_info = getimagesize($filename);
		$this->w 	= $image_info[0];
		$this->h 	= $image_info[1];
		$intType	= $image_info[2];
		//$this->type	= $image_info["mime"];
		switch ($intType) {
	        case IMAGETYPE_GIF:
	            $imgfunc_create = "imagecreatefromgif";
	            $this->imgfunc = "imagegif";
	            break;
	        case IMAGETYPE_PNG:
	            $imgfunc_create = "imagecreatefrompng";
	            $this->imgfunc = "imagepng";
	            $this->quality = 7;
	            break;
	        case IMAGETYPE_JPEG:
	            $imgfunc_create = "imagecreatefromjpeg";
	            $this->imgfunc = "imagejpeg";
	            $this->quality = 80;
	            break;
		    default:
		        break;
		}
		$this->image = $imgfunc_create($filename);
	}

	function resizeToHeight($h) {
		$ratio = $h / $this->h;
		$w = $this->w * $ratio;
		$this->resize($w,$h);
    }
 
	function resizeToWidth($w) {
		$ratio = $w / $this->w;
		$h = $this->h * $ratio;
		$this->resize($w,$h);
	}
 
	function scale($scale) {
		$w = $this->w * $scale/100;
		$h = $this->h * $scale/100;
		$this->resize($w,$h);
	}
 
	function resize($nw,$nh) {
		$this->new_image = imagecreatetruecolor($nw,$nh);
		$color = imagecolorallocatealpha($this->new_image, 0, 0, 0, 127); 	//	Tranperant
		imagefill($this->new_image, 0, 0, $color);
		imagesavealpha($this->new_image, true);

		imagecopyresampled($this->new_image, $this->image, 0, 0, 0, 0, $nw, $nh, $this->w, $this->h);
		$this->image = $this->new_image;
	}

	function crop($nw, $nh, $sx=0, $sy=0){
		$this->new_image = imagecreatetruecolor($nw,$nh);
		$color = imagecolorallocatealpha($this->new_image, 0, 0, 0, 127); 	//	Tranperant
		imagefill($this->new_image, 0, 0, $color);
		imagesavealpha($this->new_image, true);
		
	    if($sx && $sy) {
			imagecopyresampled($this->new_image, $this->image, 0, 0, $sx, $sy, $nw, $nh, $this->w, $this->h);
	    } else {
			$width_new  = $this->h * $nw / $nh;
		    $height_new = $this->w * $nh / $nw;
	    	if($width_new > $this->w){
		        //cut point by height
		        $h_point = (($this->h - $height_new) / 2);
		        //copy image
		        imagecopyresampled($dimg, $simg, 0, 0, 0, $h_point, $mw, $mh, $w, $height_new);
		    }else{
		        //cut point by width
		        $w_point = (($this->w - $width_new) / 2);
		        imagecopyresampled($dimg, $simg, 0, 0, $w_point, 0, $mw, $mh, $width_new, $h);
		    }
		}
	}
   
	function save($filename, $type=IMAGETYPE_JPEG, $compression=75, $permissions=null) {
		switch ($type) {
			case IMAGETYPE_JPEG:
				imagejpeg($this->image,$filename,$compression);
        		break;
			case IMAGETYPE_GIF:
				imagegif($this->image,$filename);
        		break;
			case IMAGETYPE_PNG:
				imagepng($this->image,$filename);
        		break;
		    default:
		        break;
		}
		if( $permissions != null) {
			chmod($filename,$permissions);
		}
	}
   
	function output($type=IMAGETYPE_JPEG) {
		switch ($type) {
			case IMAGETYPE_JPEG:
				imagejpeg($this->image);
        		break;
			case IMAGETYPE_GIF:
				imagegif($this->image,$filename);
        		break;
			case IMAGETYPE_PNG:
				imagepng($this->image,$filename);
        		break;
		    default:
		        break;
		}
	}
   
	function saveResize($filename, $permissions=null) {
		$imgfunc = $this->imgfunc;
		$imgfunc($this->image,$filename, $this->quality);
		if( $permissions != null) {
			chmod($filename,$permissions);
		}
	}
   
}
?>