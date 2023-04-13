<?php 
    function timeago($date) {
        $timestamp = strtotime($date);	
            
        $strTime = array("second", "minute", "hour", "day", "month", "year");
        $length = array("60","60","24","30","12","10");
    
        $currentTime = time();
        if($currentTime >= $timestamp) {
            $diff = time()- $timestamp;
            for($i = 0; $diff >= $length[$i] && $i < count($length)-1; $i++) {
                $diff = $diff / $length[$i];
            }
        
            $diff = round($diff);
            return $diff . " " . $strTime[$i] . " ago ";
        }
    }

    function numberDot($text){
        $count = substr_count($text, '.');
    }

    function filterPostID($values) {
        $result = array();
        foreach ($values as $value) {
            if ($value['likes_type'] == 0) {
                array_push($result, $value['likes_location_id']);
            }
        }
        return $result;
    }

    function filterCommentID($values) {
        $result = array();
        foreach ($values as $value) {
            if ($value['likes_type'] == 1) {
                array_push($result, $value['likes_location_id']);
            }
        }
        return $result;
    }
?>