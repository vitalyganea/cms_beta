<?php include('dbconnection.php');?>



    <?php


$ret=mysqli_query($con, 'select * from tables where id = '.$_GET['table'].'');
$row_table=mysqli_fetch_array($ret);

$ret=mysqli_query($con,'select * from '.$row_table["table_title"].' where id = '.$_GET["row"].'');
$row_value=mysqli_fetch_assoc($ret);

$rows = array();
$sql = 'SHOW COLUMNS FROM '.$row_table["table_title"].'';
$result = mysqli_query($con,$sql);
while($column_row = mysqli_fetch_assoc($result)){
    
    
  array_push($rows, $column_row['Field']);

}
        

          
        foreach($rows as $row){            
        $sql = "select * from column_settings where column_name = '".$row_table["table_title"].'_'.$row."'";
        $result = mysqli_query($con,$sql);
        $column_row = mysqli_fetch_assoc($result);            
        if($column_row != NULL){  
            
                if($column_row['column_type'] == 'image'){ 
                    if(!empty($row_value[$row])){
                  if (file_exists('upload/'.$row_value[$row])) {
                    unlink('upload/'.$row_value[$row]);
                  }
                  }      
                }

                if($column_row['column_type'] == 'file'){ 
                    if(!empty($row_value[$row])){
                  if (file_exists('upload/'.$row_value[$row])) {
                    unlink('upload/'.$row_value[$row]);
                  }
                  }      
                }
        }
        }


    $query=mysqli_query($con, 'DELETE FROM '.$row_table['table_title'].' WHERE id='.$_GET["row"].'');

    if ($query) {

echo '<script>
alert("Deleted");
window.location.href="table.php?id='.$_GET['table'].'";
</script>';
        
} 
?>
