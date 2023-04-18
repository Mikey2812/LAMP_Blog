<?php
class posts_controller extends vendor_backend_controller
    {
        public function index($page='1')
        {
            global $app;
            $conditions = "";
            // if (isset($app['prs']['status'])) {
            //     $conditions .= "status=".$app['prs']['status'];
            // }
            // if (isset($app['prs']['role'])) {
            //     $conditions .= (($conditions) ? " AND " : "")."role=".$app['prs']['role'];
            // }
            // if (isset($app['prs']['kw'])) {
            //     $conditions .= (($conditions) ? " AND (" : "")."firstname LIKE '%".$app['prs']['kw']."%' OR lastname LIKE '%".$app['prs']['kw']."%' OR email LIKE '%".$app['prs']['kw']."%'".(($conditions) ? ")" : "");
            // }

            $pm = post_model::getInstance();
            $this->records = $pm->allp('*', ['conditions'=>$conditions,
                                             'joins'=>['topic','user'],
                                            'pagination'=>['page' => $page['p'],'nopp' => 10]]);
            $this->display();
        }

        public function view($id) {
                $pm = post_model::getInstance();
                $this->record = $pm->getRecord($id);
                $cm = comment_model::getInstance();
                $this->comments = $cm->getRecords('*',['conditions'=>'post_id ='.$id]);
                $this->display();
            }

        public function filter() { 
            $pm = post_model::getInstance();
            $conditions = '';
            global $app;
            if(isset($app['prs']['kw'])) {
                $conditions .= (($conditions)? " AND (":"")."title LIKE '%".$app['prs']['kw']."%'
                OR topics.name LIKE '%".$app['prs']['kw']."%'
                OR CONCAT(users.firstname, ' ', users.lastname) LIKE '%".$app['prs']['kw']."%'
                OR id LIKE '%".$app['prs']['kw']."%'".(($conditions)? ")":"");
            }

            //$conditions .= "LIKE '".$data['kw']."'";
            $this->records = $pm->allp('*', ['conditions'=>$conditions,
                                            'joins'=>['topic','user'],
                                            'pagination'=>['page' => 1,'nopp' => 10]]);
            $this->display();
        }
    }
?>