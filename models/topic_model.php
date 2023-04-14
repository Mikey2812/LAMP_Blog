<?php
    class topic_model extends vendor_frap_model{
        public function getTopics () {
            $query = "SELECT * FROM topics ORDER BY ID DESC";
            return mysqli_query($this->con,$query);
        }
    }
?>