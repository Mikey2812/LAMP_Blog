<?php  
class vendor_ar_util {
	public static function is_multi_array( $arr ) {
		rsort( $arr );
		return isset( $arr[0] ) && is_array( $arr[0] );
	}

	public static function is_multi2($a) {
		foreach ($a as $v) {
			if (is_array($v)) return true;
    	}
    	return false;
	}

	public static function is_multi3($a) {
	    $c = count($a);
	    for ($i=0;$i<$c;$i++) {
	        if (is_array($a[$i])) return true;
	    }
	    return false;
	}
}
?>