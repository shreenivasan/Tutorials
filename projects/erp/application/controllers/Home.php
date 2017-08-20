<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller 
{
    private $current_module = '';
    private $model_name = '';
    private $view_dir_name = '';
    private $data =array();
    private $ski_action=array("check_duplicate");
    
    public function __construct() 
    {
        parent::__construct();
        $this->current_module=$this->uri->segment(1)!=""?$this->uri->segment(1):"login";
        $this->model_name=  ucfirst($this->current_module);
        $this->view_dir_name= ucfirst($this->current_module);
        $this->load->helper('form');
       // $this->load->model(ucfirst($this->model_name).'_model');    
      
        
        //echo APPPATH; die;
    }
    
    public function index(){
        
        if($this->uri->segment(2)!="submit" && !in_array($this->uri->segment(2), $this->ski_action)){
            require_once APPPATH.'includes/header.phtml';
        }
        
        $data['css_file']=array();
        $data['js_file']=array();
        $data['page_title']="Home page";
        if($this->uri->segment(2)!="submit" && !in_array($this->uri->segment(2), $this->ski_action)){
            require_once APPPATH.'includes/footer.phtml';
        }
    }

}