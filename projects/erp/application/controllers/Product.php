<?php
ob_start();
defined('BASEPATH') OR exit('No direct script access allowed');
class Product extends CI_Controller 
{
    private $master_arr=array("index"=>"List Material","edit"=>"Edit Material","add"=>"Add Material","view"=>"View Material","delete"=>"Delete Material","deleteMultiple"=>"Delete Multiple");
    public $searchArr=array('1'=>'pm.name');
    private $current_module = '';
    private $model_name = '';
    private $view_dir_name = '';
    private $data =array();
    private $skip_actions=array("check_duplicate");
    private $table_name='product_master';
    private $title="";
    private $sessMsg='';
    private $sessErrMsg='';
    private $tableid='id';
    
    
    public function __construct() 
    {
        parent::__construct();
        $this->current_module=$this->uri->segment(1)!=""? ucfirst($this->uri->segment(1)):"login";
        $this->model_name=  ucfirst($this->current_module).'_model';
        $this->view_dir_name= ucfirst($this->current_module);
        $this->load->helper('form');        
        $this->load->model(ucfirst($this->model_name));
        if($this->uri->segment(2)!="" && $this->uri->segment(2)!="submit"  && !in_array($this->uri->segment(2), $this->skip_actions))
            $title=  strtolower ($this->master_arr[$this->uri->segment(2)]);                   //Second segment of uri for action,In case of edit,view,add etc.
        elseif($this->uri->segment(2)!="" && $this->uri->segment(2)=="submit"   && !in_array($this->uri->segment(2), $this->skip_actions))
        {
            $title=$this->master_arr['add'];                                    //Default action will be index page i.e list module data
        }
        else
        {
            $title=$this->master_arr['index'];  
        }
        if($this->uri->segment(2)!="submit" && !in_array($this->uri->segment(2), $this->skip_actions)){
            require_once APPPATH.'includes/header.phtml';
        }
        $this->currentModule=$this->uri->segment(1);                            //First segment of uri is modulename
        $this->data['title']=$title;
        $this->data['currentModule']=$this->currentModule;

        $sectionName    = 'Masters';
        $pageName       = $this->currentModule;
        
        $this->load->helper('form');
        $this->load->library('form_validation');

    }
    
    public function index($orderBy=1, $ascDesc='a',  $search='')
    {   
        $data['css_file']=array();
        $data['js_file']=array();
        $data['title']="Home page";
        
        $this->data['orderBy']	= $orderBy;
	$this->data['ascDesc']	= $ascDesc;
        
          
        $sortBy     = 'pm.name';
        if($orderBy!="")
        {
            $sortBy=$this->searchArr[$orderBy];           
        }
        $sortOrder  = ($ascDesc=='d')?'desc':'asc';

        $this->load->library('pagination');
        $this->data["count"]=0;
        //Add condition as per required for fetching records
        $selectCriteria=array('isDeleted' => 'N');                     // You can add multiple conditional filters in this array 
        $config = array();

        $config["per_page"] = MAX_ENTRIES_PER_PAGE;
        $config["uri_segment"] = 6;
        $page = ($this->uri->segment($config["uri_segment"])) ? $this->uri->segment($config["uri_segment"]) : 0;
        $searchval="s";
        $this->data["searchval"]=$searchval;        
        if ((isset($_POST['txtSearch']) || ($this->input->post('hdnSearch') == '1')) || $search!="") {
            $searchval=$search;
            if($search=="")
            $searchval = $this->input->post('txtSearch');
            
            $this->data["searchval"]=$searchval;
            
            $searchData=$this->Product_model->fetch_rows($this->current_module,$config["per_page"], $page,$selectCriteria, $sortBy, $sortOrder,$searchval);             

            $this->data["count"] = $searchData['count'];

            $this->data["results"] = $searchData['data'];
        } elseif(!isset($_POST['txtSearch']) && ($this->input->post('hdnSearch') != '1')) {            
            $respData = array();
            $respData=$this->Product_model->fetch_rows($this->currentModule,$config["per_page"], $page,$selectCriteria);
            $this->data["results"] = $respData['data'];            
            $this->data["count"] = $respData['count'];
        }

        if($searchval=="") $searchval="s";
        $config['base_url'] = site_url($this->current_module)."/index/".$orderBy."/".$ascDesc."/".$searchval."/";
        $config["total_rows"] = $this->data["count"];
        
        $this->pagination->initialize($config);       
        $this->data["links"] = $this->pagination->create_links();        
        $this->data["msg"]=$this->sessMsg;
        $this->data["errMsg"]=$this->sessErrMsg;
        $this->data['mode'] = 'List';
        $this->data['msg'] = $this->session->userdata('message');
        
        $this->session->unset_userdata('message');
        $this->load->view($this->view_dir_name.'/ListView.phtml', $this->data);
        if($this->uri->segment(2)!="submit" && !in_array($this->uri->segment(2), $this->skip_actions)){
           // require_once APPPATH.'includes/footer.phtml';
        }
    }
    
    //Function for creating new module data
    public function add()
    {      
        $this->data['mode'] = 'Add'; 
        $this->data['seller_deatails']=$this->Product_model->get_seller_details();
        $this->data['unit_deatails']=$this->Product_model->get_unit_details();
        $this->load->view($this->view_dir_name.'/EditView.phtml', $this->data);
    }
    
    //Function for creating new module data
    public function edit()
    {      
        $this->data['mode'] = 'Edit';
        $id=$this->uri->segment(3);
        $this->data["product_details"] = $this->Product_model->get_product_details($id);
        $this->data['seller_deatails']=$this->Product_model->get_seller_details();
        $this->data['unit_deatails']=$this->Product_model->get_unit_details();
        $this->load->view($this->view_dir_name.'/EditView.phtml', $this->data);
    }
    
    public function submit()
    {   
        $postData = $this->input->post();
        if($postData['id']==""){
            $this->form_validation->set_rules('product_name', 'Name', 'required');
            $this->form_validation->set_rules('seller_name', 'required');
            $this->form_validation->set_rules('unit_name', 'required');
            
            if ($this->form_validation->run() == FALSE)
            {
                $this->add();
            }
            else
            {
                $data = array();                                        
                $data['name'] = $this->input->post('product_name');
                $data['seller_id'] = $this->input->post('seller_name');
                $data['unit_id'] = $this->input->post('unit_name');
                $data['inserted_by'] = '1';
                $data['inserted_datetime'] = date('Y-m-d H:i:s');
                $this->db->set($data);
                
                if ($this->db->insert($this->table_name))
                {
                    $lastInsertId = $this->db->insert_id();
                    redirect(site_url(ucfirst($this->currentModule)) . "/view/" . $lastInsertId);
                } 
                else
                {
                    $query = $this->Product_model->retrieve($this->db->insert_id(),$this->tableid);
                    $this->data["query"] = array_shift($query->result());
                    $this->load->view(ucfirst($this->modulename) . '/DetailView', $this->data);
                }
            }
            
        }else
        {
            //pr($postData); die;
            $pid = $this->input->post('id');
            $data['name'] = $this->input->post('product_name');
            $data['seller_id'] = $this->input->post('seller_name');
            $data['unit_id'] = $this->input->post('unit_name');
            $this->db->where('id', $pid);
          
            if($this->db->update($this->table_name, $data))
            {
                redirect(site_url($this->currentModule)."/view/".$pid);                
            }else{
                $query = $this->Product_model->retrieve($pid);
                $this->data["query"]=array_shift($query->result());
                $this->load->view($this->view_dir_name.'/DetailView', $this->data);          
            }
            
        }
    }
    
    //Function for viewing module data related to certain id
    public function view($id)
    {            
        $this->data["product_details"] = $this->Product_model->get_product_details($id,$this->tableid);
        $this->data["product_details"]= array_shift($this->data["product_details"]);
        $this->load->view($this->view_dir_name.'/DetailView.phtml', $this->data); 
    }
    
    //Function for deleting records
    public function delete($id='')
    {   
        $this->db->where('id', $id);
        $postData=array('status' => 'N');
        if($this->db->update($this->table_name, $postData))
        {
            $this->session->set_userdata('message', 'Record deleted successfully !');
            redirect(site_url($this->currentModule));
        }
        else
        {
            $this->session->set_userdata('errMessage', 'Error occured while deleting!');
            redirect(site_url($this->currentModule));
        }
    }
    
    public function check_duplicate(){
        
    }

}