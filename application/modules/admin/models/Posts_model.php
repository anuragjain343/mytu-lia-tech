<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Posts_model extends CI_Model {

    //var $table , $column_order, $column_search , $order =  '';
    var $table = POSTS;
    var $table_col = array('p.id','p.status','eve.event_name', 'cat.id','p.event_date','p.guest_number', 'p.budget_to');
    var $column_order = array(null, 'p.id', 'eve.event_name', 'cat.name','cat.id as cat_id','p.event_date','p.guest_number', 'p.budget_to','p.budget_from'); //set column field database for datatable orderable
    var $column_search = array('eve.event_name','cat.name','p.event_date'); //set column field database for datatable searchable
    var $order = array('p.id' => 'DESC');  // default order
    var $where = '';
    
    public function __construct(){
        parent::__construct();
    }
    
    public function set_data($where=''){
        $this->where = $where;
    }
   
    //prepare post list query
    private function posts_get_query()
    {
        $sel_fields = array_filter($this->column_order);
        $this->db->select($sel_fields);
        $this->db->from($this->table. ' as p');
        $this->db->join(EVENT_TYPE. ' as eve', "p.event_type = eve.id","left"); //to event details 
        $this->db->join(POST_CAT_MAPPING. ' as map', "p.id = map.post_id","left"); //to get post category
        $this->db->join(CATEGORIES. ' as cat', "cat.id = map.category_id","left"); //to get category details
        
        $i = 0;

        foreach ($this->column_search as $emp) // loop column 
        {
            if(isset($_POST['search']['value']) && !empty($_POST['search']['value'])){
                $_POST['search']['value'] = $_POST['search']['value'];
            } else
                $_POST['search']['value'] = '';

            if($_POST['search']['value']) // if datatable send POST for search
            {
                if($i===0) // first loop
                {
                    $this->db->group_start();
                    $this->db->like(($emp), $_POST['search']['value']);
                }
                else
                {
                    $this->db->or_like(($emp), $_POST['search']['value']);
                }

                if(count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
            }
            if(!empty($this->where))
                $this->db->where($this->where); 

            $count_val = count($_POST['columns']);
            for($i=1;$i<=$count_val;$i++){ 

                if(!empty($_POST['columns'][$i]['search']['value'])){ 
                    $this->db->where(array($this->table_col[$i]=>$_POST['columns'][$i]['search']['value'])); 
                }else if(!empty($_POST['columns'][$i]['search']['value'])){ 
                    $this->db->where(array($this->table_col[$i]=>$_POST['columns'][$i]['search']['value'])); 
                } 
            }



            if(isset($_POST['order'])) // here order processing
            {
                $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
            } 
            else if(isset($this->order))
            {
                $order = $this->order;
                $this->db->order_by(key($order), $order[key($order)]);
            }
    }

    function get_list()
    {
        $this->posts_get_query();
		if(isset($_POST['length']) && $_POST['length'] < 1) {
			$_POST['length']= '10';
		} else
		$_POST['length']= $_POST['length'];
		
		if(isset($_POST['start']) && $_POST['start'] > 1) {
			$_POST['start']= $_POST['start'];
		}
        $this->db->limit($_POST['length'], $_POST['start']);
		//print_r($_POST);die;
        $this->db->where('p.is_delete','0'); 
        $this->db->where('p.status','1');
        $query = $this->db->get(); 
        return $query->result();
    }

    function count_filtered()
    {
        $this->posts_get_query();
          $this->db->where('is_delete','0'); 
        $this->db->where('status','1');
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {   
        $this->db->from($this->table);
        $this->db->where('is_delete','0'); 
        $this->db->where('status','1');
        return $this->db->count_all_results();
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