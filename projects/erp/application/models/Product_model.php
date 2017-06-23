<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Product_model extends CI_Model {

    function __construct()
    {
//        include(APPPATH."includes/global.php");
        // Call the Model constructor
        parent::__construct();
        $this->currentModule=$this->uri->segment(1);
        
    }
    function fetch_rows($module,$limit, $start,$postData1,$sortBy='',$sortOrder='asc',$searchVal='') {
       
        $queryStr="select pm.id,pm.name,um.id unit_id,um.name unit_name,cm.id seller_id,cm.name seller_name";      
        $queryStr.=" from product_master pm";
        $queryStr.=" inner join unit_master um on um.id=pm.unit_id";
        $queryStr.=" inner join client_master cm on cm.id=pm.seller_id";
        $queryStr.=" WHERE pm.status='Y' AND um.status='Y' AND cm.status='Y'";
        
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

    public function get_seller_details($id='')
    {
        $where="WHERE status='Y' AND type='S'";
        if($id!="")
        {
            $where.=" AND id='".$id."'";
        }
        $queryStr="SELECT id,name from client_master $where ";
        $query=$this->db->query($queryStr);
        return $query->result(); 
    }
    
    public function get_unit_details($id='')
    {
        $where="WHERE status='Y' ";
        if($id!="")
        {
            $where.=" AND id='".$id."'";
        }
        $queryStr="SELECT id,code from unit_master $where ";
        $query=$this->db->query($queryStr);
        return $query->result(); 
    }
    
    public function get_product_details($id=''){
        $where="WHERE pm.status='Y' ";
        if($id!="")
        {
            $where.=" AND pm.id='".$id."'";
        }
        $queryStr="select pm.id,pm.name,um.id unit_id,um.name unit_name,cm.id seller_id,cm.name seller_name";      
        $queryStr.=" from product_master pm";
        $queryStr.=" inner join unit_master um on um.id=pm.unit_id";
        $queryStr.=" inner join client_master cm on cm.id=pm.seller_id";
        $queryStr.=" ".$where;
        $query=$this->db->query($queryStr);
        return $query->result(); 
    }
}
