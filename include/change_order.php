<?php
require_once('../dbconnection.php');
 
$post_order = isset($_POST["order_ids"]) ? $_POST["order_ids"] : [];
 

if(count($post_order)>0){
 for($order_no= 0; $order_no < count($post_order); $order_no++)
 {
     
    $query=mysqli_query($con, 'UPDATE '.$_POST['table'].' SET sorting = '.($order_no+1).' WHERE id='.$post_order[$order_no].'');

    if ($query) {

echo 'aaa';
        
}else{
        echo 'bbbb';
    }
     
 }
 echo true; 
}else{
 echo false; 
}
 
?>