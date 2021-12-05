<?php include('dbconnection.php');?>


<!DOCTYPE html>
<html lang="en">
    <?php
    include('include/head.php');
    ?>
<body>

    <?php
    include('include/navbar.php');
    ?>
      

<?php
$ret=mysqli_query($con, 'select * from tables where id = '.$_GET['table'].'');
$row_table=mysqli_fetch_array($ret);
?>

    
          
<?php
$ret=mysqli_query($con,'select * from '.$row_table["table_title"].' where id = '.$_GET["row"].'');
$row_value=mysqli_fetch_assoc($ret);
    
    
?> 

        



<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    
foreach($_POST as $key => $value){

    
    
    $keys[] = $key;
    $values[] = $value;
    
}
    
    
if(!empty($_FILES)) {
    $file_columns = array_keys($_FILES);

    
    foreach($file_columns as $file_column){
        
        
        if(!empty($_FILES[$file_column]['tmp_name'])){
    if(!empty($row_value[$file_column])){              
if (file_exists('upload/'.$row_value[$file_column])) {
    unlink('upload/'.$row_value[$file_column]);
}
  }  
              
              
         $keys[] = $file_column;    
             
              
    }
        
        
    }

    
    foreach($_FILES as $file){
        
if(!empty($file['tmp_name'])){
        
        $tmp_file = $file['tmp_name'];
        $ext = pathinfo($file["name"], PATHINFO_EXTENSION);
        $rand = md5(uniqid().rand());
        $post_file = $rand.".".$ext;
        move_uploaded_file($tmp_file,"upload/".$post_file);
        $values[] = $post_file;
        }
    }
    
}


    
    $edit_sql = '';
    
    foreach (array_combine($keys, $values) as $key => $value) {
        
        
    $edit_sql = $edit_sql.$key.'="'.$value.'",';

}
    $edit_sql = substr($edit_sql, 0, -1);


//    $query=mysqli_query($con, 'insert into '.$row_table['table_title'].' ('.$keys.') value('.$values.')');
    $query=mysqli_query($con, 'UPDATE '.$row_table['table_title'].' SET '.$edit_sql.' WHERE id='.$_GET["row"].'');

    if ($query) {

echo '<script>
alert("Saved");
window.location.href="table.php?id='.$_GET['table'].'";
</script>';
        
}
    
}

?>


    
    
    <div class="container">

        <br>
<?php
$rows = array();
$sql = 'SHOW COLUMNS FROM '.$row_table["table_title"].'';
$result = mysqli_query($con,$sql);
while($column_row = mysqli_fetch_array($result)){
    
if($column_row['Field']!='id' and $column_row['Field']!='visible' and $column_row['Field']!='sorting'){    
  array_push($rows, $column_row['Field']);
    
    }
}
        
        
?>
        
     
    <form method="post" enctype="multipart/form-data">      
        <?php            
        foreach($rows as $row){
        $sql = "select * from column_settings where table_title = '".$row_table["table_title"]."' and column_title = '".$row."'";
        $result = mysqli_query($con,$sql);
        $column_row = mysqli_fetch_array($result);            
            ?>

        <?php if($column_row['column_type'] == 'short_text'){?>
  <div class="mb-3 mt-3">
        <label for="<?php echo $column_row['id']?>"><?php echo $column_row['column_title']?></label>        
        <input <?php if($column_row['required'] == 1){?>required<?php }?> class="form-control" value="<?php echo $row_value[$row]?>" type="text" id="<?php echo $column_row['id']?>" name="<?php echo $row; ?>" maxlength="<?php echo $column_row['column_size']?>" size="<?php echo $column_row['column_size']?>">
          </div>
        <?php }?>
        
        
                <?php if($column_row['column_type'] == 'long_text'){?>
  <div class="mb-3 mt-3">
        <label for="<?php echo $column_row['id']?>"><?php echo $column_row['column_title']?></label>        
      <textarea <?php if($column_row['required'] == 1){?>required<?php }?> class="form-control" id="<?php echo $column_row['id']?>" name="<?php echo $row; ?>"><?php echo $row_value[$row]?></textarea>
      
            <?php if($column_row['ckeditor'] == 1){?>
                
      
                      <script>
                        CKEDITOR.replace( '<?php echo $row; ?>' );
                </script>
      
                
        <?php }?>
      
          </div>
        <?php }?>
        
        
         <?php if($column_row['column_type'] == 'image'){?>
  <div class="mb-3 mt-3">
      
      <?php if($row_value[$row] != NULL){ ?>
      
      <img style="width:200px; height:200px" src="upload/<?php echo $row_value[$row]?>">
      <br>
      <?php }?>
        <label for="<?php echo $column_row['id']?>"><?php echo $column_row['column_title']?></label>        
        <input accept="image/*" class="form-control" type="file" id="<?php echo $column_row['id']?>" name="<?php echo $row; ?>">
          </div>
        <?php }?>
        
                 <?php if($column_row['column_type'] == 'file'){?>
  <div class="mb-3 mt-3">
        <label for="<?php echo $column_row['id']?>"><?php echo $column_row['column_title']?></label>        
        <input class="form-control" type="file" id="<?php echo $column_row['id']?>" name="<?php echo $row; ?>">
          </div>
        <?php }?>
        
        
        <?php if($column_row['column_type'] == 'relations'){?>        
  <div class="mb-3 mt-3">
        <label for="<?php echo $column_row['id']?>"><?php echo $column_row['column_title']?></label>        
          <select <?php if($column_row['required'] == 1){?>required<?php }?> name="<?php echo $row; ?>" class="form-control" id="<?php echo $column_row['id']?>">
              
                    <?php
        $sql = "select * from tables_relations where parent = '".$row_table["table_title"]."' and parent_column = '".$row."'";
        $result = mysqli_query($con,$sql);
        $column_row = mysqli_fetch_assoc($result);
            



            $sql = 'select * from '.$column_row['child'].'';
            $result = mysqli_query($con,$sql);
            while($flex_row = mysqli_fetch_array($result)){ ?>
                <option <?php if($row_value[$row] == $flex_row['id']) {echo'selected';} ?> value="<?php echo $flex_row['id']; ?>"> <?php echo $flex_row[$column_row['child_column']]; ?></option>

        <?php } ?>
              
          </select>
        </div>
        <?php }?>
        
        
        
        

        
        
        
        
        <?php }?>
        

        <button class="btn btn-success" type="submit">Save</button>
        
    </form>
    
</body>    
</html>
