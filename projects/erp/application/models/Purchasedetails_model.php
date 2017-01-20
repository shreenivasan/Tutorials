<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Purchasedetails_model extends CI_Model {

    function __construct()
    {
//        include(APPPATH."includes/global.php");
        // Call the Model constructor
        parent::__construct();
        $this->currentModule=$this->uri->segment(1);
        
    }
    function fetch_rows($module,$limit, $start,$postData1,$sortBy='',$sortOrder='asc',$searchVal='') {
       
        $queryStr="select po.id po_id,inward_date,invoice_no,cm.id client_id,po.cur_date, cm.name cname
                    from purchase_orders po 
                    INNER JOIN client_master cm on cm.id = po.client_id
                    WHERE po.status='Y' AND cm.status='Y'";
        
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

    public function get_product_details($id='')
    {
        $where=" WHERE pm.status='Y' AND um.status='Y'";
        if($id!="")
        {
            $where.=" AND pm.id='".$id."'";
        }
        $queryStr="SELECT pm.id,pm.name,um.code FROM product_master pm 
                   INNER JOIN unit_master um on um.id=pm.unit_id $where ";
        $query=$this->db->query($queryStr);
        return $query->result(); 
    }
    
    public function get_seller_details($id=''){
         $where=" WHERE cm.status='Y' AND cm.type='S'";
        if($id!="")
        {
            $where.=" AND cm.id='".$id."'";
        }
        $queryStr="SELECT id,name from client_master as cm $where ";
        $query=$this->db->query($queryStr);
        return $query->result(); 
    }
    
    public function get_purchase($id=''){
         $where=" WHERE po.status='Y' AND cm.status='Y' ";
        if($id!="")
        {
            $where.=" AND po.id='".$id."'";
        }
        $queryStr="SELECT po.id,inward_date,invoice_no,cur_date,cm.name,cm.id client_id from purchase_orders as po ";
        $queryStr.=" INNER JOIN client_master cm on cm.id = po.client_id ". $where;
        
        $query=$this->db->query($queryStr);
        return $query->result(); 
    }
    
    public function get_purchase_details($id=''){
         $where=" WHERE pod.status='Y' AND po.status='Y' AND pm.status='Y' AND um.status='Y' ";
        if($id!="")
        {
            $where.=" AND po.id='".$id."'";
        }
        $queryStr="SELECT  po_id,product_id, pm.name pname,pod.price,um.name unit,qty,materials_vat_price
                    FROM purchase_order_details pod 
                    INNER JOIN purchase_orders po on po.id=pod.po_id
                    INNER JOIN product_master pm on pm.id = pod.product_id
                    Inner join unit_master um on um.id=pm.unit_id $where";
        
        $query=$this->db->query($queryStr);
        return $query->result(); 
    }
    
}
