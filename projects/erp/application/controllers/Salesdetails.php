<?php
ob_start();
defined('BASEPATH') OR exit('No direct script access allowed');
class Salesdetails extends CI_Controller 
{
    public $searchArr=array('1'=>'inward_date','2'=>'invoice_no','3'=>'cm.name');
    private $current_module = '';
    private $model_name = '';
    private $view_dir_name = '';
    private $data =array();
    private $skip_actions=array("check_duplicate");
    private $table_name='sales_orders';
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
        if($this->uri->segment(2)!="submit" && !in_array($this->uri->segment(2), $this->skip_actions)){
            require_once APPPATH.'includes/header.phtml';
        }
        $this->currentModule=$this->uri->segment(1);                            //First segment of uri is modulename
        $this->data['currentModule']=$this->currentModule;

        $sectionName    = 'Masters';
        
        $this->load->helper('form');
        $this->load->library('form_validation');

    }
    
    public function index($orderBy=1, $ascDesc='a',  $search='')
    {   
        $data['css_file']=array();
        $data['js_file']=array();
        
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
            
            $searchData=$this->Salesdetails_model->fetch_rows($this->current_module,$config["per_page"], $page,$selectCriteria, $sortBy, $sortOrder,$searchval);             

            $this->data["count"] = $searchData['count'];

            $this->data["results"] = $searchData['data'];
        } elseif(!isset($_POST['txtSearch']) && ($this->input->post('hdnSearch') != '1')) {            
            $respData = array();
            $respData=$this->Salesdetails_model->fetch_rows($this->currentModule,$config["per_page"], $page,$selectCriteria);
            $this->data["results"] = $respData['data'];            
            $this->data["count"] = $respData['count'];
        }
;
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
        
        //pr($this->data); die;
        
        $this->load->view($this->view_dir_name.'/ListView.phtml', $this->data);
        if($this->uri->segment(2)!="submit" && !in_array($this->uri->segment(2), $this->skip_actions)){
           // require_once APPPATH.'includes/footer.phtml';
        }
    }
    
    //Function for creating new module data
    public function add()
    {
        $this->data['mode']='Add';
        $this->data['product_details']=$this->Salesdetails_model->get_product_details();
        $this->data['client_details']=  $this->Salesdetails_model->get_client_details();
        $this->load->view($this->view_dir_name.'/EditView.phtml', $this->data);
    }
    
    //Function for creating new module data
    public function edit()
    {      
        $this->data['mode'] = 'Edit';
        $id=$this->uri->segment(3);
        $this->data['id']=$id;
        $this->data['product_details']=$this->Salesdetails_model->get_product_details();
        $this->data['seller_details']=  $this->Salesdetails_model->get_seller_details();
        $this->data["po_details"] = $this->Salesdetails_model->get_purchase($id,$this->tableid);        
        $this->data["po_details"]=  array_shift($this->data["po_details"]);        
        $this->data["pod_details"] = $this->Salesdetails_model->get_purchase_details($id);
        $this->load->view($this->view_dir_name.'/EditView.phtml', $this->data);
    }
    
    public function submit()
    {   
        $postData = $this->input->post();
        $errorFlag=FALSE;
        
        if($postData['id']==""){
            $this->form_validation->set_rules('seller_name','Seller name','required');
            $this->form_validation->set_rules('inward_date', 'Inward date', 'required');
            $this->form_validation->set_rules('invoice_no','Inward No', 'required');
            $this->form_validation->set_rules('cur_date','Date', 'required');
            
            if ($this->form_validation->run() == FALSE)
            {
                $this->add();
            }
            else
            {
                $data = array();                              
                $data['client_id']=$postData['seller_name'];
                $idt_array=explode("-", $postData['inward_date']);
                $data['inward_date'] = $idt_array[2]."-".$idt_array[1]."-".$idt_array[0];
                $data['invoice_no'] = $postData['invoice_no'];
                $cdt_array=explode("-", $postData['cur_date']);
                $data['cur_date'] = $cdt_array[2]."-".$cdt_array[1]."-".$cdt_array[0];
                
                $data['inserted_by'] = '1';
                $data['inserted_datetime'] = date('Y-m-d H:i:s');
                $this->db->trans_begin();
                
                $this->db->insert($this->table_name,$data);
                $inserted_id= $this->db->insert_id();
                
                $purchase_details_array=array();
                
                for($i=0;$i<count($postData['product']);$i++){
                    $purchase_details_array[$i]['po_id']=$inserted_id;
                    $purchase_details_array[$i]['product_id']=$postData['product'][$i];
                    $purchase_details_array[$i]['qty']=$postData['qty'][$i];
                    $purchase_details_array[$i]['price']=$postData['price'][$i];
                    $purchase_details_array[$i]['materials_vat_price']=$postData['vat_price'][$i];
                    $purchase_details_array[$i]['inserted_by']='1';
                    $purchase_details_array[$i]['inserted_datetime']=date('Y-m-d H:i:s');                    
                }
                
                
                $this->db->insert_batch("purchase_order_details",$purchase_details_array);
                $inserted_id2= $this->db->insert_id();
                if($inserted_id>0 && $inserted_id2>0){
                    $errorFlag=TRUE;
                    $this->db->trans_commit();
                }
                else
                {
                    $this->db->trans_rollback();
                }
                if ($errorFlag)
                {
                    redirect(site_url($this->currentModule) . "/view/" . $inserted_id);
                } 
                else
                {
                    $query = $this->Salesdetails_model->retrieve($this->db->insert_id(),$this->tableid);
                    $this->data["query"] = array_shift($query->result());
                    $this->load->view($this->modulename . '/DetailView', $this->data);
                }
            }
            
        }
        else
        {
            
            $data = array();
            $pid = $this->input->post('id');
            $data['client_id']=$postData['seller_name'];
            $idt_array=explode("-", $postData['inward_date']);
            $data['inward_date'] = $idt_array[2]."-".$idt_array[1]."-".$idt_array[0];
            $data['invoice_no'] = $postData['invoice_no'];
            $cdt_array=explode("-", $postData['cur_date']);
            $data['cur_date'] = $cdt_array[2]."-".$cdt_array[1]."-".$cdt_array[0];

            $data['updated_by'] = '1';
            $data['updated_datetime'] = date('Y-m-d H:i:s');
            $this->db->trans_begin();
            
            $this->db->where('id', $pid);
          
            if($this->db->update($this->table_name, $data)){
                $this->db->query('update purchase_order_details  set status = "N" where po_id ='.$pid);
                $purchase_details_array=array();
                
                for($i=0;$i<count($postData['product']);$i++){
                    $purchase_details_array[$i]['po_id']=$pid;
                    $purchase_details_array[$i]['product_id']=$postData['product'][$i];
                    $purchase_details_array[$i]['qty']=$postData['qty'][$i];
                    $purchase_details_array[$i]['price']=$postData['price'][$i];
                    $purchase_details_array[$i]['materials_vat_price']=$postData['vat_price'][$i];
                    $purchase_details_array[$i]['inserted_by']='1';
                    $purchase_details_array[$i]['inserted_datetime']=date('Y-m-d H:i:s');                    
                }                
                
                $this->db->insert_batch("purchase_order_details",$purchase_details_array);
                $inserted_id2= $this->db->insert_id();                
            }
            
            if($inserted_id2>0){
                    $errorFlag=TRUE;
                    $this->db->trans_commit();
                }
                else
                {
                    $this->db->trans_rollback();
                }
                if ($errorFlag)
                {
                    redirect(site_url($this->currentModule) . "/view/" . $pid);
                } 
                else
                {
                    $query = $this->Salesdetails_model->retrieve($this->db->insert_id(),$this->tableid);
                    $this->data["query"] = array_shift($query->result());
                    $this->load->view($this->modulename . '/DetailView', $this->data);
                }
        }
    }
    
    //Function for viewing module data related to certain id
    public function view($id)
    {            
        $this->data["mode"]= 'View details of Purchase Order';
        $this->data["po_details"] = $this->Salesdetails_model->get_purchase($id,$this->tableid);                
        $this->data["po_details"]=  array_shift($this->data["po_details"]);
        
        $this->data["pod_details"] = $this->Salesdetails_model->get_purchase_details($id);                
        
        
        
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