<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Chat extends Common_Controller {
    
    public function __construct() {
        parent::__construct();
    }

    function index(){
        
        $data['parent'] = "chat";
        $this->load->admin_render('chat',$data,'');        
    } 
}
