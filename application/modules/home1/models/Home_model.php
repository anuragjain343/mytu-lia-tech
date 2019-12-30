<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home_model extends CI_Model {


	function getAllData($table)
	{
		$this->db->select('*');
		$sql = $this->db->get($table);
		$result = $sql->result_array();
		return $result;
	}

	/* Check user login and set session */
	function isLogin($data, $table)
	{
		$email      = $data['email'];
		$userType   = $data['userType'];
		// check if e-mail address is well-formed
		$where = array('email'=>$email,'userType'=>$userType);
		$sql = $this->db->select('*')->where($where)->get($table);

		if($sql->num_rows())
		{
			$user = $sql->row();
			//check user's status, if 1 then login successfully
			if($user->status == 1){
				//verify password
				if(password_verify($data['password'], $user->password))
				{	
					$this->common_model->updateFields($table,array('deviceToken' => 'system'), $where);
					$session_data['id']         = $user->id ;
					$session_data['fullName']   = $user->fullName ;
					$session_data['email']		= $user->email ;
					$session_data['image']      = make_user_img_url($user->image) ;
					$session_data['userType']   = $user->userType;
					$session_data['isLogin'] 	= TRUE ;
					
					$this->session->set_userdata($session_data);
					return array('status'=>1);
				}
				else
				{
					return array('status'=>2);
				}
			}
			return array('status'=>4);
		}
		return array('status'=>3);
	}//End Function

	function checkEmail($fullName,$email,$contactNumber){
		$where = array('email'=>$email);
		$sql = $this->db->select('*')->where($where)->get(USERS);
		if($sql->num_rows()){
			return 'This email already exists';
		}else{
			$where = array('contactNumber'=>$contactNumber);
			$sql = $this->db->select('*')->where($where)->get(USERS);
			if($sql->num_rows()){
				return 'This contact number already exists';
			}else{
				return 1;
			}
		}
	}


	function checkTypeFB($userId,$userType){
		$where = array('id'=>$userId,'userType'=>$userType);
		$sql = $this->db->select('*')->where($where)->get(USERS);
		if($sql->num_rows()){
			return 1;
		}else{
			return 0;
		}
	}


	function getAllEvent($userId){
		$where = array('user_id'=>$userId);
		$sql = $this->db->select('*')->where($where)->get('user_category_mapping');
		$catId = $sql->row_array();
		$categoryId = $catId['category_id'];

		$where = array('category_id'=>1);
		$sql1 = $this->db->select('*')->where($where)->join('posts','post_category_mapping.post_id = posts.id')->get('post_category_mapping');
		$result = $sql1->result_array();
		return $result;
	}

    function getRandomVendor($user_type,$user_id =''){
   
           if(!empty($user_id)){
   	    	$wh = array('id'=>$user_id);
            $fld = array('latitude','longitude');
            $userlt = $this->common_model->customGet($fld,$wh,USERS); 
            $latitude= $userlt['latitude'];
            $longitude = $userlt['longitude'];

   	     $this->db->select('u.*,COALESCE(cat.name, "") as category_name,COALESCE(att.attachment_name, "") as attachment_name,round(( 6371 * acos( cos( radians("'.$latitude.'") ) * cos( radians(  u.latitude  ) ) * cos( radians( u.longitude ) - radians("'.$longitude.'") ) + sin( radians("'.$latitude.'") ) * sin( radians( u.latitude ) ) ) ),1) AS distance_in_mi');	
   	 	}else{
        $this->db->select('u.*,COALESCE(cat.name, "") as category_name,COALESCE(att.attachment_name, "") as attachment_name');
   		 }
        $this->db->from(USERS .' as u'); //users
		$this->db->join(USR_CAT_MAPPING. ' as map', "u.id = map.user_id","left"); //to get user category
		$this->db->join(CATEGORIES. ' as cat', "map.category_id = cat.id", "left"); //to get category details
		$this->db->join(ATTACHMENTS. ' as att ',"u.id = att.reference_id AND image_size = 'large' AND reference_table ='users'","left");
		//$this->db->where(array('u.userType'=>$user_type,'u.status'=>1)); 
		if(!empty($user_id) && $user_type =='vendor'){
			$this->db->where(array('u.userType'=>$user_type,'u.status'=>1,'u.id!='=>$user_id)); 
		}else{
		   $this->db->where(array('u.userType'=>$user_type,'u.status'=>1)); 
		}
        
        $this->db->group_by('u.id');
        $this->db->limit(6, 0);
        $this->db->order_by('u.id','RANDOM');
         if(!empty($latitude) && !empty($longitude)){
        $this->db->order_by('distance_in_mi', 'ASC');
        $this->db->having(array('distance_in_mi <='=>'100')); 
        }
        $result = $this->db->get(); 
        $res = $result->result();
        if(!empty($res)){
            foreach($res as $v){ 
              
				if (!empty($v->image)) {
					$image = $v->image;
					//check if image consists url- happens in social login case
					if (filter_var($v->image, FILTER_VALIDATE_URL)) { 
						$v->user_image = $image;
					}
					else{
						$v->user_image = base_url().USER_AVATAR_PATH.$v->attachment_name;
					}
				}
				else{
					$v->user_image = base_url().USER_DEFAULT_AVATAR; //return default image if image is empty
				}
            }
        }
        return $res;	

    } 

    function getBlogs($data){

    	$this->db->select('b.*,att.attachment_name as blog_image,att.attachment_type as type');
    	$this->db->join(ATTACHMENTS. ' as att ',"b.blogId = att.reference_id AND image_size = 'large' AND reference_table ='blogs'","left");
    	$this->db->from(BLOG. ' as b');
	    $this->db->limit($data['limit'], $data['offset']);
	    $this->db->order_by('b.blogId', 'DESC');
	    $result = $this->db->get();
	    $res = $result->result(); 
	    if(!empty($res))
	    	foreach ($res as $val) {
	    		$val->blog_image = base_url().BLOG_CONTENT.$val->blog_image;
            }

	    return $res;
    }

    function getCategoryImg(){
    	$category_img = base_url().CATEGORY_IMAGE_PATH;
    	$this->db->select('c.name,c.id, concat("'.$category_img.'",att.attachment_name) as cat_image
    		');
    	$this->db->join(ATTACHMENTS. ' as att ',"c.id = att.reference_id AND image_size = 'large' AND reference_table ='categories'","left");
    	$this->db->from(CATEGORIES. ' as c');
	    $this->db->order_by('c.id', 'ASC');
	    $result = $this->db->get();
	    $res = $result->result();
	    return $res; 
    }
    
	 

}