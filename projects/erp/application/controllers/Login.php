<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller 
{
    private $current_module = '';
    private $model_name = '';
    private $view_dir_name = '';
    private $data =array();
    public function __construct() 
    {
        parent::__construct();
        $this->current_module=$this->uri->segment(1)!=""?$this->uri->segment(1):"login";
        $this->model_name=  ucfirst($this->current_module);
        $this->view_dir_name= ucfirst($this->current_module);
        $this->load->helper('form');
        $this->load->model(ucfirst($this->model_name).'_model');
    }   
    
    public function index()
    {
        $post_data=$this->input->post();
        
        $data['css_files']=array('lib'=>array('bootstrap.min','pixel-admin.min','pages.min','themes.min'),'custom'=>array('style'));
        $data['js_files']=array('lib'=>array('jquery.min','bootstrap.min','pixel-admin.min'),'custom'=>array('login'));

        $data['work_details']=array('Flexible modular structure','LESS &amp; SCSS source files','RTL direction support','Crafted with love');
        $data['current_module']=  $this->current_module;
        
        $data['errorMsg']="";
        
        if(isset($post_data) && is_array($post_data) && !empty($post_data))
        {
            $this->load->library('form_validation');
            
            $this->form_validation->set_rules('username', 'Username', 'required');
            $this->form_validation->set_rules('password', 'Password', 'required',array('required' => 'You must provide a %s.'));
            
            $username= $post_data['username'];
            $password= md5($post_data['password']);
                
            $results=  $this->Login_model->validate_user_login($username,$password);
            
            if ($this->form_validation->run() == FALSE || count($results)!=1)
            {
                $data['errorMsg']="Invalid username or password";
                
                $this->load->view($this->view_dir_name.DS.'login.phtml',$data);
            }
            else
            {
                $results = array_shift($results); 
                
                $users_data = array('user_id'  =>$results->id,'name'=>$results->first_name.' '.$results->last_name,'logged_in' => TRUE);
                $this->session->set_userdata($users_data);
                
                redirect(base_url('home'));
            }
        }
        else
        {            
            $this->load->view($this->view_dir_name.DS.'login.phtml',$data);
        }
    }
    
    
}
