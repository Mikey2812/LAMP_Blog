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
        
        public function convertPath ($post_id, $auto_id) {
			$path = sprintf("%04d", $post_id).'.'.sprintf("%04d", $auto_id);
			return $path;
		}

        public function getID_Auto () {
            $query = "SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = 'LAMP_Blog' AND TABLE_NAME = 'comments'";
            $result = mysqli_query($this->con,$query);
            $row = mysqli_fetch_assoc($result);
            $auto_increment_id = $row['AUTO_INCREMENT'];
            return $auto_increment_id;
        }

        public function updatePath () {
            $sql = "SELECT id, post_id FROM comments ORDER BY id DESC LIMIT 1";
            $result = mysqli_query($this->con,$sql);
            $row = $result->fetch_assoc();
            $id = $row['id'];
            $path = $this->convertPath($row['post_id'], $id);
            $query = "UPDATE comments SET path = '$path' WHERE id = '$id'";
			mysqli_query($this->con,$query);
        }
    }
?>