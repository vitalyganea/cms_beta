<?php include('dbconnection.php');?>

<?php
$ret=mysqli_query($con, 'select * from tables where id = '.$_GET['id'].'');
$cnt=1;
$row_table=mysqli_num_rows($ret);
if($row_table>0){
$row_table=mysqli_fetch_array($ret);
{?>
     

                    <?php 
$cnt=$cnt+1;
} } else {?>
<tr>
    <th style="text-align:center; color:red;" colspan="6">Нету моделей</th>
</tr>
<?php } ?>



<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    



    

    $keys='';
    $values = '';
    
foreach($_POST as $key => $value){

    $keys = $keys.$key.',';
    $values = $values."'".$value."',";
    
}
    
    
if(!empty($_FILES)) {
    $file_columns = array_keys($_FILES);

    
    foreach($file_columns as $file_column){
    if(!empty($_FILES[$file_column]['tmp_name'])){
        $keys = $keys.$file_column.',';    
    }
    }
    
    foreach($_FILES as $file){   
        if(!empty($file['tmp_name'])){
        $tmp_file = $file['tmp_name'];
        $ext = pathinfo($file["name"], PATHINFO_EXTENSION);
        $rand = md5(uniqid().rand());
        $post_file = $rand.".".$ext;
        move_uploaded_file($tmp_file,"upload/".$post_file);
        $values = $values."'".$post_file."',";
        }
    }
}

    
    
    $keys = substr($keys, 0, -1);
    $values = substr($values, 0, -1);

    

    
    $query=mysqli_query($con, 'insert into '.$row_table['table_title'].' ('.$keys.') value('.$values.')');

    if ($query) {

echo '<script>
alert("Added");
window.location.href="table.php?id='.$_GET['id'].'";
</script>';
        
}
    
}

?>



<!DOCTYPE html>
<html lang="en">
    <?php
    include('include/head.php');
    ?>
<body>

    <?php
    include('include/navbar.php');
    ?>
</body>
    
    
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
        $column_row = mysqli_fetch_assoc($result);  
            
            if($column_row != null){

            
            ?>

        <?php if($column_row['column_type'] == 'short_text'){?>
  <div class="mb-3 mt-3">
        <label for="<?php echo $column_row['id']?>"><?php echo $column_row['column_title']?></label>        
        <input <?php if($column_row['required'] == 1){?>required<?php }?> class="form-control" type="text" id="<?php echo $column_row['id']?>" name="<?php echo $row; ?>" maxlength="<?php echo $column_row['column_size']?>" size="<?php echo $column_row['column_size']?>">
          </div>
        <?php }?>
        
        
        <?php if($column_row['column_type'] == 'long_text'){?>
  <div class="mb-3 mt-3">
        <label for="<?php echo $column_row['id']?>"><?php echo $column_row['column_title']?></label>        
      <textarea <?php if($column_row['required'] == 1){?>required<?php }?> class="form-control" id="<?php echo $column_row['id']?>" name="<?php echo $row; ?>"></textarea>
      
      <?php if($column_row['ckeditor'] == 1){?>
                
      
                      <script>
                        CKEDITOR.replace( '<?php echo $row; ?>' );
                </script>
      
                
        <?php }?>
          </div>
        <?php }?>
        
        
         <?php if($column_row['column_type'] == 'image'){?>
  <div class="mb-3 mt-3">
        <label for="<?php echo $column_row['id']?>"><?php echo $column_row['column_title']?></label>        
        <input accept="image/*" <?php if($column_row['required'] == 1){?>required<?php }?> class="form-control" type="file" id="<?php echo $column_row['id']?>" name="<?php echo $row; ?>">
          </div>
        <?php }?>
        
                 <?php if($column_row['column_type'] == 'file'){?>
  <div class="mb-3 mt-3">
        <label for="<?php echo $column_row['id']?>"><?php echo $column_row['column_title']?></label>        
        <input <?php if($column_row['required'] == 1){?>required<?php }?> class="form-control" type="file" id="<?php echo $column_row['id']?>" name="<?php echo $row; ?>">
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
                <option value="<?php echo $flex_row['id']; ?>"> <?php echo $flex_row[$column_row['child_column']]; ?></option>

        <?php } ?>
              
          </select>
        </div>
        <?php }?>
        
        
        
        

        
        
        
        
        <?php }}?>
        

        <button class="btn btn-success" type="submit">Add</button>
        
    </form>
        
    
    </div>
    
    
</html>
