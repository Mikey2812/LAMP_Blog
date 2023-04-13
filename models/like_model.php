<?php
    class like_model extends vendor_frap_model{
        protected $relationships = [
            'belongTo'	=>	[
                ['user','key'=>'user_id'],
            ]
        ];
    }
?>