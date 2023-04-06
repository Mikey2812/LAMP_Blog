<?php
class vendor_html_helper{
	const helpersDirectory = "/helpers/";

	public static function link($text, $options=null) {
		return '<a href="'.vendor_app_util::url($options).'">'.$text.'</a>';
	}

	public static function pagination($norecords, $nocurp, $curp, $nopp) {
		$from 	= ($curp-1)*$nopp+1;
		$to 	= ($curp-1)*$nopp + $nocurp;
		$nopages= ceil($norecords/$nopp);
		$relpath = self::helpersDirectory.__FUNCTION__."/index.php";
		if(is_file("views".$relpath)) include "views".$relpath;
		else include "vendor".$relpath;
	}

	public static function contentheader($title, $breadcrumb) {
		$relpath = self::helpersDirectory.__FUNCTION__."/index.php";
		if(is_file("views".$relpath)) include "views".$relpath;
		else include "vendor".$relpath;
	}

	public static function flasherrors() {
		$relpath = self::helpersDirectory.__FUNCTION__."/index.php";
		if(is_file("views".$relpath)) include "views".$relpath;
		else include "vendor".$relpath;
		unset($_SESSION['flasherror']);
	}
	
	public static function showDistrict($district_str){
		global $app;
		$district_show = "";
		if($district_str != ",0,"){
			$district_str = rtrim($district_str, ",");
			$district_str = ltrim($district_str, ",");
			$districts_arr = explode(',', $district_str);
			foreach ($app['districts']  as $key1 => $value1) {
				foreach ($districts_arr as $key2 => $value2) {
					if($key1 == $value2){
						$district_show.=$value1." | ";
					}
				}
			}
			$district_show = rtrim($district_show," | ");	
		}else{
			$district_show = "Chưa xác định";
		}
		return $district_show;
    }

	public static function processSQLString( $query = ''){
		$patterns = array();
		$patterns[0] = '/\"/';
		$patterns[1] = '/\'/';
		$patterns[2] = '/!/';
		$patterns[3] = '/\$/';
		$patterns[4] = '/%/';
		// $patterns[5] = '/(/';
		// $patterns[6] = '/)/';
		$patterns[5] = '/-/';
		// $patterns[6] = '/;/';
		$patterns[7] = '/=/';
		// $patterns[8] = '/@/';
		// $patterns[9] = '/>/';
		// $patterns[10] = '/</';
		$replacements = array();
		$replacements[0] = '&quot;';
		$replacements[1] = '&#39;';
		$replacements[2] = '&#33;';
		$replacements[3] = '&#36;';
		$replacements[4] = '&#37;';
		// $replacements[5] = '&#40;';
		// $replacements[6] = '&#41;';
		// $replacements[5] = '&#45;'; // - not replace because date has it
		$replacements[5] = '-'; // - not replace because date has it
		// $replacements[6] = '&#59;';
		$replacements[7] = '&#61;';
		// $replacements[8] = '&#64;';
		// $replacements[9] = '&#62;';
		// $replacements[10] = '&#60;';
		$query = preg_replace($patterns, $replacements, $query);
		return $query;
	}

	public static function _media($buffer) {
		global $obMediaFiles;

		$content = $buffer;

		$cssFiles = "";
		if(isset($obMediaFiles['css']) && count($obMediaFiles['css'])) {
			foreach( $obMediaFiles['css'] as $css) {
				$cssFiles .= '<link href="'.$css.'" rel="stylesheet">';
			}
		}
		$content = str_replace("CSSABOVE", $cssFiles, $content);

		$jsFiles = "";
		if(isset($obMediaFiles['js']) && count($obMediaFiles['js'])) {
			foreach( $obMediaFiles['js'] as $js) {
				$jsFiles .= '<script src="'.$js.'"></script>';
			}
		}
		$content = str_replace("JSBOTTOM", $jsFiles, $content);

		return $content;
	}
	/* Header */
	/*
	global $enableOB;
	if($enableOB) {
		ob_start("vendor_html_helper::_media"); 
		echo "CSSABOVE";
	}
	*/

	/* Main */
	/*
	global $obMediaFiles;
	array_push($obMediaFiles['css'], "media/css/about.css");

	array_push($obMediaFiles['js'], "media/js/about.js");
	*/

	/* Footer */
	/*
	if($enableOB) {
		echo "JSBOTTOM";
		ob_end_flush();
	}
	*/


	public static function _cssHeader() {
		global $mediaFiles;
		$cssFiles = "";
		if(isset($mediaFiles['css']) && count($mediaFiles['css'])) {
			foreach( $mediaFiles['css'] as $css) {
				$cssFiles .= '<link href="'.$css.'" rel="stylesheet">';
			}
		}
		return $cssFiles;
	}
	/* Header */
	/*
	echo vendor_html_helper::_cssHeader();
	*/

	/* Main */
	/*
	global $mediaFiles;
	array_push($mediaFiles['css'], "media/css/about.css");
	*/


	public static function _jsFooter() {
		global $mediaFiles;

		$jsFiles = "";
		if(isset($mediaFiles['js']) && count($mediaFiles['js'])) {
			foreach( $mediaFiles['js'] as $js) {
				$jsFiles .= '<script src="'.$js.'"></script>';
			}
		}
		return $jsFiles;
	}
	/* Footer */
	/*
	echo vendor_html_helper::_jsFooter();
	*/

	/* Main */
	/*
	global $obMediaFiles;
	array_push($mediaFiles['js'], "media/js/about.js");
	*/


	public static function utf8tourl($text){
        $text = strtolower(self::utf8convert($text));
        $text = str_replace( "ß", "ss", $text);
        $text = str_replace( "%", "", $text);
        $text = preg_replace("/[^_a-zA-Z0-9 -] /", "",$text);
        $text = str_replace(array('%20', ' '), '-', $text);
        $text = str_replace("----","-",$text);
        $text = str_replace("---","-",$text);
        $text = str_replace("--","-",$text);
		return $text;
	}

	function utf8convert($str) {
		if(!$str) return false;
		$utf8 = array(
			'a'=>'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ|Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
			'd'=>'đ|Đ',
			'e'=>'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ|É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
			'i'=>'í|ì|ỉ|ĩ|ị|Í|Ì|Ỉ|Ĩ|Ị',
			'o'=>'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ|Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
			'u'=>'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự|Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
			'y'=>'ý|ỳ|ỷ|ỹ|ỵ|Ý|Ỳ|Ỷ|Ỹ|Ỵ');
		foreach($utf8 as $ascii=>$uni) $str = preg_replace("/($uni)/i",$ascii,$str);
		return $str;
	}

	public static function header(){
		global $app;
        $linkpage = $app['linkpage'];
        $rootServer = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://"."$_SERVER[HTTP_HOST]";
        if(!isset($app['linkpage-tencongty'])) $app['linkpage-tencongty'] = '';
        if(!isset($app['linkpage-logocongty'])) $app['linkpage-logocongty'] = '';
        if(!isset($app['linkpage-tieudeviec'])) $app['linkpage-tieudeviec'] = '';
        if(!isset($app['linkpage-categories'])) $app['linkpage-categories'] = '';
        if(!isset($app['linkpage-nganhnghe'])) $app['linkpage-nganhnghe'] = '';
		if(!isset($app['linkpage-diadiem'])) $app['linkpage-diadiem'] = '';
		
		$header = [];

        switch($linkpage){
            case 'nha-tuyen-dung':
                $header['actual_link']				= $rootServer."$_SERVER[REQUEST_URI]";
                
                $header['_title']      				= $app['linkpage-tencongty'].' tuyển dụng nhân viên tại Đà Nẵng';
                $header['_href']            		= $header['actual_link'];
                $header['_description']       		= 'Việc làm mới nhất của '.$app['linkpage-tencongty'].' tuyển dụng tại Đà Nẵng';
                $header['_keywords']          		= 'Việc làm tại '.$app['linkpage-tencongty'].', '.$app['linkpage-tencongty'].' tuyển dụng đà nẵng';
                $header['_robots']            		= 'index, follow';
                $header['_og_image']          		= $app['linkpage-logocongty'];
                $header['_og_image_width']    		= "526";
                $header['_og_image_height']   		= "275";
                $header['_og_title']          		= $app['linkpage-tencongty'].' tuyển dụng nhân viên tại Đà Nẵng';
                $header['_og_url']            		= $header['actual_link'];
                $header['_og_title_name']     		= "việc làm đà nẵng, tuyển dụng đà nẵng";
                $header['_og_description']    		= 'Việc làm mới nhất của '.$app['linkpage-tencongty'].' tuyển dụng tại Đà Nẵng';
                
                break;
            case 'tuyen-dung-viec-lam-chi-tiet':
                $header['actual_link']        =  $rootServer."$_SERVER[REQUEST_URI]";
                
                // $header['_title']             =  'Tuyển dụng '.$app['linkpage-tieudeviec'].' tại '.$app['linkpage-tencongty'];
                $header['_href']              =  $header['actual_link'];

                $header['_description']       = $app['linkpage-tencongty']." tuyển dụng ".$app['linkpage-tieudeviec'].' tại '.$app['linkpage-noituyendung'].', hạn nộp '.$app['linkpage-thoihan'].", ứng tuyển tại Việc Làm Đà Nẵng";
                // $header['_description']    =  'Cần Tuyển '.$app['linkpage-tieudeviec'].' tại '.$app['linkpage-tencongty'].', việc làm '.$app['linkpage-tieudeviec'].' tại Đà Nẵng';

                $header['_title']              = "Tuyển ".$app['linkpage-tieudeviec'].'-'.$app['linkpage-tencongty'].'. Tuyển dụng tại Việc Làm Đà Nẵng';




                $header['_keywords']          =  'Việc làm '.$app['linkpage-tieudeviec'].', '.$app['linkpage-tencongty'].' tuyển dụng '.$app['linkpage-tieudeviec'].' '.$app['linkpage-categories'];
                $header['_robots']            =  "index, follow";
                $header['_og_image']          =  $app['linkpage-logocongty'];
                $header['_og_image_width']    =  "526";
                $header['_og_image_height']   =  "275";
                $header['_og_title']          =  $app['linkpage-tencongty'].' tuyển dụng nhân sự tại Đà Nẵng';
                $header['_og_url']            =  $header['actual_link'];
                $header['_og_title_name']     = "Việc Làm Đà Nẵng";
                $header['_og_description']    =  'Cần Tuyển '.$app['linkpage-tieudeviec'].' tại '.$app['linkpage-tencongty'].', việc làm '.$app['linkpage-tieudeviec'].' tại Đà Nẵng';
                
                break;
            case 'tuyen-dung-viec-lam':
                
                $header['_title']             =  'Việc làm mới nhất, lương cao của các nhà tuyển dụng tại Đà Nẵng'.(isset($app['page-current'])?' - Trang '.$app['page-current']:'');
                $header['_href']              =  $rootServer.'/tuyen-dung-viec-lam';
                $header['_description']       =  'Tìm kiếm việc làm mới nhất, hot nhất hay việc làm đang được tuyển gấp tại Đà Nẵng';
                $header['_keywords']          =  'việc làm đà nẵng, tuyển dụng đà nẵng, việc làm đà nẵng mới nhất';
                $header['_robots']            =  "index, follow";
                $header['_og_image']          =  $rootServer.'/media/images/logovuong.jpg';
                $header['_og_image_width']    =  "526";
                $header['_og_image_height']   =  "275";
                $header['_og_title']          =  'Việc làm mới, hot nhất tại Đà Nẵng';
                $header['_og_url']            =  $rootServer.'/tuyen-dung-viec-lam';
                $header['_og_title_name']     =  "Việc Làm Đà Nẵng";
                $header['_og_description']    =  'Tìm kiếm việc làm mới nhất, hot nhất hay việc làm đang được tuyển gấp tại Đà Nẵng';
                
                break;
            case 'viec-lam-trong-ngay':
                
                $header['_title']             =  'Việc làm trong ngày của các nhà tuyển dụng tại Đà Nẵng'.(isset($app['page-current'])?' - Trang '.$app['page-current']:'');
                $header['_href']              =  $rootServer.'/viec-lam-trong-ngay';
                $header['_description']       =  'Việc làm được tuyển gấp trong ngày, cập nhật liên tục hỗ trợ tìm kiếm cũng như tuyển dụng tại Đà Nẵng';
                $header['_keywords']          =  'việc làm đà nẵng, tuyển dụng đà nẵng, việc làm mới nhất trong ngày, việc làm mới nhất';
                $header['_robots']            =  "index, follow";
                $header['_og_image']          =  $rootServer.'/media/images/logovuong.jpg';
                $header['_og_image_width']    =  "526";
                $header['_og_image_height']   =  "275";
                $header['_og_title']          =  'Việc làm trong ngày của các nhà tuyển dụng tại Đà Nẵng';
                $header['_og_url']            =  $rootServer.'/viec-lam-trong-ngay';
                $header['_og_title_name']     =  "Việc Làm Đà Nẵng";
                $header['_og_description']    =  'Việc làm được tuyển gấp trong ngày, cập nhật liên tục hỗ trợ tìm kiếm cũng như tuyển dụng tại ĐÀ Nẵng';
                
                break;
            case 'viec-lam-tuyen-gap':
                
                $header['_title']             =  'Việc làm tuyển gấp của các nhà tuyển dụng tại Đà Nẵng'.(isset($app['page-current'])?' - Trang '.$app['page-current']:'');
                $header['_href']              =  $rootServer.'/viec-lam-tuyen-gap';
                $header['_description']       =  'Cập nhật thông tin các việc làm đang cần tuyển gấp của các nhà tuyển dụng tại Đà Nẵng';
                $header['_keywords']          =  'việc làm đà nẵng, tuyển dụng đà nẵng, việc làm đà nẵng tuyển gấp';
                $header['_robots']            =  "index, follow";
                $header['_og_image']          =  $rootServer.'/media/images/logovuong.jpg';
                $header['_og_image_width']    =  "526";
                $header['_og_image_height']   =  "275";
                $header['_og_title']          =  'Việc làm tuyển gấp của các nhà tuyển dụng tại Đà Nẵng';
                $header['_og_url']            =  $rootServer.'/viec-lam-tuyen-gap';
                $header['_og_title_name']     =  "Việc Làm Đà Nẵng";
                $header['_og_description']    =  'Cập nhật thông tin các việc làm đang cần tuyển gấp của các nhà tuyển dụng tại Đà Nẵng';
                
                break;
            case 'viec-lam-hap-dan':
                
                $header['_title']             =  'Việc làm hấp dẫn của các nhà tuyển dụng tại Đà Nẵng'.(isset($app['page-current'])?' - Trang '.$app['page-current']:'');
                $header['_href']              =  $rootServer.'/viec-lam-hap-dan';
                $header['_description']       =  'Tìm kiếm việc làm nhanh nhất cập nhật hàng ngày của các nhà tuyển dụng tại Đà Nẵng';
                $header['_keywords']          =  'việc làm đà nẵng, tuyển dụng đà nẵng, việc làm đà nẵng lương cao, việc làm đà nẵng hấp dẫn';
                $header['_robots']            =  "index, follow";
                $header['_og_image']          =  $rootServer.'/media/images/logovuong.jpg';
                $header['_og_image_width']    =  "526";
                $header['_og_image_height']   =  "275";
                $header['_og_title']          =  'Việc làm hấp dẫn của các nhà tuyển dụng tại Đà Nẵng';
                $header['_og_url']            =  $rootServer.'/viec-lam-hap-dan';
                $header['_og_title_name']     =  "Việc Làm Đà Nẵng";
                $header['_og_description']    =  'Việc làm hấp dẫn của các nhà tuyển dụng tại Đà Nẵng';
                
                break;
            case 'tuyen-dung':
                
                $header['_title']             =  'Tuyển dụng Đà Nẵng nhanh chóng, uy tín, hiệu quả '.(isset($app['page-current'])?' - Trang '.$app['page-current']:'');
                $header['_href']              =  $rootServer.'/tuyen-dung';
                $header['_description']       =  'Hỗ trợ Tuyển Dụng Nhân Sự tại Đà Nẵng, giúp các Nhà Tuyển Dụng tìm kiếm được những Nhân Tài, Ứng Viên Ưu Tú nhất cho vị trí công việc mình đang cần.';
                $header['_keywords']          =  'việc làm đà nẵng, tuyển dụng đà nẵng, tuyển dụng nhân viên đà nẵng';
                $header['_robots']            =  "index, follow";
                $header['_og_image']          =  $rootServer.'/media/images/logovuong.jpg';
                $header['_og_image_width']    =  "526";
                $header['_og_image_height']   =  "275";
                $header['_og_title']          =  'Tuyển dụng Nhân Sự nhanh chóng, uy tín, hiệu quả tại Đà Nẵng';
                $header['_og_url']            =  $rootServer.'/tuyen-dung';
                $header['_og_title_name']     =  'Việc Làm Đà Nẵng';
                $header['_og_description']    =  'Hỗ trợ Tuyển Dụng Nhân Sự tại Đà Nẵng, giúp các Nhà Tuyển Dụng tìm kiếm được những Nhân Tài, Ứng Viên Ưu Tú nhất cho vị trí công việc mình đang cần.';
                
                break;
            case 'home':
                
                $header['_title']             =  'Tuyển dụng, Tìm Việc Làm Đà Nẵng mới nhất 2019';
                $header['_href']              =  $rootServer;
                $header['_description']       =  'Tìm Việc Làm tại Đà Nẵng với hàng ngàn công việc Mới Nhất 2019, lương cao hấp dẫn cũng như đáp ứng nhu cầu nhân sự cho các nhà Tuyển Dụng Đà Nẵng';
                $header['_keywords']          =  'việc làm đà nẵng , tuyển dụng đà nẵng';
                $header['_robots']            =  "index, follow";
                $header['_og_image']          =  $rootServer.'/media/images/logovuong.jpg';
                $header['_og_image_width']    =  "526";
                $header['_og_image_height']   =  "275";
                $header['_og_title']          =  'Tuyển dụng, Tìm Việc Làm Đà Nẵng mới nhất 2019';
                $header['_og_url']            =  $rootServer;
                $header['_og_title_name']     =  "Việc Làm Đà Nẵng";
                $header['_og_description']    =  'Việc Làm Đà Nẵng với hàng ngàn công việc Mới Nhất, lương cao hấp dẫn cũng như đáp ứng nhu cầu nhân sự cho các nhà Tuyển Dụng nhân sự tại Đà Nẵng.';
                
                break;
            case 'tim-viec-nhanh':
                
                $header['_title']             =  'Đăng ký nhận hỗ trợ tìm việc làm nhanh tại Đà Nẵng ';
                $header['_href']              =  $rootServer;
                $header['_description']       =  'Trang hỗ trợ tìm việc làm nhanh cho ứng viên tìm việc tại Đà nẵng, miễn phí, nhanh chóng.';
                $header['_keywords']          =  'việc làm đà nẵng , tuyển dụng đà nẵng';
                $header['_robots']            =  "index, follow";
                $header['_og_image']          =  $rootServer.'/media/images/logovuong.jpg';
                $header['_og_image_width']    =  "526";
                $header['_og_image_height']   =  "275";
                $header['_og_title']          =  'Tuyển dụng, Tìm Việc Làm Đà Nẵng mới nhất 2019';
                $header['_og_url']            =  $rootServer;
                $header['_og_title_name']     =  "Việc Làm Đà Nẵng";
                $header['_og_description']    =  'Việc Làm Đà Nẵng với hàng ngàn công việc Mới Nhất, lương cao hấp dẫn cũng như đáp ứng nhu cầu nhân sự cho các nhà Tuyển Dụng nhân sự tại Đà Nẵng.';
                
                break;
            case 'tuyen-dung-category':

                $header['_title']             =  'Tuyển dụng việc làm '.$app['linkpage-nganhnghe'].' Tại Đà Nẵng';
                $header['_href']              =  $rootServer;
                $header['_description']       =  'Tìm kiếm việc làm '.$app['linkpage-nganhnghe'].' nhanh nhất cập nhật hàng ngày của các nhà tuyển dụng tại Đà Nẵng';
                $header['_keywords']          =  'Trang thông tin việc làm '.$app['linkpage-nganhnghe'].', viec lam moi nhat tai Da Nang, viec lam hot nhat tai Da Nang';
                $header['_robots']            =  "index, follow";
                $header['_og_image']          =  $rootServer.'/media/images/logovuong.jpg';
                $header['_og_image_width']    =  "526";
                $header['_og_image_height']   =  "275";
                $header['_og_title']          =  'Tuyển dụng việc làm '.$app['linkpage-nganhnghe'].' Tại Đà Nẵng';
                $header['_og_url']            =  $rootServer;
                $header['_og_title_name']     =  "Việc Làm Đà Nẵng";
                $header['_og_description']    =  'Tìm kiếm nhanh tất cả việc làm tuyển dụng '.$app['linkpage-nganhnghe'].' tại Đà Nẵng nhanh và mới nhất của các nhà tuyển dụng tại Việc Làm Đà Nẵng';

                break;
            case 'tuyen-dung-location':
                
                $header['_title']             =  'Tuyển dụng việc làm tại '.$app['linkpage-diadiem'].' Đà Nẵng';
                $header['_href']              =  $rootServer;
                $header['_description']       =  'Tìm kiếm việc làm tại '.$app['linkpage-diadiem'].' nhanh nhất cập nhật hàng ngày của các nhà tuyển dụng tại Đà Nẵng';
                $header['_keywords']          =  'tuyển dụng đà nẵng '.$app['linkpage-diadiem'].', Đà Nẵng, viec lam moi nhat tai Da Nang, viec lam hot nhat tai Da Nang';
                $header['_robots']            =  "index, follow";
                $header['_og_image']          =  $rootServer.'/media/images/logovuong.jpg';
                $header['_og_image_width']    =  "526";
                $header['_og_image_height']   =  "275";
                $header['_og_title']          =  'Tuyển dụng việc làm tại '.$app['linkpage-diadiem'].' Đà Nẵng';
                $header['_og_url']            =  $rootServer;
                $header['_og_title_name']     =  "Việc Làm Đà Nẵng";
                $header['_og_description']    =  'Tìm kiếm nhanh tất cả việc làm tuyển dụng tại '.$app['linkpage-diadiem'].' Đà Nẵng nhanh và mới nhất của các nhà tuyển dụng tại Việc Làm Đà Nẵng';
                
                break;
            case 'candidate-index':
                $header['_title']             = 'Danh sách ứng viên đang tìm kiếm việc làm tại Đà Nẵng'.(isset($app['page-current'])?' - Trang '.$app['page-current']:'');
                $header['_href']              = $rootServer;
                $header['_description']       = "Danh sách ứng viên, nhân viên, người đang tìm kiếm việc làm được cập nhật liên tục tại Đà Nẵng";
                $header['_keywords']          = "viec lam moi nhat tai Da Nang, viec lam hot nhat tai Da Nang";
                $header['_robots']            = "index, follow";
                $header['_og_image']          = $rootServer.'/media/images/logovuong.jpg';
                $header['_og_image_width']    = '526';
                $header['_og_image_height']   = '275';
                $header['_og_title']          = "Danh sách ứng viên đang tìm kiếm việc làm tại Đà Nẵng";
                $header['_og_url']            = $rootServer;
                $header['_og_title_name']     = "Việc Làm Đà Nẵng";
                $header['_og_description']    = "Danh sách ứng viên, nhân viên, người đang tìm kiếm việc làm được cập nhật liên tục tại Đà Nẵng";

                break;

            case 'candidate-view':
                $header['_title']             = 'Hồ sơ ứng viên '.$app['candidate-name'];
                $header['_href']              = $rootServer;
                $header['_description']       = "Hồ sơ ứng viên ".$app['candidate-name']." ứng tuyển tại vị trí ".$app['candidate-job']." tại Đà Nẵng";
                $header['_keywords']          = "ứng viên tìm việc tại Đà Nẵng, nhân sự Đà Nẵng, tìm việc làm Đà Nẵng, tuyển dụng Đà Nẵng";
                $header['_robots']            = "index, follow";
                $header['_og_image']          = $rootServer.'/media/images/logovuong.jpg';
                $header['_og_image_width']    = '526';
                $header['_og_image_height']   = '275';
                $header['_og_title']          = "Hồ sơ ứng viên ".$app['candidate-name'];
                $header['_og_url']            = $rootServer;
                $header['_og_title_name']     = "Việc Làm Đà Nẵng";
                $header['_og_description']    = "Hồ sơ ứng viên ".$app['candidate-name']." ứng tuyển tại vị trí ".$app['candidate-job']." tại Đà Nẵng";

                break;
            default:
                $title              = '';
                switch($app['ctl']){
                    case 'page':
                        if(isset($app['title'])){
                            $title = $app['title'];
                        }
                        break;
                    case 'contact':
                        $title = 'Liên hệ';
                        break;
                    case 'login':
                        $title = 'Đăng nhập';
                        if($app['act'] == 'forgotPassWord') $title = "Quên mật khẩu";
                        break;
                    case 'register':
                        $title = 'Đăng kí';
                        break;
                    default:
                        $title = 'Trang không tìm thấy - 404';
                }

                $header['_title']             = $title.' - Việc Làm Đà Nẵng';
                $header['_href']              = $rootServer;
                $header['_description']       = "Tìm kiếm việc làm tại Đà Nẵng nhanh nhất cập nhật hàng ngày của các nhà tuyển dụng tại Đà Nẵng";
                $header['_keywords']          = "Trang thông tin việc làm tuyển dụng số 1 Đà Nẵng, viec lam moi nhat tai Da Nang, viec lam hot nhat tai Da Nang";
                $header['_robots']            = "noindex, follow";
                $header['_og_image']          = $rootServer.'/media/images/logovuong.jpg';
                $header['_og_image_width']    = '526';
                $header['_og_image_height']   = '275';
                $header['_og_title']          = "Tuyển dụng việc làm tại Việc Làm Đà Nẵng";
                $header['_og_url']            = $rootServer;
                $header['_og_title_name']     = "Việc Làm Đà Nẵng";
                $header['_og_description']    = "Tìm kiếm nhanh tất cả việc làm tuyển dụng tại  Đà Nẵng nhanh và mới nhất của các nhà tuyển dụng tại Việc Làm Đà Nẵng";

				break;
		}
		
		return $header;
	}


}
?>