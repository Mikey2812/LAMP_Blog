<?php
    class post_model extends vendor_frap_model{
        protected $relationships = [
            'hasMany'	=>	[
                ['comment',	'key'=>'post_id']
            ],
            'belongTo'	=>	[
                ['user','key'=>'user_id'],
                ['topic','key'=>'topic_id']
            ]
        ];
        public function addViews ($id) {
            $query = "UPDATE posts SET "."view = view + 1"." WHERE id='$id'";
			mysqli_query($this->con,$query);
        }

        public function addLikes ($id) {
            $query = "UPDATE posts SET "."number_like = number_like + 1"." WHERE id='$id'";
			mysqli_query($this->con,$query);
        }
    }
?>