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

        public function addComments ($id) {
            $query = "UPDATE posts SET "."number_comment = number_comment + 1"." WHERE id='$id'";
			mysqli_query($this->con,$query);
        }

        public function getTopics () {
            $query = "SELECT * FROM topics ORDER BY ID DESC";
            return mysqli_query($this->con,$query);
        }

        public function getRecordsbyAuthor ($id) {
            $query = "SELECT * FROM posts WHERE user_id = '$id' ORDER BY ID DESC";
            $result = mysqli_query($this->con,$query);
            $pagination['data'] = [];
		    if($result) {
			    while($row = $result->fetch_assoc()) {
	    		    $pagination['data'][] = $row;
	    	    }
		    }
            return $pagination;
        }
    }
?>