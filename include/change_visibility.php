<?php include('../dbconnection.php');?>



<?php
$ret=mysqli_query($con, 'select * from tables where id = '.$_POST['table_id'].'');

$row_table=mysqli_fetch_array($ret);



if($_POST['element_visibility']==1){
    $new_visibility = 0;
}else{
    $new_visibility = 1;
}


$query=mysqli_query($con, 'UPDATE '.$row_table['table_title'].' SET visible = '.$new_visibility.' WHERE id='.$_POST['element_id'].'');

if($query){
    echo 'success';
}else{
    echo 'error';
}


?>