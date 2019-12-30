<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Imaginations extends Common_Controller {

    public $data = array();
    
     public function __construct() {
        parent::__construct();
        $this->load->model('Image_model');
         $this->form_validation->CI =& $this;
          $this->name_exists_msg = 'Blog name already exist';
        $this->validation_rules = array(
            array(
            'field' => 'blog_name',
            'label' => 'Blog Name',
            'rules' => 'required|trim|min_length[2]|max_length[200]|strip_tags'
            ),);
           
    
    }
    
      /**
     * @method index
     * @description listing display
     * @return array
     */
    public function index() {
        
        $data['title'] = "Blogs";
        $data['parent'] = "blog";
        $data['count'] = $this->common_model->get_total_count(BLOG);
        $this->load->admin_render('blog_list', $data, '');
    }

    function addImaginations(){
        $data['title'] = "Add Blog";
        $data['parent'] = "blog";
        $this->load->model('blog_model');
        $blogId = $this->input->get('id');
        $data['blogDetail'] = $this->blog_model->getBlogDetail(array('b.blogId'=>$blogId)); 
        //pr($data['blogDetail']);
        if(!empty($data['blogDetail'])){
          $this->load->admin_render('edit_imaginations', $data, '');
        }else{
        $this->load->admin_render('add_blog', $data, '');
       }
    } 

    function insertBlog(){
         
        $this->form_validation->set_rules('title', 'Title', 'trim|required|min_length[3]|max_length[50]', array('required' => 'Please enter title')); 
        
        if($this->form_validation->run() == FALSE){
            $response = array('status' => FAIL, 'message' => strip_tags(validation_errors()));
            echo json_encode($response); exit;  
        }

        if(!empty($this->input->post('description'))){
            $description = strlen($this->input->post('description'));
            /*if($description > 800){
                $response = array('status' => FAIL, 'message' => 'Please enter description less than 200 characters');
                echo json_encode($response); exit;
            }*/
        }

        if(empty($_FILES['image']['name'])){
            $response = array('status' => FAIL, 'message' => 'Please select image/video');
            echo json_encode($response); exit;
        }

            $image = array(); $image = '';
            if (!empty($_FILES['image']['name'])) {
                
                $folder = 'blog';
                $hieght = 1024;
                $width  = 768;
                $image  = $this->Image_model->updateMedia('image',$folder,$hieght,$width,FALSE); //upload media of blog
               
                //check for error
                if(array_key_exists("error",$image) && !empty($image['error'])){
                    $response = array('status' => 0, 'message' => $image['error']);
                    echo json_encode($response); die;
                }
                
                //check for image name if present
                if(array_key_exists("image_name",$image)):
                    $images = $image['image_name'];
                endif;
            
            }

            $dataInsert['title'] = trim($this->input->post('title'));
            $dataInsert['description'] = trim(strip_tags($this->input->post('description')));
            $dataInsert['image'] = $images;
        
            $blog_id = $this->common_model->insertData(BLOG, $dataInsert);  //insert category data

            if(!empty($image) && $blog_id){
               
                if(array_key_exists("attachments",$image) && !empty($image['attachments']) ){
                    //update attachement with blog ID
                    foreach($image['attachments'] as $att_id){
                        $where = array('id'=>$att_id);
                        $update = array('reference_id'=>$blog_id, 'reference_table'=>BLOG);
                        $this->common_model->updateFields(ATTACHMENTS, $update, $where);  //update attachemnt with blog id
                    }
                }  
            }
            if($blog_id){
                $response = array('status' => 1, 'message' => 'Successfully Added', 'url' => base_url('admin/imaginations')); //success msg
            }
            else{
                $response = array('status' => 0, 'message' => 'Something went wrong'); //Cat ID not found- error msg
            }  
          
        echo json_encode($response);
    }

     
    //Event list ajax
    public function get_blog_list_ajax(){
        $this->load->model('blog_model');
        $list = $this->blog_model->get_list();       
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $blog) { 
            
            $action ='';
            $no++;
            $row   = array();
            $row[] = $no;
            $row[] = display_placeholder_text($blog->title); 
            if($blog->attachment_type == 'video'){
                $video = base_url().BLOG_CONTENT.$blog->image;
                $row[] = ' <video src="'.$video.'" width="150"= height="100">=</video>';
            }else{

                $img = base_url().BLOG_CONTENT.$blog->image;
                $row[] = '<img width="80" src="'.$img.'" />';
            }
            $row[] = display_placeholder_text(date('d-M-Y', strtotime($blog->createdOn)));
            

            $blogDetail = "viewFn('admin/imaginations','blogDetail','".$blog->blogId."')";
            $action .= '<a href="javascript:void(0)" class="on-default edit-row table_action usr-dt" onclick="'.$blogDetail.'"  title="View detail">'.VIEW_ICON.'</a>';

            //$blogDetail = "viewFn('admin/blogs','blogDetail','".$blog->blogId."')";
            $clk_event = "deleteFuncBlog('".BLOG."' ,'1','".$blog->blogId."','admin/imaginations/','deleteBlogs')";
            $action .= '<a href="javascript:void(0)" class="on-default edit-row table_action usr-dt" onclick="'.$clk_event.'"  title="Delete blog">'.DELETE_ICON.'</a>';

            $clk_edit =  "''$blog->blogId'" ;
             $action .= '<a href="imaginations/addImaginations/?id='.$blog->blogId.'" onclick="'.$clk_edit.'" class="on-default edit-row table_action" title="Edit Blog">'.EDIT_ICON.'</a>';
           

            $row[] = $action;
            
            $data[] = $row;
        }

        $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->blog_model->count_all(),
                "recordsFiltered" => $this->blog_model->count_filtered(),
                "data" => $data,
        );
        //output to json format
       echo json_encode($output);
    }


    function blogDetail(){
        
        $this->load->model('blog_model');
        $blogId = $this->input->post('id');
        $data['blogDetail'] = $this->blog_model->getBlogDetail(array('b.blogId'=>$blogId)); 
        $this->load->view('blogDetail',$data);
    }

     function deleteBlogs(){
        $bId = $_POST['id'];
        $bTable = $_POST['table'];
        $where = array('blogId'=>$bId);
        $isDelete = $this->common_model->deleteData($bTable,$where);
        $tab='blogs';
        $whereu =array('reference_id'=>$bId,'reference_table'=>$tab);
        $select='*';
        $unlinkImg = $this->common_model->getMultipleData1($select,$whereu,ATTACHMENTS);
        foreach ($unlinkImg as $key => $value) {
            $file =  $value->attachment_name;
            $path = BLOG_CONTENT;
            $imageunlin = $this->Image_model->unlinkFile($path,$file);
        }
        if($isDelete ==true){
            $whr = array('reference_id'=>$bId,'reference_table'=>'blogs');
            $Delete = $this->common_model->deleteData(ATTACHMENTS,$whr);
            if($Delete==true){
            $output = array(
              "status" => 1,
             "message" => 'Imaginations Successfully deleted',              
            );
            }else{
              $output = array(
              "status" => 2,
             "message" => 'Somthing going wrong',              
            );  
            }

        }
        echo json_encode($output);
     }
       //Edit event modal load
    public function edit() { 
        $data['title'] = 'Edit Blog';
        $id = $this->input->post('id');
        $where = array('blogId'=>$id);
        $event_data = $this->common_model->getsingle(BLOG, $where); 
        if(!empty($event_data)){
            $data['results'] = $event_data;
            $this->load->view('edit_blog', $data);
        }
    }
     
      public function update(){
        $v_rules = $this->validation_rules;  //category validation  rules
        $this->form_validation->set_rules($v_rules); //set rules
        $where_id = $this->input->post('id');
        if ($this->form_validation->run($v_rules) == FALSE){
            $messages = (validation_errors()) ? validation_errors() : '';
            $response = array('status' => 0, 'message' => $messages);
        }
        else{
    
            $blog_name = $this->db->escape($this->input->post('blog_name'));
            $where = 'BlogId != '.$where_id.' AND title ='.$blog_name; 
            $result = $this->common_model->getsingle(BLOG, $where);
           
            if(!empty($result)){
                $response = array('status' => 0, 'message' => $this->name_exists_msg);  //category name already exists
                echo json_encode($response); die;
            }
            
            $image = array(); 
            $existing_img = $this->input->post('exists_image');
            if (!empty($_FILES['blog_image']['name'])){
                //image unink code
                $tab='blogs';
                $whereu =array('reference_id'=>$where_id,'reference_table'=>$tab);
                $select='*';
                $unlinkImg = $this->common_model->getMultipleData1($select,$whereu,ATTACHMENTS);

                foreach ($unlinkImg as $key => $value) {
                 $file =  $value->attachment_name;
                 $path = BLOG_CONTENT;
                 $imageunlin = $this->Image_model->unlinkFile($path,$file);
                
                }

                //end of image unlink
                $folder     = 'blog';
                $height = $width = 600;
                $image = $this->Image_model->updateMedia('blog_image',$folder,$height,$width,FALSE); //upload media of category

                //check for error
                if(array_key_exists("error",$image) && !empty($image['error'])){
                    $response = array('status' => 0, 'message' => $image['error']);
                    echo json_encode($response); die;
                }
            }
            
            $blog_name = $this->input->post('blog_name');
            $blog_disp = $this->input->post('blog_disp');
           

            $update_data = array(
                'title' => $blog_name,
                'description' => $blog_disp,
               
            );
                
            //check for image name if present
            $new_file = 0;
            if(array_key_exists("image_name",$image)){
                $blog_img = $image['image_name'];
                if(!empty($blog_img)){
                    $update_data['image'] = $blog_img;
                    //delete old attachment from server
                    $new_file = 1;
                    if(!empty($existing_img)){
                        $this->common_model->delete_attachment($where_id, BLOG, $existing_img);


                    }
                }
            }
                
            $update_where = array('BlogId'=>$where_id);
            $cat_id = $this->common_model->updateFields(BLOG, $update_data, $update_where);  //update category data

            if(!empty($new_file)){
                if(array_key_exists("attachments",$image) && !empty($image['attachments']) ){
                    //update attachement with category ID
                    foreach($image['attachments'] as $att_id){
                        $where = array('id'=>$att_id);
                        $update = array('reference_id'=>$where_id, 'reference_table'=>BLOG);
                        $this->common_model->updateFields(ATTACHMENTS, $update, $where);  //update attachment with category id
                    }
                }  
            }
            $response = array('status' => 1, 'message' => ResponseMessages::getStatusCodeMessage(135), 'url'=>base_url('admin/imaginations')); //success msg
            
        }
        
        echo json_encode($response);
    }
 
}
