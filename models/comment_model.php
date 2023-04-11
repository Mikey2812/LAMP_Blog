<?php
    class comment_model extends vendor_frap_model{
        protected $relationships = [
            'hasMany'	=>	[
                ['comment',	'key'=>'post_id']
            ],
            'belongTo'	=>	[
                ['user','key'=>'user_id'],
                ['post','key'=>'post_id']
            ]
        ];
    }
?>