<?php
class post_model extends vendor_frap_model{
    protected $relationships = [
		// 'belongTo'	=>	[
		// 	['topic','key'=>'topic_id']		
        // ],
        'belongTo'	=>	[
			['user','key'=>'user_id'],
            ['topic','key'=>'topic_id']
        ]
	];
}
?>