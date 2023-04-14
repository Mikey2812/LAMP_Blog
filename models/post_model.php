<?php
    class post_model extends vendor_frap_model{
        protected $relationships = [
            'hasMany'	=>	[
                ['comment',	'key'=>'post_id'],
                // ['like',	'key'=>'post_id'],
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

        public function updateLikes ($action, $id) {
            $query = "UPDATE posts SET "."number_like = number_like + '$action'"." WHERE id='$id'";
			mysqli_query($this->con,$query);
        }

        public function addComments ($id) {
            $query = "UPDATE posts SET "."number_comment = number_comment + 1"." WHERE id='$id'";
			mysqli_query($this->con,$query);
        }

        public function getAllRecords () {
                $query = "SELECT posts.*, users.firstname as users_firstname, users.lastname as users_lastname, 
                            likes.id as likes_id, likes.location_id as likes_location_id, likes.user_id as likes_user_id, likes.type as likes_type 
                            FROM posts LEFT JOIN users ON users.id = posts.user_id 
                                        LEFT JOIN likes ON posts.id = likes.location_id
                            ORDER BY posts.created_at DESC";
            $pagination = [];
		    $resultMObject = mysqli_query($this->con,$query);
		    $pagination['data'] = [];
		    if($resultMObject) {
			    while($row = $resultMObject->fetch_assoc()) {
	    		    $pagination['data'][] = $row;
	    	    }
		    }
            return $pagination;
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