<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Client_model extends CI_Model {

    function __construct()
    {
//        include(APPPATH."includes/global.php");
        // Call the Model constructor
        parent::__construct();
        $this->currentModule=$this->uri->segment(1);
        
    }
    function fetch_rows($module,$limit, $start,$postData1,$sortBy='',$sortOrder='asc',$searchVal='') {
       
        $queryStr="SELECT id,name,address,mobile,alternate_mobile,email_id,vat_no,contact_person_name,contact_person_mobile,type,status ";
        $queryStr.=" FROM client_master cm where type='P' AND status='Y' ";
        if($searchVal!="" && $searchVal!="s")
        {               
            $queryStr.=$this->getSearchStr($this->searchArr,$searchVal);            
        }    
        
        if($sortBy!='' && $sortOrder!='') $queryStr.=" order by UPPER(".$sortBy.") ".$sortOrder;
        
        $data['count']=0;
        $data['count']=$this->getQueryNumRows($queryStr);
        
        $queryStr.=" LIMIT ".$start.",".$limit;
        
        $query=$this->db->query($queryStr);
        
        if ($query->num_rows() > 0) {
            $counter=0;
            $innerLoop=0;
            foreach ($query->result() as $row) {
                $data['data'][] = $row;
            }
            return $data;
        }
        return false;
       
   }
    function getSearchStr($searchArr,$searchVal){
        $searchStr="";
        $keycount=count($searchArr);
        for($i=1;$i<=$keycount;$i++)
        {
            $searchStr.=" LOWER(".$searchArr[$i].") like LOWER('%".$searchVal."%')";
            
            if($i!=$keycount)
                $searchStr.=" OR ";           
}
         $searchStr=" having (".$searchStr.") ";
        return $searchStr;
    }

    public function get_client_details($id=''){
        $where="WHERE status='Y' AND type='P' ";
        if($id!="")
        {
            $where.=" AND id='".$id."'";
        }
        $queryStr="SELECT id,name,address,mobile,alternate_mobile,email_id,vat_no,contact_person_name,contact_person_mobile,type,status";
        $queryStr.=" FROM client_master";
        $queryStr.=" ".$where;
        $query=$this->db->query($queryStr);
        return $query->result(); 
    }
}
