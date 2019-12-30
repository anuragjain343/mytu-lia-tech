<?php

class Image_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('string');
    }
    
    //add image data in attachment table
    function add_image_data($att_data){
        $this->db->insert(ATTACHMENTS, $att_data);
        $last_id = $this->db->insert_id();
        if($last_id){
            return $last_id;
        }
        else{
            return FALSE;
        }
    }
    
    function image_sizes(){
        $img_sizes = array();
        $img_sizes['thumbnail'] = array('width'=>150,'height'=>150,'folder'=>'/thumb');
        $img_sizes['medium'] = array('width'=>300,'height'=>300,'folder'=>'/medium');
        return $img_sizes;
    }
    function makedirs($folder='', $mode=DIR_WRITE_MODE, $defaultFolder='uploads/'){

        if(!@is_dir(FCPATH . $defaultFolder)) {

            mkdir(FCPATH . $defaultFolder, $mode);
        }
        if(!empty($folder)) {

            if(!@is_dir(FCPATH . $defaultFolder . '/' . $folder)){
                mkdir(FCPATH . $defaultFolder . '/' . $folder, $mode,true);
            }
        } 
    }//End Function
    function makedirsBk($folder='', $mode=DIR_WRITE_MODE, $defaultFolder='../uploads/'){

        if(!@is_dir(FCPATH . $defaultFolder)) {

            mkdir(FCPATH . $defaultFolder, $mode);
        }
        if(!empty($folder)) {

            if(!@is_dir(FCPATH . $defaultFolder . '/' . $folder)){
                mkdir(FCPATH . $defaultFolder . '/' . $folder, $mode,true);
            }
        } 
    }//End Function
    function updateMedia($image,$folder,$height=250,$width=250,$path=FALSE){
        if($path){
        	 $this->makedirsBk($folder);
        }else{
        	 $this->makedirs($folder);
        }
       	$realpath = $path ?'../uploads/':'uploads/';

		$allowed_types = "jpg|png|jpeg|mp4|mp3"; 
		
                $img_name = random_string('alnum', 16);  //generate random string for image name
		$config = array(
                    'upload_path'   	=> $realpath.$folder,
                    'allowed_types' 	=> $allowed_types,
                    'max_size'              => "10240",   // Can be set to particular file size, for now it is 10mb
                    'max_height'            => "4000",
                    'max_width'             => "4000",
                    'min_width'             => "150",
                    'min_height'            => "150",
                    'file_name'		=> $img_name,
                    'overwrite'		=> false,
                    'remove_spaces'	=> TRUE,
                    'quality'		=> '100%',
		);


		$this->load->library('upload');
		$this->upload->initialize($config);
 
	  	if(!$this->upload->do_upload($image)){
                    $error = array('error' => strip_tags($this->upload->display_errors()));
                    return $error;

		} else {
                    $image_data = $this->upload->data();
                    $fileType = explode("/",$image_data['file_type']);
                    if($fileType[0] == 'video'){
                        $type = 'video';
                    }else{
                        $type = 'image';
                    }

                    //store default image size attachement data
                    $att_data = array('attachment_name'=>$image_data['file_name'], 'attachment_type'=>$type,'image_size'=>'default', 'created_on'=>datetime());
                    $att_id = $this->add_image_data($att_data);
                    if($att_id)
                        $attachments[] =  $att_id;

                    $this->load->library('image_lib');
                    $folder_thumb = $folder.'/';

                    $img_sizes_arr = $this->image_sizes();  //predefined sizes in model
                        $thumb_img = '';
                        foreach($img_sizes_arr as $k=>$v){
                            
                            $resize_str = random_string('alnum', 5);
                            $new_img_name = $v['width']. 'x'. $v['height'].'_'. $resize_str.$image_data['file_name'];
                            $real_path = realpath(FCPATH .$realpath .$folder_thumb); 
                            
                            $resize['image_library'] 	= 'gd2';
                            $resize['source_image'] 	= $image_data['full_path'];
                            $resize['new_image'] 		= $real_path.'/'.$new_img_name;
                            $resize['maintain_ratio'] 	        = FALSE;
                            $resize['width'] 			= $v['width'];
                            $resize['height'] 			= $v['height'];
                            $resize['quality'] 			= '90%';
                            $this->image_lib->initialize($resize);
                            if($this->image_lib->resize()){
                                $att_data = array('attachment_name'=>$new_img_name, 'attachment_type'=>'image','image_size'=>$k, 'created_on'=>datetime());
                                $att_id = $this->add_image_data($att_data);
                                if($att_id)
                                    $attachments[] =  $att_id;
                                
                                if($k=='thumbnail')
                                    $thumb_img = $new_img_name;
                            }
                        }
                        
                        //custom size(larger than other)- used to display in sliders or full screen 
                        $new_img_name = $width. 'x'. $height.'_'.random_string('alnum', 5).$image_data['file_name'];
                        $real_path = realpath(FCPATH .$realpath .$folder_thumb); 
                        $resize1['source_image'] 	= $image_data['full_path'];
                        $resize1['new_image'] 		= $real_path.'/'.$new_img_name;
                        $resize1['maintain_ratio'] 	= TRUE;  //maintain ratio- do not crop image
                        $resize1['width']               = $width;
                        $resize1['height'] 		= $height;
                        $resize1['quality'] 		= '90%';
                        $this->image_lib->initialize($resize1);
                        if($this->image_lib->resize()){
                            $att_data = array('attachment_name'=>$new_img_name, 'attachment_type'=>'image','image_size'=>'large', 'created_on'=>datetime());
                            $att_id = $this->add_image_data($att_data);
                            if($att_id)
                                $attachments[] =  $att_id;
                        }
			
                        $this->image_lib->clear();
                        if(empty($thumb_img))
                            $thumb_img = $image_data['file_name'];
                        
			return array('image_name'=>$thumb_img, 'attachments'=>$attachments);
            //return $thumb_img;
		}

	} // End Function
	function updateGallery($fileName,$folder,$hieght=250,$width=250)
	{
		  	$this->makedirs($folder);

			$storedFile 		= array();
			$allowed_types 		= "jpg|png|jpeg"; 
			$files 				= $_FILES[$fileName];
			$number_of_files 	= sizeof($_FILES[$fileName]['tmp_name']);

			// we first load the upload library
			$this->load->library('upload');
			// next we pass the upload path for the images
			$configG['upload_path'] 		= 'uploads/'.$folder;
			$configG['allowed_types'] 		= $allowed_types;
			$configG['max_size']    		= '2048000';
			$configG['encrypt_name']  		= 'TRUE';
			$configG['quality'] 			= '100%';
	   
			// now, taking into account that there can be more than one file, for each file we will have to do the upload
			for ($i = 0; $i < $number_of_files; $i++)
			{
				$_FILES[$fileName]['name'] 		= $files['name'][$i];
				$_FILES[$fileName]['type'] 		= $files['type'][$i];
				$_FILES[$fileName]['tmp_name'] 	= $files['tmp_name'][$i];
				$_FILES[$fileName]['error'] 	= $files['error'][$i];
				$_FILES[$fileName]['size'] 		= $files['size'][$i];

				//now we initialize the upload library
				$this->upload->initialize($configG);
				if ($this->upload->do_upload($fileName))
				{
					$savedFile = $this->upload->data();//upload the image
				
					$folder_thumb = $folder.'/thumb/';
					$this->makedirs($folder_thumb);
					//your desired config for the resize() function
					$config1 = array(
						'image_library' 	=> 'gd2',
						'source_image' 		=> $savedFile['full_path'], //get original image
						'maintain_ratio' 	=> false,
						'create_thumb' 		=> TRUE,
						'width' 			=> 100,
						'height' 			=> 100,
						'new_image' 		=> realpath(FCPATH .'uploads/'.$folder_thumb),
						'quality'			=> '100%'
					);	
					$this->load->library('image_lib'); //load image_library
					$this->image_lib->initialize($config1);
					$this->image_lib->resize();
					$folder_resize = $folder.'/resize/';
					$this->makedirs($folder_resize);

					$resize1['source_image'] 	= $savedFile['full_path'];
					$resize1['new_image'] 		= realpath(FCPATH .'uploads/'.$folder_resize);
					$resize1['maintain_ratio'] 	= FALSE;
					$resize1['width'] 			= $width;
					$resize1['height'] 			= $hieght;
					$resize1['quality'] 		= '100%';

					$this->image_lib->initialize($resize1);
					$this->image_lib->resize();

						$storedFile[$i]['name'] = $savedFile['file_name'];
						$storedFile[$i]['type'] = $savedFile['file_type'];
					
					$this->image_lib->clear();


				}
				else
				{
					$storedFile[$i]['error'] = strip_tags($this->upload->display_errors());
				}
			} // END OF FOR LOOP
		 
		return $storedFile;
		  
	}//FUnction


	function unlinkFile($path,$file){
		$main 	= $path.$file;


		$thumb 	= $path.'thumb/'.$file;
		$resize = $path.'resize/'.$file;
       
		if(file_exists(FCPATH.$main)):
			unlink(FCPATH.$main);
		endif;
		if(file_exists(FCPATH.$thumb)):
			unlink( BASEPATH.$thumb);
		endif;
		if(file_exists(FCPATH.$resize)):
			unlink( BASEPATH.$resize);
		endif;
		return TRUE;
	}//End function



    function canvasImageUpload($img,$folder,$date){
            if (strpos($img, 'data:image') === 0) {

            $sub_folder = $folder;
            $this->makedirs($sub_folder);

            $imgNew = explode(',', $img);
            $ini =substr($imgNew[0], 11);
            $type = explode(';', $ini);


            $img = str_replace('data:image/'.$type[0].';base64,', '', $img);
            $img = str_replace(' ', '+', $img);
            $data = base64_decode($img);
            $file_name = 'mindiii-'.$date.'.'.$type[0];

            $source_img = $file = FCPATH.'uploads/'.$folder.'/'.$file_name;

            if (file_put_contents($file, $data)) {


            $image_data = array();
            $source_image_arr_detail = getimagesize($source_img);
            $image_data["image_width"] = $source_image_arr_detail[0];
            $image_data["image_height"] = $source_image_arr_detail[1];
            $image_data['full_path'] = $source_img;
            $image_data['file_name'] = $file_name;

            $img_sizes_arr = $this->image_sizes(); 
            //pr($img_sizes_arr);
            $this->load->library('image_lib');

            foreach($img_sizes_arr as $k=>$v){

            // create resize sub-folder
            $sub_folder = $folder.$v['folder'];
            $this->makedirs($sub_folder);

            $real_path = realpath(FCPATH.'uploads/' .$folder);

            $resize['image_library'] = 'gd2';
            $resize['source_image'] = $image_data['full_path'];
            $resize['new_image'] = $real_path.$v['folder'].'/'.$image_data['file_name'];
            $resize['maintain_ratio'] = TRUE; //maintain original image ratio
            $resize['width'] = $v['width'];
            $resize['height'] = $v['height'];
            $resize['quality'] = '100%';
            // We need to know whether to use width or height edge as the hard-value. 
            // After the original image has been resized, either the original image width’s edge or 
            // the height’s edge will be the same as the container
            $dim = (intval($image_data["image_width"]) / intval($image_data["image_height"])) - ($v['width'] / $v['height']);
            $resize['master_dim'] = ($dim > 0)? "height" : "width";

            $this->image_lib->initialize($resize);
            $is_resize = $this->image_lib->resize(); //create resized copies

            //image resizing maintaining it's aspect ratio is done. Now we will start cropping the resized image
            $source_img = $real_path.$v['folder'].'/'.$image_data['file_name'];


            if($is_resize && file_exists($source_img)){

            $source_image_arr = getimagesize($source_img);
            $source_image_width = $source_image_arr[0];
            $source_image_height = $source_image_arr[1];

            $source_ratio = $source_image_width / $source_image_height;
            $new_ratio = $v['width'] / $v['height'];

            if($source_ratio != $new_ratio){

            //image cropping config
            $crop_config['image_library'] = 'gd2';
            $crop_config['source_image'] = $source_img;
            $crop_config['new_image'] = $source_img;
            $crop_config['quality'] = "100%";
            $crop_config['maintain_ratio'] = FALSE;
            $crop_config['width'] = $v['width'];
            $crop_config['height'] = $v['height'];

            if($new_ratio > $source_ratio || (($new_ratio == 1) && ($source_ratio < 1))){
            //Source image height is greater than crop image height
            //So we need to move on vertical(Y) axis while keeping horizantal(X) axis static(0)
            $crop_config['y_axis'] = round(($source_image_height - $crop_config['height'])/2);
            $crop_config['x_axis'] = 0;
            }else{
            //Source image width is greater than crop image width
            //So we need to move on horizontal(X) axis while keeping vertical(Y) axis static(0)
            $crop_config['x_axis'] = round(($source_image_width - $crop_config['width'])/2);
            $crop_config['y_axis'] = 0;
            }
            
            $this->image_lib->initialize($crop_config); 
            $this->image_lib->crop();
            $this->image_lib->clear();
            }
            }
            }


            $ret_arr['success'] = 1;
            $ret_arr['message'] = 'done';
            $ret_arr['uploadfile'] = $file_name;
            $ret_arr['oldfile'] = $file_name;
           
            } else {
            $ret_arr['success'] = 0;
            $ret_arr['message'] = 'error';
            }
            return $ret_arr;
            }
    }

}// End of class Image_model

?>
