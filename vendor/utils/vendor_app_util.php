<?php
class vendor_app_util {
	public static function url($options=null) {
		if($options=='/')
			return 'index.php';
			
		global $app;
		if(!isset($options['area'])) {
			if($app["area"] == 'users')
				$options['area'] = '';
			else $options['area'] = $app["area"].'/';
		} else {
			$options['area'] = ($options['area'])? $options['area'].'/': '';
		}
		if(!isset($options['ctl'])) {
			$options['ctl'] = $app["ctl"];
		}
		$act = '';
		if(isset($options['act'])) {
			$act = '/'.$options['act'];
			//$options['act'] = $app['act'];
		}
		$params = '';
		if(isset($options['params']) and $options['params']) {
			foreach($options['params'] as $k=>$v) {
				$params .= (is_numeric($k))? '/'.$v: '/'.$k.'='.$v;

			}
		}
		return RootREL.$options['area'].$options['ctl'].$act.$params;
	}

	public static function purl($options=null, $p=1) {
		global $app;
		if(isset($app['prs'])) $options['params'] = $app['prs'];
		$options['params']['p'] = $p;
		return self::url($options);
	}

	public static function generatePassword ($strPass) {
		return md5($strPass);
	}
	
	public static function hashStr() {
		$identify = strtr(base64_encode(random_bytes(16)), '+', '.');
		$identify = sprintf("$2y$%02d$", 10) . $identify;
		return $identify;
	}

	public static function is_multi_array( $arr ) {
	    $rv = array_filter($arr,'is_array');
		rsort( $arr );
	    if(count($rv)>0) return true;
	    return false;
	}

	public static function timeToDateTime($time) {
		return date('Y-m-d').' '.$time.':00';
	}

	public static function sendMailContact($title, $content, $nTo, $mTo,$from,$addressCC='') {
		include_once ('libsSMTP/class.smtp.php');
		include_once ('libsSMTP/class.phpmailer.php');
		$nFrom = $from;
		$mFrom = PSCDEmail;	
		$mPass = PassEmail;		
		$mail             = new PHPMailer();
		$body             = $content;
		$mail->IsSMTP(); 
		$mail->CharSet 	= "utf-8";
		$mail->SMTPDebug  = 0;                     
		$mail->SMTPAuth   = true;                  
		$mail->SMTPSecure = "ssl";                 
		$mail->Host       = "smtp.gmail.com";      	
		$mail->Port       = 465;
		$mail->Username   = $mFrom;  
		$mail->Password   = $mPass;           
		$mail->SetFrom($mFrom, $nFrom);
		
		$ccmail = explode(',', $addressCC);
		$ccmail = array_filter($ccmail);
		if(!empty($ccmail)){
			foreach ($ccmail as $k => $v) {
				$mail->AddCC($v);
			}
		}

		$address = explode(',', $mTo);
		$address = array_filter($address);
		if(!empty($address)){
			foreach ($address as $k => $v) {
				$mail->AddAddress($v, $nTo);
			}
		}
		$mail->Subject    = $title;
		$mail->MsgHTML($body);
		$mail->AddReplyTo('noreply@vieclamdanang.vn', 'VIỆC LÀM ĐÀ NẴNG');
		if(!$mail->Send()) {
			return 0;
		} else {
			return 1;
		}
	}

	//public static function sendMail($title, $content, $nTo, $mTo,$addressCC='', $addressBCC="") {
	public static function sendMail($title, $content, $nTo, $mTo,$addressCC='') {
		include_once ('libsSMTP/class.smtp.php');
		include_once ('libsSMTP/class.phpmailer.php');
		$nFrom = 'PSCD Admin';
		$mFrom = PSCDEmail;	
		$mPass = PassEmail;		
		$mail             = new PHPMailer();
		$body             = $content;
		$mail->IsSMTP(); 
		$mail->CharSet 	= "utf-8";
		$mail->SMTPDebug  = 0;                     
		$mail->SMTPAuth   = true;                  
		$mail->SMTPSecure = "ssl";                 
		$mail->Host       = "smtp.gmail.com";      	
		$mail->Port       = 465;
		$mail->Username   = $mFrom;  
		$mail->Password   = $mPass;           
		$mail->SetFrom($mFrom, $nFrom);
		
		$ccmail = explode(',', $addressCC);
		$ccmail = array_filter($ccmail);
		if(!empty($ccmail)){
			foreach ($ccmail as $k => $v) {
				$mail->AddCC($v);
			}
		}
		/*
		$bccmail = explode(',', $addressBCC);
		$bccmail = array_filter($bccmail);
		if(!empty($bccmail)){
			foreach ($bccmail as $k => $v) {
				$mail->AddBCC($v);
			}
		}
		*/
		$address = explode(',', $mTo);
		$address = array_filter($address);
		if(!empty($address)){
			foreach ($address as $k => $v) {
				$mail->AddAddress($v, $nTo);
			}
		}
		$mail->Subject    = $title;
		$mail->MsgHTML($body);
		$mail->AddReplyTo('modi.bixa0@gmail.com', 'PSCD');
		if(!$mail->Send()) {
			return 0;
		} else {
			return 1;
		}
	}

	public static function validationEmail( $email ){
		$pattern = "/^[^&%; <~>!=\?\\\*\|\^#@\"\\(\)\-']+@[^&;% <~>!=\?\\\*\|\^#@\"\']+$/";
		$result = preg_match ($pattern, $email);
		if ( $result ) {
			return 1;
		} else {
			return 0;
		}
	}

	public static function sqlrToArray($sr) {
		$records = [];
		$records['data'] = [];
		if($sr) {
			while($row = $sr->fetch_assoc()) {
	    		$records['data'][] = $row;
	    	}
		}
		$records['norecords'] 	= count($records['data']);
		return $records;
	}

	public static function gen_slug($str) {
		// $a = array('À','Á','Â','Ã','Ä','Å','Æ','Ç','È','É','Ê','Ë','Ì','Í','Î','Ï','Ð','Ñ','Ò','Ó','Ô','Õ','Ö','Ø','Ù','Ú','Û','Ü','Ý','ß','à','á','â','ã','ä','å','æ','ç','è','é','ê','ë','ì','í','î','ï','ñ','ò','ó','ô','õ','ö','ø','ù','ú','û','ü','ý','ÿ','A','a','A','a','A','a','C','c','C','c','C','c','C','c','D','d','Ð','d','E','e','E','e','E','e','E','e','E','e','G','g','G','g','G','g','G','g','H','h','H','h','I','i','I','i','I','i','I','i','I','i','?','?','J','j','K','k','L','l','L','l','L','l','?','?','L','l','N','n','N','n','N','n','?','O','o','O','o','O','o','Œ','œ','R','r','R','r','R','r','S','s','S','s','S','s','Š','š','T','t','T','t','T','t','U','u','U','u','U','u','U','u','U','u','U','u','W','w','Y','y','Ÿ','Z','z','Z','z','Ž','ž','?','ƒ','O','o','U','u','A','a','I','i','O','o','U','u','U','u','U','u','U','u','U','u','?','?','?','?','?','?');
		// $b = array('A','A','A','A','A','A','AE','C','E','E','E','E','I','I','I','I','D','N','O','O','O','O','O','O','U','U','U','U','Y','s','a','a','a','a','a','a','ae','c','e','e','e','e','i','i','i','i','n','o','o','o','o','o','o','u','u','u','u','y','y','A','a','A','a','A','a','C','c','C','c','C','c','C','c','D','d','D','d','E','e','E','e','E','e','E','e','E','e','G','g','G','g','G','g','G','g','H','h','H','h','I','i','I','i','I','i','I','i','I','i','IJ','ij','J','j','K','k','L','l','L','l','L','l','L','l','l','l','N','n','N','n','N','n','n','O','o','O','o','O','o','OE','oe','R','r','R','r','R','r','S','s','S','s','S','s','S','s','T','t','T','t','T','t','U','u','U','u','U','u','U','u','U','u','U','u','W','w','Y','y','Y','Z','z','Z','z','Z','z','s','f','O','o','U','u','A','a','I','i','O','o','U','u','U','u','U','u','U','u','U','u','A','a','AE','ae','O','o');
		// return strtolower(preg_replace(array('/[^a-zA-Z0-9 -]/','/[ -]+/','/^-|-$/'),array('','-',''),str_replace($a,$b,$str)));
		

		$str = trim(mb_strtolower($str));
		$str = preg_replace('/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/', 'a', $str);
		$str = preg_replace('/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/', 'e', $str);
		$str = preg_replace('/(ì|í|ị|ỉ|ĩ)/', 'i', $str);
		$str = preg_replace('/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/', 'o', $str);
		$str = preg_replace('/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/', 'u', $str);
		$str = preg_replace('/(ỳ|ý|ỵ|ỷ|ỹ)/', 'y', $str);
		$str = preg_replace('/(đ)/', 'd', $str);
		$str = preg_replace('/[^a-z0-9-\s]/', '', $str);
		$str = preg_replace('/([\s]+)/', '-', $str);
		return $str;
	}

	public static function to_slug($str) {
		$str = trim(mb_strtolower($str));
		$str = preg_replace('/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/', 'a', $str);
		$str = preg_replace('/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/', 'e', $str);
		$str = preg_replace('/(ì|í|ị|ỉ|ĩ)/', 'i', $str);
		$str = preg_replace('/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/', 'o', $str);
		$str = preg_replace('/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/', 'u', $str);
		$str = preg_replace('/(ỳ|ý|ỵ|ỷ|ỹ)/', 'y', $str);
		$str = preg_replace('/(đ)/', 'd', $str);
		$str = preg_replace('/[^a-z0-9-\s]/', '', $str);
		$str = preg_replace('/([\s]+)/', '-', $str);
		return $str;
	}
	
	public static function displayCategory($categories,$categories_id){
		$data = "";
		foreach ($categories as $key => $category) {
			if(count($categories_id)>0){
				$check = 0;
				foreach ($categories_id as $key => $children) {
					if($category['id'] == $children['id']){
						$data.="<option selected value='".$category['id']."'>".$category['name']."</option>";
                        $check = 1;
                        break;
					}
				}
				if($check == 0){
					$data.="<option value='".$category['id']."'>".$category['name']."</option>";
				}
			}else{
				$data.="<option value='".$category['id']."'>".$category['name']."</option>";
			}
		}
		return $data;
	}

	public static function checkagentuser() {
		if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== FALSE ||
			strpos($_SERVER['HTTP_USER_AGENT'], 'Trident') !== FALSE ||
			strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox') !== FALSE ||
		    strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome') !== FALSE  ||
		    strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mini') !== FALSE ||
		    strpos($_SERVER['HTTP_USER_AGENT'], 'Opera') !== FALSE  ||
		    strpos($_SERVER['HTTP_USER_AGENT'], 'Safari') !== FALSE )
				return true;
		else
			return false;
	}

	public static function checkgoogleaccess() {
		$ipaddress = '';
		if (getenv('HTTP_CLIENT_IP'))
		    $ipaddress = getenv('HTTP_CLIENT_IP');
		else if(getenv('HTTP_X_FORWARDED_FOR'))
		    $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
		else if(getenv('HTTP_X_FORWARDED'))
		    $ipaddress = getenv('HTTP_X_FORWARDED');
		else if(getenv('HTTP_FORWARDED_FOR'))
		    $ipaddress = getenv('HTTP_FORWARDED_FOR');
		else if(getenv('HTTP_FORWARDED'))
		    $ipaddress = getenv('HTTP_FORWARDED');
		else if(getenv('REMOTE_ADDR'))
		    $ipaddress = getenv('REMOTE_ADDR');
		else
		    $ipaddress = 'UNKNOWN';

		if (strpos($ipaddress, '66.249.82.') !== FALSE)
			return true;
		else
			return false;
	}

	public static function countArr($arr){
		$count=0;
		foreach ($arr as $key => $value) {
			if($value) $count += 1;
		}
		return $count;
  }
  
  public static function getUrlAws($name, $folder){
    $s3 = new vendor_aws();
    return $s3->getBaseUrl().$folder.'/'.$name;
  }

  public static function getBaseUrlAws(){
    $s3 = new vendor_aws();
    return $s3->getBaseUrl();
  }

}
?>