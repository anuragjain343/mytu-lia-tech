<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends Common_Controller {

    public $data = array();
    public $file_data = "";

    public function __construct() {
        parent::__construct();
          $this->load->model('service/notification_model');
        //$this->is_auth_admin();
    }

    /**
     * @method index
     * @description listing display
     * @return array
     */
    public function index() {
        if(!empty($_GET['userType'])){
            $user_type = $_GET['userType'];
            $data['user_type'] = $user_type;
            switch ($user_type) {
                case 'user':
                    $where = array('userType'=>$user_type);
                    $data['parent'] = "users";
                    $data['title'] = "Users";
                    break;
                case 'vendor':
                    $where = array('userType'=>$user_type);
                    $data['title'] = "Vendors";
                    $data['parent'] = "vendor";
                    break;
                default:
                    $where = array('userType !='=>'administrator');
                    $data['title'] = "All users";
                    $data['parent'] = "all_users";
                    
            }
        }
        else{
            $where = array('userType !='=>'administrator');
            $data['title'] = "All users";
            $data['parent'] = "all_users";
            $data['user_type'] = "all_users";
        }
        
        $user_data = $this->common_model->getAllwhere(USERS, $where, 'id', $order_type = 'DESC', $select = 'all');  //lq();
        $data['userList'] = $user_data['result'];
        $this->load->admin_render('user_list', $data, '');
    }

  
    //display user profile and related data

    public function profile($user_id){
        $select = 'userType';
        $where  = array('id'=>$user_id);
        $table  = USERS;

        $select2 = 'user_id';
        $where2 = array('user_id'=>$user_id);
        $table2  = FEATURE_USERS;
        $data['features_users_id'] = $this->common_model->customGetId($select2,$where2,$table2);
        $user_type = $this->common_model->customGet($select,$where,$table);
        if($user_type['userType'] == 'vendor'){
            $data['parent'] = "vendor";
            $data['title'] = "Profile";
        }else{
            $data['parent'] = "users";
            $data['title'] = "Profile";
        }
       
        $data['userDetail'] = $this->common_model->user_details($user_id, false); //get user details
        //pr($data);
        $this->load->admin_render('user_profile', $data, '');
        //echo $user_id; die;
    }


    /**
     * @method open_model
     * @description load model box
     * @return array
     */
    function open_model() {
        $this->data['title'] = lang("add_user");
        $option = array('table' => ORGANIZATION,
            'select' => 'name,id'
        );
        $this->data['organization'] = $this->common_model->customGet($option);
        $this->load->view('add', $this->data);
    }

    public function reset_password() {
        $user_id_encode = $this->uri->segment(3);

        $data['id_user_encode'] = $user_id_encode;

        if (!empty($_POST) && isset($_POST)) {

            $user_id_encode = $_POST['user_id'];

            if (!empty($user_id_encode)) {

                $user_id = base64_decode(base64_decode(base64_decode(base64_decode($user_id_encode))));


                $this->form_validation->set_rules('new_password', 'Password', 'required');
                $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[new_password]');

                if ($this->form_validation->run() == FALSE) {
                    $this->load->view('reset_password', $data);
                } else {


                    $user_pass = $_POST['new_password'];

                    $data1 = array('password' => md5($user_pass));
                    $where = array('id' => $user_id);

                    $out = $this->common_model->updateFields(USERS, $data1, $where);



                    if ($out) {

                        $this->session->set_flashdata('passupdate', 'Password Successfully Changed.');
                        $data['success'] = 1;
                        $this->load->view('reset_password', $data);
                    } else {

                        $this->session->set_flashdata('error_passupdate', 'Password Already Changed.');
                        $this->load->view('reset_password', $data);
                    }
                }
            } else {

                $this->session->set_flashdata('error_passupdate', 'Unable to Change Password, Authentication Failed.');
                $this->load->view('reset_password');
            }
        } else {
            $this->load->view('reset_password', $data);
        }
    }

    /*public function get_user_list_ajax(){
        $this->load->model('tableList');
        //pr($_POST);
        $user_type = $_POST['user_type'];
        switch ($user_type) {
            case 'user':
                $where = array('userType'=>$user_type);
                break;
            case 'vendor':
                $where = array('userType'=>$user_type);
                break;
            default:
                $where = array('userType !='=>'administrator');
                
        }
        $this->tableList->set_data( USERS, array(null, 'id', 'fullName', 'email', 'contactNumber', 'userType', 'image', 'status'), array('fullName', 'email', 'contactNumber'), array('id', 'DESC'), $where ); 
        $list = $this->tableList->get_list();      
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $user) {
	   // print_r($data);die;
            $action ='';
		$no++;
		$row = array();
		$row[] = $no;
		$row[] = display_placeholder_text($user->fullName); 
		$row[] = display_placeholder_text($user->email); 
		$row[] = display_placeholder_text($user->contactNumber);
        $row[] = display_placeholder_text($user->userType); 
               
                if($user->status == 1) { $row[] =  '<p class="text-success">Active</p>'; } else { $row[] =  '<p  class="text-danger">Inactive</p>'; }
                $img = (!empty($user->image))? (filter_var($user->image, FILTER_VALIDATE_URL))? $user->image : base_url().USER_AVATAR_PATH.$user->image : base_url().USER_DEFAULT_AVATAR;
                $row[] = '<img width="80" class="img-circle" src="'.$img.'" />';
                $clk_event = "statusFn('".USERS."','id','".encoding($user->id)."','".$user->status."')";
                if($user->status == 1){ $title = 'Inactive user'; $icon = INACTIVE_ICON; } else{ $title = 'Active user'; $icon = ACTIVE_ICON; }
                $action = '<a href="javascript:void(0)" class="on-default edit-row table_action" onclick="'.$clk_event.'"  title="'.$title.'">'.$icon.'</a>';
                $link = base_url('admin/users/profile/'.$user->id);
                $action .= '<a href="'.$link.'"  class="on-default edit-row table_action" title="View user">'.VIEW_ICON.'</a>';
                $row[] = $action;
		$data[] = $row;

        //$_POST['draw']='';
        }

        $output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->tableList->count_all(),
			"recordsFiltered" => $this->tableList->count_filtered(),
			"data" => $data,
		);
        //output to json format
       echo json_encode($output);
    }*/


    public function get_user_list_ajax(){

        $this->load->model('tableList');
      
       
      
        $user_type = $_POST['user_type'];
        switch ($user_type) {
            case 'user':
                $where = array('u.userType'=>$user_type);
                break;
            case 'vendor':
                $where = array('u.userType'=>$user_type);
                break;
            default:
                $where = array('u.userType !='=>'administrator');
                
        }
        $this->tableList->set_data($where); 
        $list = $this->tableList->get_list();
   
    
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $user) { 
            $select2 = 'user_id';
            $where2 = array('user_id'=>$user->id);
            $table2  = FEATURE_USERS;
            $features_users_id = $this->common_model->customGetId($select2,$where2,$table2);
            $action ='';
            $no++;
            $row = array();
            $row[] = $no;
        if($user->userType == 'vendor'){ 
        $clk_event_u = "addfeatursUser('$user->id')";
    
        if(!empty($features_users_id->user_id)){
             $style ='color:green'; 
             $tiitle='Remove featured vendor'; 
        }else{
            $style ='color:gray'; 
            $tiitle='Add as featured vendor';    
        }

        $action .= '<div class="text-right"><a href="javascript:void(0);" title="'. $tiitle.'"   class="'.$user->id.'" style="'.$style.'" onclick="'.$clk_event_u.'"><i class="fa fa-certificate" ></i></a></div>';

        $row[] = display_placeholder_text($user->fullName. ''.$action);
        }else{
            $row[] = display_placeholder_text($user->fullName);
        } 
        
        $row[] = display_placeholder_text($user->email); 
        $row[] = display_placeholder_text($user->contactNumber);
        //$row[] = display_placeholder_text($user->userType);
        if($user->userType == 'vendor'){  
            $row[] = display_placeholder_text($user->name); 
        }       
        //pr($user->id);
          
                if($user->status == 1) { $row[] =  '<p class="text-success">Active</p>'; } else { $row[] =  '<p  class="text-danger">Inactive</p>'; }
                $img = (!empty($user->image))? (filter_var($user->image, FILTER_VALIDATE_URL))? $user->image : base_url().USER_AVATAR_PATH.$user->image : base_url().USER_DEFAULT_AVATAR;
                $row[] = '<img width="80" class="img-circle" src="'.$img.'" />';
                $clk_event = "statusFn('".USERS."','id','".encoding($user->id)."','".$user->status."')";
                if($user->status == 1){ $title = 'Inactive user'; $icon = INACTIVE_ICON; } else{ $title = 'Active user'; $icon = ACTIVE_ICON; }
                $action = '<a href="javascript:void(0)" class="on-default edit-row table_action" onclick="'.$clk_event.'"  title="'.$title.'">'.$icon.'</a>';

                $link = base_url('admin/users/profile/'.$user->id);

                $action .= '<a href="'.$link.'"  class="on-default edit-row table_action" title="View user">'.VIEW_ICON.'</a>';

                $clk_event = "sendNOtification('admin/users','edit','$user->id')";

           
                $action .='<a href="javascript:void(0)" class="on-default edit-row fa-lg" onclick="'. $clk_event.'" title="Edit Category"><i class="fa fa-comments-o" aria-hidden="true"></i></a>';

                $row[] = $action;
                 $data[] = $row;

        //$_POST['draw']='';
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->tableList->count_all(),
            "recordsFiltered" => $this->tableList->count_filtered(),
            "data" => $data,
        );
        //output to json format
       echo json_encode($output);
    }

   
    //users post list ajax

    public function get_my_post_list_ajax(){ 
         //pr($_POST);
        $user_id = $_POST['user_id'];
        $table = USERS;
        $where_in = array('id'=>$user_id);
        $key = 'userType';
        $user_type = $this->common_model->get_field_value($table, $where_in, $key);

        switch ($user_type) {
            case "user":
                $where['p.post_author'] = $user_id; 
            break;
            case "vendor":
                $where['doi.user_id'] = $user_id;
            break;
        }
        $this->load->model('my_post_list_model');
        $this->my_post_list_model->set_data($where);
        $list = $this->my_post_list_model->get_list();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $user) {
            //print_r($user);die;
            $action ='';
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = display_placeholder_text($user->event_name); 
            $row[] = display_placeholder_text($user->name);
            $row[] = display_placeholder_text($user->event_date); 
            
            /*$link = base_url('admin/users/profile/'.$user->id);
            $action .= '<a href="'.$link.'"  class="on-default edit-row table_action" title="View user">'.VIEW_ICON.'</a>';*/

            $link = base_url('admin/posts/detail/'.$user->id);
            $action .= '<a href="'.$link.'"  class="on-default edit-row table_action" title="View user">'.VIEW_ICON.'</a>';
            $row[] = $action;
            $data[] = $row;
            //$_POST['draw']='';
        }

        $output = array(
                    "draw" => $_POST['draw'],
                    "recordsTotal" => $this->my_post_list_model->count_all(),
                    "recordsFiltered" => $this->my_post_list_model->count_filtered(),
                    "data" => $data,
        );
        //output to json format
       echo json_encode($output);
    }
    
    /****post list****/
    public function get_post_list_ajax(){ 
         //pr($_POST);
        $user_id = $_POST['user_id'];
        $where_in = array('user_id'=>$user_id);
        $select = 'category_id';
        $select_cat = $this->common_model->customGet($select,$where_in,'user_category_mapping');
        //pr($select_cat);
        $cat_id = $select_cat['category_id'];
        $table = POST_CAT_MAPPING; 
        $where_cat = array('category_id'=>$cat_id);
        $select = '*';
        $user_post = $this->common_model->getMultipleData($select,$where_cat,$table);
        //pr($user_post);
        $this->load->model('post_list_model');
        $where['map.category_id'] = $cat_id; 
        $this->post_list_model->set_data($where); 
        $list = $this->post_list_model->get_list();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $user) {
            $action ='';
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = display_placeholder_text($user->event_name); 
            $row[] = display_placeholder_text($user->name);
            $row[] = display_placeholder_text($user->event_date); 

            $link = base_url('admin/posts/detail/'.$user->id);
            $action .= '<a href="'.$link.'"  class="on-default edit-row table_action" title="View user">'.VIEW_ICON.'</a>';
            $row[] = $action;
            $data[] = $row;
            //$_POST['draw']='';
        }

        $output = array(
                    "draw" => $_POST['draw'],
                    "recordsTotal" => $this->post_list_model->count_all(),
                    "recordsFiltered" => $this->post_list_model->count_filtered(),
                    "data" => $data,
        );
        //output to json format
       echo json_encode($output);
    }

    function FeaturesUser(){
        $dataInsert['user_id'] = $_POST['userId'];
        $uid =$_POST['userId'];
        $table ='features_users';
        $where = array('user_id'=>$dataInsert['user_id']);
        $userexits = $this->common_model->check_exist($where,$table);

        if($userexits){
            $userDelete = $this->common_model->deleteData($table,$where);
            if($userDelete=='1'){
             $url =     base_url('admin/users/profile/'.$uid);
             $output = array("status"=>"2",'message'=>'Sucessfully removed','url'=>$url);
            }
        }else{
            $insertuser = $this->common_model->insertData($table, $dataInsert);
            if($insertuser){
                $url =  base_url('admin/users/profile/'.$uid);
                $output = array("status"=>"1",'message'=>'Sucessfully added','url'=> $url);
            }
        }
       
     echo json_encode($output);
    }

     public function edit(){ 
      
        $data['title'] = 'Send Notification';
         $id = $this->input->post('id');
         if($id=='users'){
            $data['user_data'] = $id; 
         }
         else if($id=='vendor'){
            $where = array('userType'=>$id);
             $data['user_data'] = $id; 
         
         }else{
          $where = array('id'=>$id); 
          $data['user_data'] = $this->common_model->getsingle(USERS,$where);  
         }
        
        
      
        $this->load->view('sendPushNotification', $data);
            
    }

    function sendPushNotification(){

     $user_id           = $this->session->userdata['id']; //user id     
     $userId            = $_POST['userId'];    
     $registrationIds   = $_POST['deviceToken']; 
     $title             = 'admin title' ;
     $body_send         = $_POST['msg'];
     $add_post          = 'dsfdsfsdf';
     $notif_type        = 'admin_notification';
     $body_save         = '[UNAME] admin message [ENAME]';
     $this->load->model('user_model');
     $notif_msgs = $this->user_model->send_push_notification($registrationIds, $title, $body_send, $add_post,$notif_type);  
    if($notif_msgs){

        $notif_msgs['body'] = $body_save; //replace body text with placeholder te
        //save notification
        $insertdata = array('notification_by'=>$user_id, 'notification_for'=>$userId, 'notification_message'=>json_encode($notif_msgs), 'notification_type'=>$notif_type, 'reference_id'=>$notif_msgs['reference_id'] ,'created_on'=>datetime());

        if($registrationIds == 'system'){
        $insertdata['is_show'] = '0';
        }

        $this->notification_model->save_notification(NOTIFICATIONS, $insertdata); 
                        
        }
            $response = array('status' => 1, 'message' => 'Send successfully', 'url' => base_url("admin/users")); //
        echo json_encode($response);
      
    }
    
    function sendPushNotificationToAll(){

        $user_id           = $this->session->userdata['id']; //user id
        $body_send         = $_POST['msg'];   
        $usertype         = $_POST['usertype'];   
        $userName          = $this->session->userdata['fullName'];
        $isCreated         ='0';

        $r = shell_exec("php /home/tulia/public_html/dev.tulia.tech/index.php admin Users sendNotificationToAllUser '".$usertype."' '".$isCreated."' '".$user_id."' '".$_POST['msg']."' '".$userName."' >> /home/tulia/public_html/dev.tulia.tech/bg_notification_log.txt &");

         if($usertype=='users'){
         $baseUrl= base_url("admin/users/?userType=user");
         }else{
          $baseUrl= base_url("admin/users/?userType=vendor");
         }

        $response = array('status' => 1, 'message' => 'Send successfully', 'url' => $baseUrl); 
        echo json_encode($response); 
    }

    function sendNotificationToAllUser($usertype,$eventId,$userId,$message,$userName){
        if($usertype=='users'){
            $where = array('userType'=>'users','status'=>1);
        }else{
            $where = array('userType'=>'vendor','status'=>1);
        }
        $select='*';
        $all_user_data = $this->common_model->getMultipleData1($select,$where,USERS);

        foreach($all_user_data as $data){
         $registrationIds[] = $data->deviceToken; 
        }  
         $user_id           = $userId; //user id      
         $title             = 'Tulia sent you message' ;
         $body_send         =  $message;
         $add_post          =  '0';
         $notif_type        = 'admin_messages';
         $this->load->model('user_model');
         $notif_msgs        = $this->user_model->send_push_notification($registrationIds, $title, $body_send, $add_post,$notif_type);
        
    }
      

   
} //End class
