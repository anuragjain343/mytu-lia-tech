<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Vendorpost extends FrontCommon_Controller {

    function __construct() {
        parent::__construct();
        
    }

    function checklogin(){
        $current_user_id = $this->session->userdata('id');
        
        if($current_user_id){
            $this->load->model('service/service_model');
            //get latest 50 notifications of user and detail of notification_by user
            $res_arr = $this->common_model->GetJoinRecord(NOTIFICATIONS, 'notification_by', USERS, 'id', '*,notifications.id as n_id', array('notification_for'=>$current_user_id,'is_show'=>0) , '', 'created_on', 'DESC', 1, 0);

            
            $all_notif = $res_arr['result']; $u_name = $e_name = '';
            if($all_notif){
                $this->common_model->updateData('notifications',array('status' => 1), array( 'id' => $all_notif[0]->n_id));

                    $v = $all_notif[0];
                    $notif_payload = json_decode($v->notification_message);
                    //if notification is related to post then get event name
                    if($v->notification_type=='post_doing' || $v->notification_type=='post_create')
                    {
                        //replace placeholder name with real event name
                        $notif_payload->body = $this->service_model->replace_event_placeholder_name($notif_payload->reference_id, $notif_payload->body);
                    }

                    //get fullName of user
                    $notif_payload->body = $this->service_model->replace_user_placeholder_name($v->notification_by, $notif_payload->body);

                    $all_notif[0]->notification_message = $notif_payload;
                    $v->user_image = make_user_img_url($v->image); //make url from image name
                    $v->time_elapsed = time_elapsed_string($v->created_on); //add time_elapsed key to show time elapsed in user friendly string
                echo json_encode($all_notif); die;
            }
            
        }else{
            echo '0';
        }

    }
    
    
/*    function allEvents(){

        $this->check_user_session();
        $user_id =  $current_user_id = $this->session->userdata['id']; //user id
        $this->load->model('Vendorpost_model');
        $limit= '999999'; $offset = 0;
      
        $cat_details = $this->common_model->getsingle(USR_CAT_MAPPING, array('user_id'=>$current_user_id));

        if(empty($cat_details)){
            redirect('/login');
        }
        $where = array('category_id' => $cat_details->category_id,'doi.post_id' => null);
        
        $total = $this->Vendorpost_model->get_post_list($where,$current_user_id, $limit, $offset);
       
        $data['total'] = count($total);
         $data['front_scripts'] = $data['front_styles'] = '';
        
        if($data['total'] == 0){
            $data['title'] = 'Currently, No event available for your business category';
            $data['description'] = 'While any user will post an event then you will notice it, So keep waiting for doing some new work around you.';
            $this->load->front_render('vendorNoPost', $data, '');
        }else{
            $this->load->front_render('allEvent', $data, '');
        }
    }*/
       function allEvents(){
        $this->check_user_session();
        $user_id =  $current_user_id = $this->session->userdata['id']; //user id
        $this->load->model('Vendorpost_model');
        $limit= '999999'; $offset = 0;
      
        $cat_details = $this->common_model->getsingle(USR_CAT_MAPPING, array('user_id'=>$current_user_id));
        $user_details = $this->common_model->getsingle(USERS, array('id'=>$current_user_id));
       $lat =$user_details->latitude;
       $long= $user_details->longitude;
       $data['check_lat_log'] = $user_details;
      
        if(empty($cat_details)){
            redirect('/login');
        }

        $where = array('category_id' => $cat_details->category_id,'doi.post_id' => null);       
        $total = $this->Vendorpost_model->get_post_list($where,$current_user_id, $limit, $offset,$lat,$long); 
           
        $data['total'] = count($total);
        $data['front_scripts'] = $data['front_styles'] = '';
        
        if($data['total'] == 0){
            $data['title'] = 'Currently, No event available for your business category';
            $data['description'] = 'While any user will post an event then you will notice it, So keep waiting for doing some new work around you.';
            $this->load->front_render('vendorNoPost', $data, '');
        }else{
            $this->load->front_render('allEvent', $data, '');
        }
    }

    function event(){

        $user_id =  $current_user_id = $this->session->userdata['id']; //user id
        $this->load->model('Vendorpost_model');
        $this->load->library('Ajax_pagination');
       
        $cat_details = $this->common_model->getsingle(USR_CAT_MAPPING, array('user_id'=>$current_user_id));
        $user_details = $this->common_model->getsingle(USERS, array('id'=>$current_user_id));
       $lat =$user_details->latitude;
       $long= $user_details->longitude;
        $where = array('category_id' => $cat_details->category_id,'doi.post_id' => null);
        
        $total = $this->input->get('totalCount');
        $config['base_url'] = '/home/Vendorpost/event';
        $config['total_rows'] = $total;
        $config['uri_segment'] =4; 
        $config['per_page'] = 5;
        $config['num_links'] = 5;
        $config['first_link'] = FALSE;
        $config['last_link'] = FALSE;
        $config['full_tag_open'] = '<ul class="pagination pagination-sm no-margin cs-no-mr">';
        $config['full_tag_close'] = '</ul>';
        $config['next_link'] = '&raquo;';
        $config['next_tag_open'] = '<li class="next page">';
        $config['next_tag_close'] = '</li>';
        $config['anchor_class'] = 'class="paginationlink" ';
        $config['prev_link'] = '&laquo;';
        $config['prev_tag_open'] = '<li class="prev page">';
        $config['prev_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a>';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li class="page">';
        $config['num_tag_close'] = '</li>';
        $page = $this->uri->segment(4); 
        $limit = $config['per_page'];
        $offset = $page>0?$page:0;
        $this->ajax_pagination->initialize($config);

      /*  $data['data']     = $this->Vendorpost_model->get_post_list($where,$current_user_id, $limit, $offset);*/
       $data['data']     = $this->Vendorpost_model->get_post_list($where,$current_user_id, $limit, $offset,$lat,$long);
     /* echo "<pre>";
       print_r($data);die;
*/
       
        $data['pagination'] = $this->ajax_pagination->create_links();
        $this->load->view('event',$data); 
    }

    function myAllEvents(){
        $this->check_user_session();
        $current_user_id = $this->session->userdata['id']; //user id
        $limit= 999999; $offset = 0;
        $total = $this->common_model->get_my_post($current_user_id, $limit, $offset, $check_status=true);
        //for check lat log 
        $data['check_lat_log'] = $this->common_model->getsingle(USERS, array('id'=>$current_user_id));
        
        $data['total'] = count($total);
        $data['front_scripts'] = $data['front_styles'] = '';
        
        if($data['total'] == 0){
            $data['title'] = 'Currently, You are not interested in doing any event';
            $data['description'] = 'You need to go to all event page from where you can see all new posts around you.';
            $this->load->front_render('vendorNoPost', $data, '');
        }else{
            $this->load->front_render('myAllEvent', $data, '');
        }
    }

    function myEvent(){
        $current_user_id = $this->session->userdata['id']; //user id
        $this->load->library('Ajax_pagination');
        
        $total = $this->input->get('totalCount');
        $config['base_url'] = base_url().'home/Vendorpost/myEvent';
        $config['total_rows'] = $total;
        $config['uri_segment'] =4; 
        $config['per_page'] = 5;
        $config['num_links'] = 5;
        $config['first_link'] = FALSE;
        $config['last_link'] = FALSE;
        $config['full_tag_open'] = '<ul class="pagination pagination-sm no-margin cs-no-mr">';
        $config['full_tag_close'] = '</ul>';
        $config['next_link'] = '&raquo;';
        $config['next_tag_open'] = '<li class="next page">';
        $config['next_tag_close'] = '</li>';
        $config['anchor_class'] = 'class="paginationlink" ';
        $config['prev_link'] = '&laquo;';
        $config['prev_tag_open'] = '<li class="prev page">';
        $config['prev_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a>';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li class="page">';
        $config['num_tag_close'] = '</li>';
        $page = $this->uri->segment(4); 
        $limit = $config['per_page'];
        $offset = $page>0?$page:0;
        $this->ajax_pagination->initialize($config);
        $data['data']     = $this->common_model->get_my_post($current_user_id, $limit, $offset, $check_status=true);
        $data['pagination'] = $this->ajax_pagination->create_links();
        $this->load->view('myEvent',$data); 
    }

    function eventDetail(){
        $this->check_user_session();
        $customer_id  = $this->uri->segment(4);
        $post_id = decoding($customer_id);
        $is_exist = $this->common_model->is_data_exists(POSTS, array('id'=>$post_id,'status'=>1 ));
        if($is_exist){

            $this->load->model('Vendorpost_model');
            $data['data'] = $this->Vendorpost_model->get_post_detail(array('p.id'=>$post_id));
            $data['front_scripts'] = $data['front_styles'] = '';
            $this->load->front_render('eventDetail',$data); 
        }else{
            $data['front_scripts'] = $data['front_styles'] = '';
            $this->load->front_render('pageNotFound',$data);
        }

    }

    function eventDoing(){ 

        $check_auth = $this->check_ajax_auth(); 
        if($check_auth !== TRUE){ 
            echo $check_auth;
            exit;
        }
        
        $post_id = $this->input->post('post_id');
        $is_data_exists = $this->common_model->is_data_exists(POSTS, array('id'=>$post_id,'status'=>1 ));
        if(!$is_data_exists){
            
            $response = array('status' => 0, 'message' => 'This event does not exist'); //success msg
            echo json_encode($response); exit;
        }
        $this->load->model('Vendorpost_model');
        $insert_data['post_id'] = $post_id;
        $current_user_id = $insert_data['user_id'] = $this->session->userdata('id');
        $insert_data['created_on'] = datetime();
        $last_id = $this->common_model->insertData(DOING_EVENT, $insert_data);  //insert new data
        
        if($last_id){
            
            //send notification
            $post_info = $this->Vendorpost_model->get_post_detail(array('p.id'=>$post_id));
            
            if(!empty($post_info)){
                //prepare notification payload
                $registrationIds[] = $post_info->deviceToken; $title = "Doing your event";
                 //body to be saved in DB //body to be sent with current notification
                $body_send = $this->session->userdata('fullName').' is interested in doing your event '.$post_info->event_name; 
               
                $body_save = '[UNAME] is interested in doing your event [ENAME]';
                $notif_type = 'post_doing';
                
                $notif_msg = $this->send_push_notification($registrationIds, $title, $body_send, $post_id, $notif_type);
                
                if($notif_msg){
                   
                    $notif_msg['body'] = $body_save; //replace body text with placeholder text
                    //save notification
                    $insertdata = array('notification_by'=>$current_user_id, 'notification_for'=>$post_info->post_author, 'notification_message'=>json_encode($notif_msg), 'notification_type'=>$notif_type,'reference_id'=>$notif_msg['reference_id'] , 'created_on'=>datetime());
                    $this->Vendorpost_model->save_notification(NOTIFICATIONS, $insertdata);
                }
            }
            
            $response = array('status' => 1, 'message' => 'Successfully added to my events',  'url' => base_url('home/vendorpost/myAllEvents')); //success msg
            echo json_encode($response);
        }
    }

    function send_push_notification($token_arr, $title, $body, $reference_id, $type){
        if(empty($token_arr)){
            return false;
        }
        $this->load->model('Vendorpost_model');
        //prepare notification message array
        $notif_msg = array('title'=>$title, 'body'=> $body, 'reference_id'=>$reference_id, 'type'=> $type, 'click_action'=>'ChatActivity', 'sound'=>'default');
        $this->Vendorpost_model->send_notification($token_arr, $notif_msg);  //send andriod and ios push notification
        return $notif_msg;  //return message array
    }

    /*
     * Add album method will not be used as of 01-11-2018
     * We will now upload single image and call update_media() instead
     */
    function addAlbum(){  

        $check_auth = $this->check_ajax_auth(); 
        if($check_auth !== TRUE){ 
            echo $check_auth;
            exit;
        }
        //pr($_POST);
        $current_user_id =  $this->session->userdata['id']; //user id
        $this->load->model('Vendorpost_model');
        $this->load->model('image_model');
            //pr($_FILES['album_images']['name']);
            if(!empty($_POST['album_images'])){
                  //$alb_img_key = 'album_images'; 
                  $files = $_POST['album_images']; 
                  $filesCount = 0; $error_details = array(); $att_arr = array();
                //pr($files);
                //$rand  = rand().'.png';
                $filesCount =  count($_POST['album_images']);
               
                $set = array('album_title','album_description'); //set insert data
                foreach ($set as $key => $val) {
                    $post= $this->input->post($val);
                    $insert_data[$val] = (isset($post) && !empty($post)) ? $post :''; 
                }
                $insert_data['user_id'] = $current_user_id;
                $insert_data['created_on'] = $insert_data['updated_on'] = datetime();
                $album_id = $this->common_model->insertData(ALBUMS, $insert_data);  //insert album data and get album ID
                
               
                for($i = 0; $i < $filesCount; $i++){
                    $rand  = rand().'.png';
                    $realImagePath = FCPATH.'uploads/user_album/'.$rand;
                    $res = $this->imageCrop_model->canvasImageUpload($_POST['album_images'][$i],'user_album');
                  
                    //file_put_contents($realImagePath,file_get_contents($_POST['album_images'][$i]));
                    //upload each image and insert d$res;
                    $attr_data['album_id']    = $album_id;
                    $attr_data['attachment_name'] = $res['uploadfile'];
                    $attr_data['created_on'] = datetime();
                     $this->db->insert(ALBUM_ATTACHMENTS, $attr_data);
                    $last_id = $this->db->insert_id();
                }
                
                /*$set = array('album_title','album_description'); //set insert data
                foreach ($set as $key => $val) {
                    $post= $this->input->post($val);
                    $insert_data[$val] = (isset($post) && !empty($post)) ? $post :''; 
                }
                $insert_data['user_id'] = $current_user_id;
                $insert_data['created_on'] = $insert_data['updated_on'] = datetime();
                $album_id = $this->common_model->insertData(ALBUMS, $insert_data);  //insert album data and get album ID*/
                
                //check if album ID created
                if(!$album_id){
                    $response = array('status'=>FAIL,'message'=>ResponseMessages::getStatusCodeMessage(118)); //fail- something went wrong
                    $this->response($response);
                }
                if(!empty($att_arr)){
                    //update attachment with album ID
                    foreach($att_arr as $att_id){
                        $where = array('id'=>$att_id);
                        $update = array('reference_id'=>$album_id, 'reference_table'=>ALBUMS);
                        $this->common_model->updateFields(ATTACHMENTS, $update, $where);
                    }
                }


                $alb_detail = $this->common_model->get_user_album_list($current_user_id, 1, $offset=0); //get last inserted album detail


                if(isset($alb_detail[0]->id)){
                    $response = array('status' => 1, 'message' => 'Successfully added', 'url' => base_url('home/users/vendorMedia')); //success msg
                }else{
                    $response = array('status' => 0, 'message' => 'something went wrong!', 'url' => base_url('home/users/vendorMedia')); //success msg
                }
                echo json_encode($response);

            }else{
                $response = array('status' => 0, 'message' => 'Please select atleast one image'); 
                echo json_encode($response);
            }
 

    }
    
    //Upload single album attachment(Image)
    public function addAlbumImage(){
        //check for auth
        $check_auth = $this->check_ajax_auth(); 
        if($check_auth !== TRUE){ 
            echo $check_auth;
            exit;
        }
        
        $current_user_id = $this->session->userdata['id']; //user id
        $album_id = $this->input->post('album_id');
        //print_r($_FILES); die;
        if(empty($_FILES['album_image']['name'])){
            $response = array('status' => 0, 'message' => 'Please select image');
            echo json_encode($response); die;
        }
        
        if(!empty($album_id)){
            //check if album exist
            $where = array('id' => $album_id);
            $albumExist = $this->common_model->is_data_exists(ALBUMS, $where);
            if($albumExist === FALSE){
                $response = array('status' => 0, 'message' => 'Album does not exist');
                echo json_encode($response); die;
            }
            
            //Get event image count and check if album image limit is reached (For album max 5 images can be uploaded)
            $count_where = array('album_id' => $album_id);
            $image_count = $this->common_model->get_total_count(ALBUM_ATTACHMENTS, $count_where);
            if($image_count >= 5){
                $response = array('status' => 0, 'message' => 'Maximum 5 images are allowed');
                echo json_encode($response); die;
            }
        }
        
        $album_image = $this->imageCrop_model->upload_image('album_image', 'user_album' );
        if(is_array($album_image) && array_key_exists("error",$album_image)){
            $response = array('status' => 0, 'message' => $album_image['error']);
            echo json_encode($response); die;
        }
        
        if(empty($album_id)){
            //album does not exist, create album with 'Untitled' name and attach this image to newly created album
            $insert_data['album_title'] = 'Untitled';
            $insert_data['user_id'] = $current_user_id;
            $insert_data['created_on'] = $insert_data['updated_on'] = datetime();
            $album_id = $this->common_model->insertData(ALBUMS, $insert_data);  //insert album data and get album ID
        }
        
        //all good here, proceed to insert image as album attachment
        
        //image uploaded, no attach image to album
        $album_data['album_id'] = $album_id;
        $album_data['attachment_name'] = $album_image;
        $album_data['created_on'] = datetime();
        $attachment_id = $this->common_model->insertData(ALBUM_ATTACHMENTS, $album_data);
        if(!$attachment_id){
            //fail- something went wrong
            $response = array('status' => 0, 'message' => ResponseMessages::getStatusCodeMessage(118));
            echo json_encode($response); die;
        }
        
        $response = array('status' => 1, 'message' => 'Image uploaded successfully');
        $response['album_id'] = $album_id;
        $response['image_id'] = $attachment_id;
        $response['album_thumb_image'] = base_url().ALBUM_IMAGE_PATH.'thumb/'.$album_image;
        $response['album_image'] = base_url().ALBUM_IMAGE_PATH.$album_image;
        echo json_encode($response); die;
    }
    
    //delete whole album
    function deleteAlbum(){
       
        $check_auth = $this->check_ajax_auth(); 
        if($check_auth !== TRUE){ 
            echo $check_auth;
            exit;
        }
        
        $current_user_id = $this->session->userdata['id']; //user id
        $album_id = $this->input->post('id');
        
        if(empty($album_id)){
            $response = array('status'=>0, 'message'=>ResponseMessages::getStatusCodeMessage(137));
            echo json_encode($response); die;
        }
        
        //check if album exists and belongs to current user
        $is_exist = $this->common_model->is_data_exists(ALBUMS, array('id'=>$album_id, 'user_id'=>$current_user_id));
        if(!$is_exist){
            $response = array('status'=>0, 'message'=>ResponseMessages::getStatusCodeMessage(137));
            echo json_encode($response); die;
        }
        
        $this->common_model->delete_album_attachments($album_id); //delete attachment entires from table and folder
        $this->common_model->deleteData(ALBUMS, array('id'=>$album_id)); //delete album row from table
        
        $response = array('status' => 1, 'message' => 'Deleted Successfully', 'url' => base_url('home/users/vendorMedia')); //success msg
        echo json_encode($response);
    }
    
    //show update album modal
    function updateAlbum(){
        $current_user_id = $this->session->userdata['id']; //user id
        $album_id = $this->input->post('id');
        $data['album_images'] = $this->common_model->get_user_album_by_id($album_id);
        $this->load->view('update_media',$data);
    }

    //delete single attachment in album
    function deleteImage(){
        
        $check_auth = $this->check_ajax_auth(); 
        if($check_auth !== TRUE){ 
            echo $check_auth;
            exit;
        }
        
        $attachment_id = $this->input->post('album_id'); //attachment ID
        $where = array('id'=>$attachment_id);
        
        $image_detail = $this->common_model->getsingle(ALBUM_ATTACHMENTS, $where);
        
        if(empty($image_detail)){
            $response = array('status' => 0, 'message' => 'Sorry, no record found');
            echo json_encode($response); die;
        }
        
        //Check album image count and prevent deletion of last image (Atleast one image is required for an album)
        $where_count = array('album_id'=>$image_detail->album_id);
        $image_count = $this->common_model->get_total_count(ALBUM_ATTACHMENTS, $where_count);
        if($image_count == 1){
            $response = array('status' => 0, 
                'message' => 'Cannot delete this image. Atleast one image is required for an album.');
            echo json_encode($response); die;
        }
        
        $path = ALBUM_IMAGE_PATH;
        $attachment_data = $this->common_model->getsingle(ALBUM_ATTACHMENTS, $where);
        
        if(!empty($attachment_data)){
            $this->imageCrop_model->delete_image($path, $attachment_data->attachment_name); //unlink attachment
            $this->common_model->deleteData(ALBUM_ATTACHMENTS, $where); //delete record from table
            $response = array('status' => 1, 'message' => 'Image deleted successfully.'); //email 
        }else{
            $response = array('status' => 0, 'message' => 'Album media does not exist'); //email not 
        }
        echo json_encode($response); die;
    }
    
    /*
     * Update (01-11-2018): From now for album one image at a time will be uploaded.
     * So, first we will upload attachment and will create an album with 'Untitled' title 
     * and then attach that image to newly created album ID. So, addAlbum method will not be needed now.
     * We will always invoke update_media method
     */
    function update_media(){

        $check_auth = $this->check_ajax_auth(); 
        if($check_auth !== TRUE){ 
            echo $check_auth;
            exit;
        }
        
        $current_user_id = $this->session->userdata['id']; //user id
        
        $this->form_validation->set_rules('album_title', 'Title', 'trim|required|min_length[2]|max_length[50]|callback__alpha_spaces_check');
        $this->form_validation->set_rules('album_description', 'Description', 'trim|max_length[200]');
        $this->form_validation->set_rules('album_id', 'Album', 'required', array('required'=>'Please select album to update'));
        
        if($this->form_validation->run() == FALSE){
            $response = array('status' => 0, 'message' => strip_tags(validation_errors()));
            echo json_encode($response); die;
        }
        
        $album_id = $this->input->post('album_id');
        
        //check if album exist
        $where = array('id' => $album_id);
        $albumExist = $this->common_model->is_data_exists(ALBUMS, $where);
        if($albumExist === FALSE){
            $response = array('status' => 0, 'message' => 'Album does not exist');
            echo json_encode($response); die;
        }

        //all is fine update album now
        $set = array('album_title','album_description');  //set update data
        foreach ($set as $key => $val) {
            $post= $this->input->post($val);
            $update_data[$val] = (isset($post) && !empty($post)) ? $post :''; 
        }
        $update_data['user_id'] = $current_user_id;
        $update_data['updated_on'] = datetime();
        $this->common_model->updateFields(ALBUMS, $update_data, array('id'=>$album_id));  //update album data

        $alb_detail = $this->common_model->get_user_album_by_id($album_id); //get last inserted album detail
        
        $response = array('status'=>1,'message'=>ResponseMessages::getStatusCodeMessage(135), 'url' => base_url('home/users/vendorMedia'));
        echo json_encode($response); die;  //return response
    }
    
    //validation callback to allow alphabet and spaces only
    public function _alpha_spaces_check($string){
        if(alpha_spaces($string)){
            return true;
        }
        else{
            $this->form_validation->set_message('_alpha_spaces_check','Only alphabets and spaces are allowed in {field} field');
            return FALSE;
        }
    }
    
}

