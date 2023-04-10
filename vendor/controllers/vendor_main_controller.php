<?php
class vendor_main_controller {
    private 	$data;
	protected 	$layout = "";
	protected 	$model; 
	protected 	$controller = "home";
	protected 	$action = "index";
	public	 	$components;
	protected 	$allowedExts = ["gif", "jpeg", "jpg", "png"];
	protected 	$isMobile;
	protected 	$records;
	protected 	$record;

	public function  __construct() {
		global $app;
		$this->controller = $app['ctl'];
		if(isset($app['act'])) $this->action = $app['act'];
		else $app['act'] = $this->action;
		$this->isMobile = false;
		$detect = new vendor_mobiledetect_helper();
		if ($detect->isMobile()){
			$this->isMobile = true;
		}
		if(method_exists($this, $this->action)) {
			if(isset($app['prs']) && count($app['prs'])) {
				$str = $this->toString($app['prs']);
				if (preg_match('/[\'\.\"]/', $str)) {
					include "views/".$app['areaPath']."staticpages/error.php";
					exit();
				}
				$this->{$this->action}($app['prs']);
			} else $this->{$this->action}();
		} else {
			include "views/".$app['areaPath']."staticpages/error.php";
		}
	}

	public function toString($arr){
		$str = '';
		foreach ($arr as $key => $value) {
			$str .= $value;
		}
		return $str;
	}
	public function display($options=null) {
		global $app;
		if(!isset($options['area']))	$options['area'] = $app['areaPath'];
		if(!isset($options['ctl']))		$options['ctl'] = $this->controller;
		if(!isset($options['act']))		$options['act'] = $this->action;
		$view = "views/".$options['area'].$options['ctl']."/".$options['act'].".php";
		if (is_file($view)) 
		include_once $view;
		else {
			$this->viewfile = $view;
			include_once "views/".$options['area']."staticpages/missingview.php";
		}
	}

	public function uploadImg1($files, $options, $defaultImgW = null) {
		$arrt	=	explode("/", $files["logo"]["type"]);
		$type	=	end($arrt);
		if (($files["logo"]["size"] < 200000000)
			&& in_array($type, $this->allowedExts)) {
			if ($files["logo"]["error"] > 0) {
				return false;
		    }
		    if(isset($options['folder'])) {
				if (!file_exists(RootURI.UploadREL .$options['folder'])) {
					mkdir(RootURI.UploadREL .$options['folder'], 0777, true);
				}
		    	$folder=$options['folder'];
		    } else {
		    	$folder=$this->controller;
		    }

			$ulfd = RootURI.UploadREL .$folder.'/'.date("Y/m/d").'/';
			if (!file_exists($ulfd)) {
				mkdir($ulfd, 0777, true);
			}
			$newfn = str_replace('/','-',date("Y/m/d")).'-'.time().rand(10000,99999).'.'.$type;

			$newSize = (isset($options['newSize']))? $options['newSize']: [];


		    if (!file_exists($ulfd . $newfn)) {
		    	// mkdir($ulfd . $newfn, 0777, true);  //create directory if not exist
			move_uploaded_file($files["logo"]["tmp_name"], $ulfd.$newfn);
				$simpleImg = new vendor_simpleImage_component($ulfd.$newfn);
				copy($ulfd.$newfn,$ulfd."origin_".$newfn);

				if(isset($newSize['height']) && !isset($newSize['width'])) {
					// echo "Start <br/>"; echo '<pre>'; print_r($newSize);echo '</pre>';exit("End Data");
					$simpleImg->resizeToHeight($newSize['height']);
				} else {
					$newW = $defaultImgW ? $defaultImgW : DefaultImgW;
					if(isset($newSize['width'])) {
						$newW = $newSize['width'];
					}
					$simpleImg->resizeToWidth($newW);
				}
				$simpleImg->saveResize($ulfd.$newfn);
		    }
			return date("Y/m/d").'/'.$newfn;
		} else {
			return false;
		}
	}
	public function uploadImg($files, $options = null, $name="image") {
		if($name == null && count($files) == 1) $name = array_keys($files)[0];

		$arrt	=	explode("/", $files[$name]["type"]);
		$type	=	end($arrt);
		// echo "Start <br/>"; echo '<pre>'; print_r($options);echo '</pre>';exit("End Data");
		if (($files[$name]["size"] < 200000000)
			&& in_array($type, $this->allowedExts)) {
			if ($files[$name]["error"] > 0) {
				return false;
		    }
		    if(isset($options['folder'])) {
		    	$folder=$options['folder'];
		    } else {
		    	$folder=$this->controller;
		    }
			$ulfd = RootURI.UploadREL .$folder.'/'.date("Y/m/d").'/';
			if (!file_exists($ulfd)) {
				mkdir($ulfd, 0777, true);
			}
			$newfn = str_replace('/','-',date("Y/m/d")).'-'.time().rand(10000,99999).'.'.$type;

			$newSize = (isset($options['newSize']))? $options['newSize']: [];

		    if (!file_exists($ulfd . $newfn)) {
			move_uploaded_file($files[$name]["tmp_name"], $ulfd.$newfn);
				$simpleImg = new vendor_simpleImage_component($ulfd.$newfn);

				if(isset($options['origin']) && $options['origin']) {
					
				}else{
					if(isset($newSize['height']) && !isset($newSize['width'])) {
						$simpleImg->resizeToHeight($newW);
					} else {
						$newW = DefaultImgW;
						if(isset($newSize['width'])) {
							$newW = $newSize['width'];
						}
						$simpleImg->resizeToWidth($newW);
						$simpleImg->saveResize($ulfd.$newfn);
					}
				}
		    }

			return date("Y/m/d").'/'.$newfn;
		} else {
			return false;
		}
	}

	public function uploadImgs($files, $options) {
		$returnData = [];
		foreach ($files as $key => $file) {
			$arrt	=	explode("/", $file["type"]);
			$type	=	end($arrt);

			if (($file["size"] < 200000000)
				&& in_array($type, $this->allowedExts)) {
				if ($file["error"] > 0) {
					return false;
			    }
			    if(isset($options['folder'])) {
			    	$folder = (count($options['folder']) > 1)? $options['folder'][$key]: $options['folder'];
			    } else {
			    	$folder=$this->controller;
			    }
				$ulfd = RootURI.UploadREL .$folder.'/'.date("Y/m/d").'/';
				if (!file_exists($ulfd)) {
					mkdir($ulfd, 0777, true);
				}
				$newfn = str_replace('/','-',date("Y/m/d")).'-'.time().rand(10000,99999).'.'.$type;

				$newSize = (isset($options['newSize']))? $options['newSize']: [];

			    if (!file_exists($ulfd . $newfn)) {
			    	// mkdir($ulfd . $newfn, 0777, true);  //create directory if not exist
				move_uploaded_file($file["tmp_name"], $ulfd.$newfn);
					$simpleImg = new vendor_simpleImage_component($ulfd.$newfn);

					if(isset($options['origin']) && $options['origin']) {
						
					}else{
						if(isset($newSize['height']) && !isset($newSize['width'])) {
							$simpleImg->resizeToHeight($newW);
						} else {
							$newW = DefaultImgW;
							if(isset($newSize['width'])) {
								$newW = $newSize['width'];
							}
							$simpleImg->resizeToWidth($newW);
							$simpleImg->saveResize($ulfd.$newfn);
						}
					}
			    }
			    $returnData[$key] = $newfn;
			}
		}

		if(count($returnData)) {
			return $returnData;
		} else {
			return false;
		}
	}

	public function base64_to_file($base64_string, $options = []) {
		if(isset($options['folder'])) {
	    	$folder=$options['folder'];
	    } else {
	    	$folder=$this->controller;
	    }

		$f = finfo_open();
		$spash_pos = strpos($base64_string, '/');
		$semi_colon_pos = strpos($base64_string, ';');
		
		if ($options['type_of_file']) {
			$type = $options['type_of_file'];
		} else {
			$type = substr($base64_string, $spash_pos + 1, $semi_colon_pos - $spash_pos - 1);
		}

	 	//    $ulfd = RootURI . UploadREL . $folder;
		// $newfn = time() . rand(10000, 99999) . '.' . $type;

		// if (!is_dir($ulfd)) {
		//  	mkdir($ulfd, 0775, true);
		// }
		// 
		$ulfd = RootURI.UploadREL .$folder.'/'.date("Y/m/d").'/';
		if (!file_exists($ulfd)) {
			mkdir($ulfd, 0777, true);
		}
		$newfn = str_replace('/','-',date("Y/m/d")).'-'.time().rand(10000,99999).'.'.$type;

	    file_put_contents($ulfd . '/' . $newfn, file_get_contents($base64_string));

	    return date("Y/m/d").'/'.$newfn;
	}
	
    public function setProperty($name, $value) {
        $this->$name = $value;
    }
    
    public function checkAuth () {
		global $app;
		if (isset($_COOKIE['remember_me'])) {
			$auth = new vendor_auth_model();
			$arr = explode(":", $_COOKIE["remember_me"]);
			$remember = ['remember_me_identify'	=> $arr[0],
					 'remember_me_token'	=> $arr[1]];
			if ($auth->login(null, true, $remember)) {
			} else {

			}
		}
		$_SESSION['link'] = $_GET['pr'];
		if (!isset($_SESSION['user']['email'])) {
			header( "Location: ".vendor_app_util::url(array('ctl'=>'login')));
			exit;
		}
    }
    
    public function checkPermissionRole($role) {
    	$this->checkAuth();
		global $app;
		$rolesFlip = array_flip($app['roles']);
		if (isset($_SESSION['user']['role']) && $_SESSION['user']['role'] == $rolesFlip[$role])
		 	return true;
		return false;
    }
}
?>