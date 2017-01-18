<?php
echo json_encode(array('success'=>'File uploaded successfully, You will receive an email on your email id.')); die;

date_default_timezone_set('Asia/Calcutta');
$cur_date = date('Y-m-d H-i-s');
        
$date_part = explode(" ",$cur_date );
$day_part = explode("-", $date_part[0]);
$time_part = explode("-", $date_part[1]);

$y= $day_part[0];
$m= $day_part[1];
$d= $day_part[2];

$h = $time_part[0];
$mi = $time_part[1];
$s = $time_part[2];

$where1=" WHERE tsfoi.status='confirmed' AND ";
        
        if($h < 7)
        {
            $fromDate= $y."-".$m."-".($d-1)." 15:30:01";
            $fromDate=date('Y-m-d H:i:s',strtotime('-330 minutes', strtotime($fromDate)));
            $toDate= $y."-".$m."-".($d)." 07:00:00";
            $toDate=date('Y-m-d H:i:s',strtotime('-330 minutes', strtotime($toDate)));
            $where1.=" sfosh.created_at between '".$fromDate."' AND '".$toDate."'";
        }
        elseif($h >=7 && $h<12)
        {
            $fromDate= $y."-".$m."-".($d)." 07:00:01";
            $fromDate=date('Y-m-d H:i:s',strtotime('-330 minutes', strtotime($fromDate)));
            $toDate= $y."-".$m."-".($d)." 12:00:00";
            $toDate=date('Y-m-d H:i:s',strtotime('-330 minutes', strtotime($toDate)));
            $where1.=" sfosh.created_at between '".$fromDate."' AND '".$toDate."'";
        }
        else if($h>=12 && $h<15)
        {
            $fromDate= $y."-".$m."-".($d)." 12:00:01";
            $fromDate=date('Y-m-d H:i:s',strtotime('-330 minutes', strtotime($fromDate)));
            $toDate= $y."-".$m."-".($d)." 15:00:00";
            $toDate=date('Y-m-d H:i:s',strtotime('-330 minutes', strtotime($toDate)));
            $where1.=" sfosh.created_at between '".$fromDate."' AND '".$toDate."'";
        }
        else if($h>=15)
        {
            $fromDate= $y."-".$m."-".($d)." 15:30:01";
            $fromDate=date('Y-m-d H:i:s',strtotime('-330 minutes', strtotime($fromDate)));
            $toDate= $y."-".$m."-".($d+1)." 07:00:00";
            $toDate=date('Y-m-d H:i:s',strtotime('-330 minutes', strtotime($toDate)));
            $where1.=" sfosh.created_at between '".$fromDate."' AND '".$toDate."'";
        }

 $query2=" SELECT SUM(sfoi.qty_invoiced) qty, sfoi.sku ";
            $query2.=" FROM sales_flat_order_status_history sfosh ";
            $query2.=" INNER JOIN sales_flat_order sfo on sfosh.parent_id=sfo.entity_id and sfosh.entity_name='invoice'";
            $query2.=" INNER JOIN sales_flat_order_item sfoi ON sfo.entity_id = sfoi.order_id ";
            $query2.=" INNER JOIN ts_sales_flat_order_item tsfoi ON tsfoi.item_id = sfoi.item_id ";
            $query2.=$where1." GROUP BY sfoi.sku";
            
            echo $query2; die;