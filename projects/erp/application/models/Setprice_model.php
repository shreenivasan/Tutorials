<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Setprice_model extends CI_Model {

    function __construct()
    {
//        include(APPPATH."includes/global.php");
        // Call the Model constructor
        parent::__construct();
        $this->currentModule=$this->uri->segment(1);
        
    }
    function fetch_rows($module,$limit, $start,$postData1,$sortBy='',$sortOrder='asc',$searchVal='') {
       
        $queryStr="SELECT distinct pcdp.id id,pm.id product_id,cm.id client_id,cm.name client_name,pm.name product_name,pcdp.price,um.code unit,date year ";
        $queryStr.=" FROM product_client_datewise_price pcdp ";
        $queryStr.=" INNER JOIN product_master pm on pm.id=pcdp.product_id";
        $queryStr.=" INNER JOIN unit_master um on um.id=pm.unit_id";
        $queryStr.=" INNER JOIN client_master cm on cm.id=pcdp.client_id";
        $queryStr.=" WHERE pcdp.status='Y' AND pm.status='Y' AND   cm.status='Y' AND um.status='Y'";
        $queryStr.=" AND year(now())=pcdp.date";
        
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

    public function get_price_details($id=''){
        
        $where='';
        
        if($id!="")
        {
            $where.=" AND pcdp.id='".$id."'";
        }
         $queryStr="SELECT distinct pcdp.id id,pm.id product_id,cm.id client_id,cm.name client_name,pm.name product_name,pcdp.price,um.code unit,date year ";
        $queryStr.=" FROM product_client_datewise_price pcdp ";
        $queryStr.=" INNER JOIN product_master pm on pm.id=pcdp.product_id";
        $queryStr.=" INNER JOIN unit_master um on um.id=pm.unit_id";
        $queryStr.=" INNER JOIN client_master cm on cm.id=pcdp.client_id";
        $queryStr.=" WHERE pcdp.status='Y' AND pm.status='Y' AND   cm.status='Y' AND um.status='Y'";
        $queryStr.=" AND year(now())=pcdp.date $where ";
        $query=$this->db->query($queryStr);
        return $query->result(); 
    }
    
    public function get_client_details($id=''){
        
        $where=" WHERE cm.status='Y' AND cm.type='P' ";
        
        if($id!="")
        {
            $where.=" AND cm.id='".$id."'";
        }
         $queryStr="SELECT cm.id,cm.name";
        $queryStr.=" FROM client_master as cm $where ";
        $query=$this->db->query($queryStr);
        return $query->result(); 
    }
    
    public function get_product_details($id=''){
        
        $where=" WHERE pm.status='Y'  ";
        
        if($id!="")
        {
            $where.=" AND pm.id='".$id."'";
        }
         $queryStr="SELECT pm.id,concat(pm.name,'  [',um.code,']') as name";
        $queryStr.=" FROM product_master as pm INNER JOIN unit_master um on um.id = pm.unit_id $where ";
        $query=$this->db->query($queryStr);
        return $query->result(); 
    }
    
    public function check_duplicate($client_id='',$product_id='',$year=''){
        
        $where="WHERE 1=1 ";
        if($client_id!=""){
            $where.=" AND client_id='".$client_id."'";
        }
        if($product_id!=""){
            $where.=" AND product_id='".$product_id."'";
        }
        if($year!=""){
            $where.=" AND date='".$year."'";
        }
        $queryStr="SELECT count(*) as cnt from product_client_datewise_price  $where ";
        
        $query=$this->db->query($queryStr);        
        return $query->result(); 
    } 
    
}
