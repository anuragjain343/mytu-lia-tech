<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//User API controller
class User extends CommonService{
    
    public function __construct(){
        parent::__construct();
        $this->load->model('Image_model'); //load image model
        $this->alb_img_width = $this->alb_img_height = 720;  //custom album image size in px
        $this->alb_folder     = 'user_album';   //album folder
        $this->avatar_folder  = 'user_avatar';  //user avatar folder
        $this->list_limit = 20;  //limit record
    }
    
    //user profile update
    function profileUpdate_post(){
        
        //check for auth
        if(!$this->check_service_auth()){
            $this->response($this->token_error_msg(), SERVER_ERROR);  //authetication failed
        }
        
        $user_id = $this->authData->id; 
        $existing_img = $this->authData->image; 
        $this->form_validation->set_rules('fullName', 'Name', 'trim|required|min_length[2]|max_length[100]|callback__alpha_spaces_check');
        $this->form_validation->set_rules('contactNumber', 'Mobile Number', 'trim|required|numeric|callback__check_unique_contact');
        $this->form_validation->set_rules('address', 'Address', 'trim|min_length[2]|max_length[200]');
        $this->form_validation->set_rules('email', 'Email address', 'trim|valid_email|max_length[200]|callback__check_unique_email');
        $this->form_validation->set_rules('countryCode', 'Country code', 'trim|required');
        $this->form_validation->set_rules('latitude', 'Address', 'trim|required');
        $this->form_validation->set_rules('longitude', 'Address', 'trim|required');
        
        //for vendor
        $meta_arr = array();
        if($this->authData->userType == 'vendor'){
            $this->form_validation->set_rules('price', 'Price', 'trim|required|numeric');
            $this->form_validation->set_rules('currency_code', 'Currency', 'trim|required');
            $this->form_validation->set_rules('currency_symbol', 'Currency', 'trim|required');
            $this->form_validation->set_rules('description', 'Description', 'trim|min_length[2]|max_length[200]');
            $this->form_validation->set_rules('category', 'Category', 'trim|required|numeric'); 
            $meta_arr = array('price','currency_code','currency_symbol','description');
        }
        
        if($this->form_validation->run() == FALSE){
            $response = array('status' => FAIL, 'message' => strip_tags(validation_errors()));
            $this->response($response);
        }
        else{
            $image = array(); 
            if (!empty($_FILES['user_avatar']['name'])) {
                
                $height = $width = 600;
                $image = $this->Image_model->updateMedia('user_avatar', $this->avatar_folder, $height, $width,FALSE); //upload media of category
                //check for error
                if(array_key_exists("error",$image) && !empty($image['error'])){
                    $response = array('status' => 0, 'message' => $image['error']);
                    echo json_encode($response);
                }
            }
                     
            $set = array('fullName','email', 'contactNumber','address','countryCode','latitude','longitude');
            foreach ($set as $key => $val) {
                $post= $this->post($val);
                if(!empty($post))
                    $update_data[$val] = $post;   //take data if it is not empty
            }
            
            //check for image name if present
            $new_file = 0;
            if(array_key_exists("image_name",$image)){
                $user_image = $image['image_name'];
                if(!empty($user_image)){
                    $update_data['image'] = $user_image;
                    $new_file = 1;
                    //delete old attachment from server
                    if(!empty($existing_img)){
                        $this->common_model->delete_attachment($user_id, USERS, $existing_img);
                    }
                }
            }
            
            //update user data
            $update_where = array('id'=>$user_id); 
            $this->common_model->updateFields(USERS, $update_data, $update_where);  
            
            //update user category
            $meta_where = array('user_id'=>$user_id);
            $cat_id = $this->post('category');
            $this->common_model->updateFields(USR_CAT_MAPPING, array('category_id'=>$cat_id), $meta_where);  
            
            //to update user(vendor) meta data
            if(!empty($meta_arr)){
                 foreach ($meta_arr as $val) {
                    $meta = $this->post($val);
                    if(!empty($meta))
                        $meta_data[$val] = $meta;   //take data if it is not empty
                }
                
                //check if meta data exist for current user
                $is_exist = $this->common_model->is_data_exists(USER_META, $meta_where);
                if($is_exist){
                    //update user meta data
                    $this->common_model->updateFields(USER_META, $meta_data, $meta_where);  //update user meta data
                } else{
                    //insert user meta data
                    $meta_data['user_id'] = $user_id;
                    $this->common_model->insertData(USER_META, $meta_data);
                }
            }

            if(!empty($new_file)){
                if(array_key_exists("attachments",$image) && !empty($image['attachments']) ){
                    //update attachement with category ID
                    foreach($image['attachments'] as $att_id){
                        $where = array('id'=>$att_id);
                        $update = array('reference_id'=>$user_id, 'reference_table'=>USERS);
                        $this->common_model->updateFields(ATTACHMENTS, $update, $where);  //update attachemnt with category id
                    }
                }  
            }
            $user_detail = $this->service_model->userInfo(array('id' => $user_id));
            $response = array('status' => SUCCESS, 'message' => 'Successfully updated', 'userDetail'=>$user_detail); //success msg
            $this->response($response);
        }
    }
    
    //get user details by user ID
    public function getUser_get(){
        //check for auth
        if(!$this->check_service_auth()){
            $this->response($this->token_error_msg(), SERVER_ERROR);  //authetication failed
        }
        
        $user_id = $this->get('user_id'); //user ID of user which we need to get detail for
        $user_detail = $this->common_model->user_details($user_id); //get user details
        if(!empty($user_detail)){
            $response = array('status' => SUCCESS, 'userDetail'=>$user_detail); //success msg
        }
        else{
            $response = array('status' => FAIL, 'message'=>ResponseMessages::getStatusCodeMessage(137)); //fail- record does not exist
        }
        $this->response($response);
    }
    
    //get user list by user type (old)
    public function getUserList_get(){
        if(!$this->check_service_auth()){
            $this->response($this->token_error_msg(), SERVER_ERROR); //authentication failed
        }
        $current_user_id = $this->authData->id;
        $offset = $this->get('offset'); $limit = $this->get('limit'); $search_name = $this->get('search_name');
        if(empty($offset) || empty($offset)){
            $limit= $this->list_limit; $offset = 0;
        }
        
        $user_type = $this->get('user_type');
        $category_id = $this->get('category_id');
        
        //check if search query is present
        if(!empty($search_name)){
            $user_list = $this->common_model->search_user_list($user_type, $category_id, $search_name, $limit, $offset=0, $check_status=true);
        }
        else {
            $user_list = $this->common_model->user_list($user_type, $category_id, $limit, $offset, $check_status=true);
        }
        $response = array('status' => SUCCESS, 'userList'=>$user_list); //success msg
        $this->response($response);
    }


    //get user list by user type - (add latitude and longitute) after changes 
    public function getUserList_v2_get(){
        if(!$this->check_service_auth()){
            $this->response($this->token_error_msg(), SERVER_ERROR); //authentication failed
        }
        $current_user_id = $this->authData->id;
        $offset = $this->get('offset'); $limit = $this->get('limit'); $search_name = $this->get('search_name');
        if(empty($offset) || empty($offset)){
            $limit= $this->list_limit; $offset = 0;
        }
        
        $user_type = $this->get('user_type');
        $category_id = $this->get('category_id');
        $latitude = $this->get('latitude');
        $longitude = $this->get('longitude');
        
        //check if search query is present
        if(!empty($search_name)){
            $user_list = $this->common_model->search_user_list1($user_type, $category_id, $search_name, $limit, $offset=0, $check_status=true);
        }
        else {
            $user_list = $this->common_model->user_list1($user_type, $category_id, $limit, $offset, $check_status=true,$latitude,$longitude);
        }
        $response = array('status' => SUCCESS, 'userList'=>$user_list); //success msg
        $this->response($response);
    }
      //get user list by user type - (add latitude and longitute) after changes 
    public function getUserList_v3_get(){
        if(!$this->check_service_auth()){
            $this->response($this->token_error_msg(), SERVER_ERROR); //authentication failed
        }
        $current_user_id = $this->authData->id;
        $offset = $this->get('offset'); $limit = $this->get('limit');
        if(empty($offset) || empty($offset)){
            $limit= $this->list_limit; $offset = 0;
        }
        
        $user_type      = $this->get('user_type');
        $category_id    = $this->get('category_id');
        $latitude       = $this->get('latitude');
        $longitude      = $this->get('longitude');
        //$location = $this->get('location');
        
        //check if search query is present
        if(!empty($search_name)){
            $user_list = $this->common_model->search_user_list1($user_type, $category_id, $search_name, $limit, $offset=0, $check_status=true);
        }
        else {
            $user_list = $this->common_model->user_list1($user_type, $category_id, $limit, $offset, $check_status=true,$latitude,$longitude);
        }
        $response = array('status' => SUCCESS, 'userList'=>$user_list); //success msg
        $this->response($response);
    }
    
    //get user reviews by user ID
    public function getUserReviews_get(){
        
        if(!$this->check_service_auth()){
            $this->response($this->token_error_msg(), SERVER_ERROR); //authentication failed
        }
        $current_user_id = $this->authData->id;
        $offset = $this->get('offset'); $limit = $this->get('limit');
        if(empty($offset) || empty($limit)){
            $limit= $this->list_limit; $offset = 0;
        }
        $user_id = $this->get('user_id');
        $user_reviews = $this->common_model->get_user_reviews($user_id, $limit, $offset, $check_status=true);
        $response = array('status' => SUCCESS, 'reviewList'=>$user_reviews); //success msg
        $this->response($response);
    }
    
    //add review for user(vendor)
    public function addReview_post(){
        if(!$this->check_service_auth()){
            $this->response($this->token_error_msg(), SERVER_ERROR); //authentication failed
        }
        $current_user_id = $this->authData->id;
        
        $this->form_validation->set_rules('rating', 'rating', 'trim|required|numeric');
        $this->form_validation->set_rules('review_description', 'Feedback', 'trim|required|min_length[2]|max_length[200]');
        $this->form_validation->set_rules('review_for', 'Review', 'required', array('required'=>'Please select user to review for'));
        
        if($this->form_validation->run() == FALSE){
            $response = array('status' => FAIL, 'message' => strip_tags(validation_errors()));
            $this->response($response);
        }
        else{
            $set = array('review_for', 'rating', 'review_description');
            foreach ($set as $key => $val) {
                $post= $this->post($val);
                if(!empty($post))
                    $insert_data[$val] = $post;
            }
            $insert_data['review_by'] = $current_user_id;
            $insert_data['created_on'] = datetime();
        }
        
        $review_id = $this->common_model->insertData(REVIEWS, $insert_data);  //insert new post data
        if($review_id){
            $review_for = $insert_data['review_for'];
            $review_data = $this->common_model->get_user_reviews($review_for, 1, $offset=0, $check_status=true); //get last inserted review data
            $user_info =  $this->common_model->getsingle(USERS, array('id'=>$review_for), 'id, deviceToken');
            if(!empty($user_info)){
                //prepare notification payload
                $registrationIds[] = $user_info->deviceToken; $title = "Reviewed your profile";
                $body_send = $this->authData->fullName.' posted a review';  //body to be sent with current notification
                $body_save = '[UNAME] posted a review'; //body to be saved in DB
                $notif_type = 'user_review';

                $notif_msg = $this->send_push_notification($registrationIds, $title, $body_send, $review_for, $notif_type);

                if($notif_msg){
                    $notif_msg['body'] = $body_save; //replace body text with placeholder text
                    //save notification
                    $insertdata = array('notification_by'=>$current_user_id, 'notification_for'=>$review_for, 'notification_message'=>json_encode($notif_msg), 'notification_type'=>$notif_type, 'reference_id'=>$notif_msg['reference_id'] , 'created_on'=>datetime());
                    $this->notification_model->save_notification(NOTIFICATIONS, $insertdata);
                }
            }
            
            $response = array('status'=>SUCCESS,'message'=>ResponseMessages::getStatusCodeMessage(125), 'reviewDetail'=>$review_data);
        }
        else{
            $response = array('status'=>FAIL,'message'=>ResponseMessages::getStatusCodeMessage(118)); //fail- something went wrong
        }
        
        $this->response($response);
    }
    
    //delete review
    public function deleteReview_post(){
        if(!$this->check_service_auth()){
            $this->response($this->token_error_msg(), SERVER_ERROR); //authentication failed
        }
        $current_user_id = $this->authData->id;
        $review_id = $this->post('review_id');
        
        //check if we have review ID
        if(empty($review_id)){
            $response = array('status' => FAIL, 'message' => ResponseMessages::getStatusCodeMessage(137));
            $this->response($response);
        }
        
        //check if review is for current user
        $is_exist = $this->common_model->is_data_exists(REVIEWS, array('id'=>$review_id, 'review_for'=>$current_user_id));
        if(!$is_exist){
            $response = array('status' => FAIL, 'message' => ResponseMessages::getStatusCodeMessage(136)); 
            $this->response($response);
        }
        
        $is_del = $this->common_model->deleteData(REVIEWS, array('id'=>$review_id));
        if($is_del){

            $this->common_model->deleteData(NOTIFICATIONS,array('reference_id'=>$current_user_id));
            $response = array('status' => SUCCESS, 'message' => ResponseMessages::getStatusCodeMessage(138));
        } else{
            $response = array('status' => FAIL, 'message' => ResponseMessages::getStatusCodeMessage(118));
        }
        $this->response($response);
    }
    
    /*
     * Add Album
     * Update (31-10-2018): From now for album one image at a time will be uploaded.
     * So, first we will make upload attachment API and will create an album with 'Untitled' title 
     * and then attach that image to newly created album ID. So, addAlbum API will not be needed now.
     * We will always call updateAlbum API
     */
    public function addAlbum_post(){
    
        if(!$this->check_service_auth()){
            $this->response($this->token_error_msg(), SERVER_ERROR); //authentication failed
        }
        $current_user_id = $this->authData->id;
        $this->form_validation->set_rules('album_title', 'Title', 'trim|required|min_length[2]|max_length[50]|callback__alpha_spaces_check');
        $this->form_validation->set_rules('album_description', 'Description', 'trim|max_length[200]');
        if($this->form_validation->run() == FALSE){
            $response = array('status' => FAIL, 'message' => strip_tags(validation_errors()));
            $this->response($response);
        }
        else{
          //echo  json_encode($_FILES); die;
            $alb_img_key = 'album_images'; $files = $_FILES; $filesCount = 0; $error_details = array(); $att_arr = array();
            if(!empty($_FILES[$alb_img_key]['name'])){
                $filesCount = count($_FILES[$alb_img_key]['name']);   //check image count
                
                if($filesCount>5){
                    $response = array('status' => FAIL, 'message' => 'Maximum 5 images are allowed');
                    $this->response($response);
                }
            }
            
            //loop through images array and upload single image in each iteration 
            for($i = 0; $i < $filesCount; $i++){
                $_FILES['album_image']['name'] = $files[$alb_img_key]['name'][$i];
                $_FILES['album_image']['type'] = $files[$alb_img_key]['type'][$i];
                $_FILES['album_image']['tmp_name'] = $files[$alb_img_key]['tmp_name'][$i];
                $_FILES['album_image']['error'] = $files[$alb_img_key]['error'][$i];
                $_FILES['album_image']['size'] = $files[$alb_img_key]['size'][$i];

                //upload each image and insert data in attachemnt table
                $image = $this->Image_model->updateMedia('album_image', $this->alb_folder, $this->alb_img_height, $this->alb_img_width, FALSE);  
                //check if attachment ID exists for last upload
                if(array_key_exists("attachments",$image) && !empty($image['attachments'])){
                    $att_arr = array_merge($att_arr, $image['attachments']);  //merge attachments   
                }
                else{
                    //check for error
                    if(array_key_exists("error",$image) && !empty($image['error'])){
                        //error message and file name
                        $error_details[] = array('message'=>$image['error'], 'file_name'=>$_FILES['album_image']['name']);
                    }
                }
            }
            
            //if no attachment uploaded then return error message
            if(empty($att_arr)){
                $response = array('status'=>FAIL,'message'=>'Please upload image', 'errorDetail'=>$error_details);
                $this->response($response);
            }   
            
            //all is fine create album
            $set = array('album_title','album_description'); //set insert data
            foreach ($set as $key => $val) {
                $post= $this->post($val);
                $insert_data[$val] = (isset($post) && !empty($post)) ? $post :''; 
            }
            $insert_data['user_id'] = $current_user_id;
            $insert_data['created_on'] = $insert_data['updated_on'] = datetime();
            $album_id = $this->common_model->insertData(ALBUMS, $insert_data);  //insert album data and get album ID
            
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
        }
        $response = array('status'=>SUCCESS,'message'=>ResponseMessages::getStatusCodeMessage(125), 'albumDetail'=>$alb_detail, 'errorDetail'=>$error_details);
        $this->response($response);  //return response
    }
    
    //upload album attachment(Image)
    public function addAlbumImage_post(){
        //check for auth
        if(!$this->check_service_auth()){
            $this->response($this->token_error_msg(), SERVER_ERROR); //authentication failed
        }
        $current_user_id = $this->authData->id;
        $album_id = $this->post('album_id');
        
        if(empty($_FILES['album_image']['name'])){
            $response = array('status' => FAIL, 'message' => 'Please select image');
            $this->response($response);
        }
        
        if(!empty($album_id)){
            //check if album exist
            $where = array('id' => $album_id);
            $albumExist = $this->common_model->is_data_exists(ALBUMS, $where);
            if($albumExist === FALSE){
                $response = array('status' => FAIL, 'message' => 'Album does not exist');
                $this->response($response);
            }
            
            //Get event image count and check if album image limit is reached (For album max 5 images can be uploaded)
            $count_where = array('album_id' => $album_id);
            $image_count = $this->common_model->get_total_count(ALBUM_ATTACHMENTS, $count_where);
            if($image_count >= 5){
                $response = array('status' => FAIL, 'message' => 'Maximum 5 images are allowed');
                $this->response($response);
            }
        }
        
        $album_image = $this->imageCrop_model->upload_image('album_image', 'user_album' );
        if(is_array($album_image) && array_key_exists("error",$album_image)){
            $response = array('status' => FAIL, 'message' => strip_tags($album_image['error']));
            $this->response($response);
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
            $response = array('status' => FAIL, 'message' => ResponseMessages::getStatusCodeMessage(118));
            $this->response($response);
        }
        
        $album_detail['album_id'] = $album_id;
        $album_detail['image_id'] = $attachment_id;
        $album_detail['album_thumb_image'] = base_url().ALBUM_IMAGE_PATH.'thumb/'.$album_image;
        $album_detail['album_image'] = base_url().ALBUM_IMAGE_PATH.$album_image;
        
        $response = array('status' => SUCCESS, 'message' => 'Image uploaded successfully', 'albumDetail'=>$album_detail);
        $this->response($response);
    }
    
    //update Album
    public function updateAlbum_post(){
        
        if(!$this->check_service_auth()){
            $this->response($this->token_error_msg(), SERVER_ERROR); //authentication failed
        }
        $current_user_id = $this->authData->id;
        
        $this->form_validation->set_rules('album_title', 'Title', 'trim|required|min_length[2]|max_length[50]|callback__alpha_spaces_check');
        $this->form_validation->set_rules('album_description', 'Description', 'trim|max_length[200]');
        $this->form_validation->set_rules('album_id', 'Album', 'required', array('required'=>'Please select album to update'));
        
        if($this->form_validation->run() == FALSE){
            $response = array('status' => FAIL, 'message' => strip_tags(validation_errors()));
            $this->response($response);
        }
        
        $album_id = $this->post('album_id');
        
        //check if album exist
        $where = array('id' => $album_id);
        $albumExist = $this->common_model->is_data_exists(ALBUMS, $where);
        if($albumExist === FALSE){
            $response = array('status' => FAIL, 'message' => 'Album does not exist');
            $this->response($response);
        }

        //all is fine update album now
        $set = array('album_title','album_description');  //set update data
        foreach ($set as $key => $val) {
            $post= $this->post($val);
            $update_data[$val] = (isset($post) && !empty($post)) ? $post :''; 
        }
        $update_data['user_id'] = $current_user_id;
        $update_data['updated_on'] = datetime();
        $this->common_model->updateFields(ALBUMS, $update_data, array('id'=>$album_id));  //update album data

        $alb_detail = $this->common_model->get_user_album_by_id($album_id); //get last inserted album detail
        
        $response = array('status'=>SUCCESS,'message'=>ResponseMessages::getStatusCodeMessage(135), 'albumDetail'=>$alb_detail);
        $this->response($response);  //return response
    }
    
    //delete single album attachment via attachment ID
    function deleteAlbumImage_post(){
        
        if(!$this->check_service_auth()){
            $this->response($this->token_error_msg(), SERVER_ERROR); //authentication failed
        }
        
        $this->form_validation->set_rules('image_id', 'Image Id', 'trim|required');
        
        if($this->form_validation->run() == FALSE){
            $response = array('status' => FAIL, 'message' => strip_tags(validation_errors()));
            $this->response($response);
        }
        
        $attachment_id = $this->post('image_id');
        $where = array('id'=>$attachment_id);
        
        $image_detail = $this->common_model->getsingle(ALBUM_ATTACHMENTS, $where);
        
        if(empty($image_detail)){
            $response = array('status' => FAIL, 'message' => 'Sorry, no record found');
            $this->response($response);
        }
        
        //Check album image count and prevent deletion of last image (Atleast one image is required for an album)
        $where_count = array('album_id'=>$image_detail->album_id);
        $image_count = $this->common_model->get_total_count(ALBUM_ATTACHMENTS, $where_count);
        if($image_count == 1){
            $response = array('status' => FAIL, 
                'message' => 'Cannot delete this image. Atleast one image is required for an album.');
            $this->response($response);
        }
        
        $path = ALBUM_IMAGE_PATH;
        $attachment_data = $this->common_model->getsingle(ALBUM_ATTACHMENTS, $where);
        
        if(!empty($attachment_data)){
            $this->imageCrop_model->delete_image($path, $attachment_data->attachment_name); //unlink attachment
            $this->common_model->deleteData(ALBUM_ATTACHMENTS, $where); //delete record from table
            $response = array('status' => SUCCESS, 'message' => 'Image deleted successfully.'); //email 
        }else{
            $response = array('status' => FAIL, 'message' => 'Album media does not exist'); //email not 
        }
        
        $this->response($response);
    }
    
    //delete user album by album ID
    public function deleteAlbum_post(){
        if(!$this->check_service_auth()){
            $this->response($this->token_error_msg(), SERVER_ERROR); //authentication failed
        }
        $current_user_id = $this->authData->id;
        $album_id = $this->post('album_id');
        if(empty($album_id)){
            $response = array('status'=>FAIL, 'message'=>ResponseMessages::getStatusCodeMessage(137));
            $this->response($response);
        }
        
        //check if album exists and belongs to current user
        $is_exist = $this->common_model->is_data_exists(ALBUMS, array('id'=>$album_id, 'user_id'=>$current_user_id));
        if(!$is_exist){
            $response = array('status'=>FAIL, 'message'=>ResponseMessages::getStatusCodeMessage(137));
            $this->response($response);
        }
        
        $this->common_model->delete_album_attachments($album_id); //delete attachment entires from table and folder
        $this->common_model->deleteData(ALBUMS, array('id'=>$album_id)); //delete album row from table
        
        $response = array('status'=>SUCCESS, 'message'=>ResponseMessages::getStatusCodeMessage(138));
        $this->response($response);
    }
    
    //get user album list by user ID
    public function getAlbumList_get(){
        //check for auth
        if(!$this->check_service_auth()){
            $this->response($this->token_error_msg(), SERVER_ERROR); //authentication failed
        }
        $current_user_id = $this->authData->id;
        
        $offset = $this->get('offset'); $limit = $this->get('limit'); $user_id = $this->get('user_id');
        if(empty($offset) || empty($limit)){
            $limit = $this->list_limit; $offset = 0;
        }
        
        $album_details['count'] = $this->common_model->get_total_count(ALBUMS, array('user_id'=>$user_id)); //get user album count
        if($album_details['count']>0){
            $album_details['list'] = $this->common_model->get_user_album_list($user_id, $limit, $offset); //get all albums of user by userID
            
            $response = array('status'=>SUCCESS, 'albumDetail'=>$album_details);
        }
        else{
            $response = array('status'=>FAIL, 'message'=>ResponseMessages::getStatusCodeMessage(137));
        }
        
        $this->response($response); 
    }
    
    //user password change
    public function changePassword_post(){
        //check for auth
        if(!$this->check_service_auth()){
            $this->response($this->token_error_msg(), SERVER_ERROR); //authentication failed
        }
        $current_user_id = $this->authData->id;
        $where = array('id'=>$current_user_id);
        
        $this->form_validation->set_rules('old_pass', 'Old Password', 'trim|required');
        $this->form_validation->set_rules('new_pass', 'New Password', 'trim|required|min_length[6]|max_length[50]');
        
        if($this->form_validation->run() == FALSE){
            $response = array('status' => FAIL, 'message' => strip_tags(validation_errors()));
            $this->response($response);
        }
        
        //get user current password
        $user_pass = $this->common_model->get_field_value(USERS, $where, 'password'); 
        if(!$user_pass){
            $response = array('status' => FAIL, 'message' => ResponseMessages::getStatusCodeMessage(137));  //no record found
            $this->response($response);
        }
        
        $old_pass = $this->post('old_pass');  $new_pass = $this->post('new_pass');
        
        //verify password- It is good to use php's password hashing functions so we are using password_verify fn here
        if(!password_verify($old_pass, $user_pass)){
            $response = array('status' => FAIL, 'message' => 'Old Password does not match'); //password does not match
            $this->response($response);
        }
        
        //update new password of user
        $new_pass_hash = password_hash($new_pass, PASSWORD_DEFAULT);  //it is goood to use php's password hashing algo
        $is_updated = $this->common_model->updateFields(USERS, array('password'=> $new_pass_hash), $where);
        if($is_updated){
            $response = array('status' => SUCCESS, 'message' => ResponseMessages::getStatusCodeMessage(135)); //updated successfully
        } else{
            $response = array('status' => FAIL, 'message' => ResponseMessages::getStatusCodeMessage(118)); //failed to update
        }
        $this->response($response);
    }
    
    //forgot(reset) password
    public function resetPassword_post(){
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        
        if($this->form_validation->run() == FALSE){
            $response = array('status' => FAIL, 'message' => strip_tags(validation_errors()));
            $this->response($response);
        }
        
        $email = $this->post('email');
        
        $user = $this->common_model->getsingle(USERS, array('email'=>$email), 'id, fullName');
        if(empty($user)){
            $response = array('status' => FAIL, 'message' => 'This email address is does not exists');
            $this->response($response);
        }
        
        
        $new_pass = mt_rand(100000, 999999); //generate a random 6 digit number
        
        //update new password of user
        $new_pass_hash = password_hash($new_pass, PASSWORD_DEFAULT);  //it is goood to use php's password hashing algo
        $is_updated = $this->common_model->updateFields(USERS, array('password'=> $new_pass_hash), array('id'=>$user->id)); 
        if($is_updated){
            //send mail to user
            
            $data['full_name'] = $user->fullName; $data['new_password'] = $new_pass; 
            $message = $this->load->view('email/reset_password', $data, true); 
            $this->load->library('smtp_email');
            $subject = 'Tulia- Reset Password'; 
            
            $isSend = $this->smtp_email->send_mail($email,$subject,$message); 
            if($isSend){
                $response = array('status' => SUCCESS, 'message' => 'We have sent you a message. Please check your mail.'); //email sent
            }
            else{
                $response = array('status' => FAIL, 'message' => 'Error, not able to send email'); //email not sent
            }
            
        } else{
            $response = array('status' => FAIL, 'message' => ResponseMessages::getStatusCodeMessage(118)); //failed to update
        }
        
        $this->response($response);
    }
    
    //user logout
    public function logout_get(){
        if(!$this->check_service_auth()){
            $this->response($this->token_error_msg(), SERVER_ERROR); //authentication failed
        }
        //empty device token on when user logged out
        $logout = $this->common_model->updateFields(USERS, array('deviceToken' =>''), array('id'=>$this->authData->id));
       
        $response = array('status'=>SUCCESS,'message'=>ResponseMessages::getStatusCodeMessage(139));
        
        $this->response($response);
    }
    
    //get all notifications of user
    public function getUserNotificationList_get(){
        if(!$this->check_service_auth()){
            $this->response($this->token_error_msg(), SERVER_ERROR); //authentication failed
        }
        
        //get latest 50 notifications of user and detail of notification_by user
        $res_arr = $this->common_model->GetJoinRecord(NOTIFICATIONS, 'notification_by', USERS, 'id', 'notification_for, notification_message, notification_type, notification_by, created_on, fullName, image', array('notification_for'=>$this->authData->id) , '', 'created_on', 'DESC', 50, 0);
        
        if(!empty($res_arr['result'])){
            $all_notif = $res_arr['result']; $u_name = $e_name = '';
            foreach($all_notif as $k=>$v){
                $notif_payload = json_decode($v->notification_message);
                
                //if notification is related to post then get event name
                if($v->notification_type=='post_doing' || $v->notification_type=='post_create'){
                    //replace placeholder name with real event name
                    $notif_payload->body = $this->service_model->replace_event_placeholder_name($notif_payload->reference_id, $notif_payload->body);
                }
                
                //get fullName of user
                $notif_payload->body = $this->service_model->replace_user_placeholder_name($v->notification_by, $notif_payload->body);
                
                $all_notif[$k]->notification_message = $notif_payload;
                $v->user_image = make_user_img_url($v->image); //make url from image name
                $v->time_elapsed = time_elapsed_string($v->created_on); //add time_elapsed key to show time elapsed in user friendly string
            }
            $response = array('status'=>SUCCESS,'notificationDetails'=>$all_notif);
        }
        else{
            $response = array('status'=>FAIL,'message'=>ResponseMessages::getStatusCodeMessage(137));
        }
        $this->response($response);
    }
    
    //validation callback check if entered email is does not exists for any other user
    public function _check_unique_email($email){
        $user_id = $this->authData->id; //current user ID
        $email_exist = $this->common_model->is_data_exists(USERS, array('email'=>$email, 'id !='=>$user_id));
        
        if($email_exist){
            $this->form_validation->set_message('_check_unique_email','This email already exist');
            return FALSE;
        }else{
           return TRUE;
        }
    }

     //validation callback check if entered contact is does not exists for any other user
    public function _check_unique_contact($contactNumber){
        $user_id = $this->authData->id; //current user ID
        $contact_exist = $this->common_model->is_data_exists(USERS, array('contactNumber'=>$contactNumber, 'id !='=>$user_id));
        
        if($contact_exist){
            $this->form_validation->set_message('_check_unique_contact','This contact already exist');
            return FALSE;
        }else{
           return TRUE;
        }
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

}//End Class

