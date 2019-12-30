<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {
	  public function __construct(){
        parent::__construct();
    }
    
  //send push notifications
    public function send_push_notification($token_arr, $title, $body, $reference_id, $type){
        if(empty($token_arr)){
            return false;
        }
        //prepare notification message array
        $notif_msg = array('title'=>$title, 'body'=> $body, 'reference_id'=>$reference_id, 'type'=> $type, 'click_action'=>'ChatActivity', 'sound'=>'default');
        $this->notification_model->send_notification($token_arr, $notif_msg);  //send andriod and ios push notification
        return $notif_msg;  //return message array
    }


}

?>