<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Blog_model extends CI_Model {

    //var $table , $column_order, $column_search , $order =  '';
    var $table = BLOG;
    var $column_order = array(null, 'blogId', 'title', 'description','createdon'); //set column field database for datatable orderable
    var $column_search = array('title'); //set column field database for datatable searchable
    var $order = array('blogId' => 'DESC');  // default order
    var $group_by = 'b.blogId'; 
    var $where = '';
    
    public function __construct(){
        parent::__construct();
    }
    
   
    //prepare post list query
    private function posts_get_query()
    {
        $this->db->select('b.*,att.*');
        $this->db->from($this->table. ' as b');
        $this->db->join(ATTACHMENTS . ' as att','b.blogId = att.reference_id AND att.reference_table = "blogs"');
        
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

            if(!empty($this->group_by)){
                $this->db->group_by($this->group_by);
            }

            if(!empty($this->where))
                $this->db->where($this->where); 

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
		
        $query = $this->db->get(); 
        return $query->result();
    }

    function count_filtered()
    {
        $this->posts_get_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    function getBlogDetail($where){

        $this->db->select('b.*,att.*');
        $this->db->from(BLOG. ' as b');
        $this->db->join(ATTACHMENTS . ' as att','b.blogId = att.reference_id AND att.reference_table = "blogs"');
        $this->db->where($where);
        $this->db->group_by('b.blogId');
        $res = $this->db->get();
        return $res->row();
        
    }

}