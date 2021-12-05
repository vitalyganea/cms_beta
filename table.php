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



<!DOCTYPE html>
<html lang="en">
    <?php
    include('include/head.php');
    ?>
<body>

    <?php
    include('include/navbar.php');
    ?>
    
 <div class="container-fluid mt-3">
   
<div class="container">
    <div class="d-flex justify-content-between">
        <div><h2>Administration - <?php echo $row_table["table_text"];?></h2></div>
        <div>    
            <a href="table_add.php?id=<?php echo $_GET['id'];?>"><button type="button" class="btn btn-success">Add element</button></a>
        </div>
    </div>

    <div style="height:60px">
    
<div style="display:none" class="alert alert_sort_updated icon-alert with-arrow alert-success form-alter" role="alert">
 <i class="fa fa-fw fa-check-circle"></i>
 <strong> Success ! </strong> <span class="success-message"> Item order has been updated successfully </span>
</div>
    
<div style="display:none" class="alert alert_sort_error icon-alert with-arrow alert-danger form-alter" role="alert">
 <i class="fa fa-fw fa-times-circle"></i>
 <strong> Note !</strong> <span class="warning-message"> Empty list cant be ordered </span>
</div>
    
    
<div style="display:none" class="alert alert_hide icon-alert with-arrow alert-warning form-alter" role="alert">
 <i class="fa fa-fw fa fa-eye-slash"></i>
 <strong> Atention ! </strong> <span class="warning-message"> Item is hidden from site! </span>
</div>
<div style="display:none" class="alert alert_show icon-alert with-arrow alert-warning form-alter" role="alert">
 <i class="fa fa-fw fa fa-eye"></i>
 <strong> Atention ! </strong> <span class="warning-message"> Item is showing on site! </span>
</div>
</div>
   
    
    
  <table class="table">
    <thead>
      <tr>
          
    <?php
$rows = array();
$sql = 'SHOW COLUMNS FROM '.$row_table["table_title"].'';
$result = mysqli_query($con,$sql);
while($column_row = mysqli_fetch_array($result)){?>

          
        <?php if($column_row['Field']!='sorting' and $column_row['Field']!='visible'){?> 
      
    <th><?php echo $column_row['Field'];?></th>
          
          <?php }?>
          
    <?php if($column_row['Field']=='sorting'){ 
    $sorting = 'order by sorting asc';
    $sorting_js = 1;
}else{
    $sorting = 'order by id desc'; 
    $sorting_js = 0;


}?>
          
<?php } ?>
          

      </tr>
    </thead>
    <tbody id="post_list">


    
          
<?php
$ret=mysqli_query($con,'select * from '.$row_table["table_title"].' '.$sorting.'');
$cnt=1;
$row=mysqli_num_rows($ret);
if($row>0){
while ($row=mysqli_fetch_assoc($ret)) {
    

    echo '<tr data-post-id='.$row["id"].'>';
    
    foreach($row as $key => $value){
        
        
        if($key == 'id'){
        $row_id = $value;
         echo '<td>'.$value.'</td>';
        }
        
if (array_key_exists('visible', $row)) {
        if($key == 'visible'){
        $row_visibility = $value;
        }
}
        

        
        
        $ret2=mysqli_query($con, "select * from column_settings where table_title = '".$row_table["table_title"]."' and column_title = '".$key."'");
            $row2=mysqli_fetch_assoc($ret2);
        if($row2!=null){
            
            
            if($row2['column_type'] == 'short_text'){
                     echo '<td>'.$value.'</td>';

            }
            
            
            if($row2['column_type'] == 'long_text'){
                     echo '<td>'.$value.'</td>';

            }
            
            
            if($row2['column_type'] == 'image'){
                     echo '<td><img width="100" height="100" class="img-rounded" src="upload/'.$value.'">
                     </td>';

            }
            
             if($row2['column_type'] == 'file'){
                     echo '<td>            
                     <a href="'.$value.'" download>'.$value.'</a>                     
                     </td>';
            }
            

            
            
            
            if($row2['column_type'] == 'relations'){
                
        $ret2=mysqli_query($con, "select * from tables_relations where parent = '".$row_table["table_title"]."' and parent_column = '".$key."'");
        $row2=mysqli_fetch_assoc($ret2);
                
                
        $ret3=mysqli_query($con, 'select '.$row2['child_column'].' from '.$row2['child'].' where id = '.$value.'');
        $row3=mysqli_fetch_assoc($ret3);

                
                echo '<td>'.$row3[$row2['child_column']].'</td>';

            }
            
        }
    
        
        
        
        
    }?>
        <?php if(isset($row_visibility)){?>
    <td>
        <?php if($row_visibility==1){?>
        <span class="visibility" data-visibility="<?php echo $row_visibility;?>" data-table="<?php echo $_GET['id'];?>" data-element="<?php echo $row_id;?>"><i class='fa fa-eye'></span></i>
        <?php }else{ ?>
        <span class="visibility" data-visibility="<?php echo $row_visibility;?>" data-table="<?php echo $_GET['id'];?>" data-element="<?php echo $row_id;?>"><i class='fa fa-eye-slash'></span></i>
    <?php } ?>
    <?php } ?>
        </td>
    <td><a href="table_edit.php?table=<?php echo $_GET['id'];?>&row=<?php echo $row_id;?>"><i class='fa fa-pencil'></a></i></td>
    <td><a href="table_delete.php?table=<?php echo $_GET['id'];?>&row=<?php echo $row_id;?>" onclick="return confirm('are you sure?');"><i class='fa fa-trash'></a></i></td>
    
   </tr>

                  
<?php 
 }} else {?>

<?php } ?> 

        
    </tbody>
  </table>
</div>
</div>
    
        <?php if(isset($row_visibility)){?>
 

<script>
$(document).on("click",".visibility", function (event) {
    
    table_id = $(this).data("table");
    element_id = $(this).data("element");
    element_visibility = $(this).data("visibility");
    parent = $(this);

    $.ajax(
        {
      type: 'post',
      url: 'include/change_visibility.php',
      data: { 
        "table_id": table_id,
        "element_id": element_id,
        "element_visibility": element_visibility
      },
      success: function (response) {
          console.log(response);
          if(element_visibility==1){
              $(parent).children('i').removeClass('fa-eye');
              $(parent).children('i').addClass('fa-eye-slash');
              $(parent).data('visibility', 0);
              
              	$(".alert").hide(1000);
			 	$(".alert_hide").show(1000);

          }else{
              $(parent).children('i').removeClass('fa-eye-slash');
              $(parent).children('i').addClass('fa-eye');  
                $(parent).data('visibility', 1);
              
              	$(".alert").hide(1000);
			 	$(".alert_show").show(1000);

          }
          
          
      },
      error: function () {
        alert("Error !!");
      }
   }
);   
});    
</script>

<?php } ?> 


<?php if($sorting_js == 1){ ?>

<script>
$( "#post_list" ).sortable({
	placeholder : "ui-state-highlight",
	update  : function(event, ui)
	{
		var order_ids = new Array();
        var table = '<?php echo $row_table["table_title"];?>';
		$('#post_list tr').each(function(){
			order_ids.push($(this).data("post-id"));
		});
		$.ajax({
			url:"include/change_order.php",
			method:"POST",
			data:{order_ids:order_ids, table:table},
			success:function(data)
			{
			 if(data){
			 	$(".alert").hide(1000);
			 	$(".alert_sort_updated").show(1000);
                 console.log(data);
			 }else{
			 	$(".alert").hide(1000);
			 	$(".alert_sort_error").show(1000);
                 console.log(data);

			 }
			},
            			error:function(data)
			{
                console.log(data);
            }
		});
	}
});
</script>

<?php } ?>
    
</body>    
</html>
