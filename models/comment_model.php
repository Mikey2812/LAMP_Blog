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
        
        public function convertPath ($id) {
			$path = sprintf("%04d", $id);
			return $path;
		}

        public function getID_Auto () {
            $query = "SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = 'LAMP_Blog' AND TABLE_NAME = 'comments'";
            $result = mysqli_query($this->con,$query);
            $row = mysqli_fetch_assoc($result);
            $auto_increment_id = $row['AUTO_INCREMENT'];
            return $auto_increment_id;
        }

        public function updateLikes ($action, $id) {
            $query = "UPDATE comments SET "."number_like = number_like + '$action'"." WHERE id='$id'";
			mysqli_query($this->con,$query);
        }

        public function updatePath ($post_id, $cmt_id, $parent = null) {
            $path = "";
            if ($parent != null) {
                $path = $parent.'.'.$this->convertPath($cmt_id);
            }
            else {
                $path = $this->convertPath($post_id).'.'.$this->convertPath($cmt_id);
            }
            $query = "UPDATE comments SET path = '$path' WHERE id = '$cmt_id'";
			mysqli_query($this->con,$query);
        }
    }
?>