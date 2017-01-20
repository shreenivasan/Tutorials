<?php

class Login_model extends CI_Model 
{
    function __construct()
    {
        parent::__construct();
        $this->currentModule=$this->uri->segment(1);        
        $this->load->database();
    }
    
    public function validate_user_login($user_id,$password) 
    {
        $query=$this->db->select("*")->from('user_master')->where("username",$user_id)->where("password",$password)->get();
        return $query->result();        
    }
}
