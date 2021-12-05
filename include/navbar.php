<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php"><?php echo $_SERVER['SERVER_NAME']; ?></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="collapsibleNavbar">
      <ul class="navbar-nav">
          
                   <?php
$ret=mysqli_query($con,"select * from tables");
$cnt=1;
$row=mysqli_num_rows($ret);
if($row>0){
while ($row=mysqli_fetch_array($ret)) {
{?>
     
             
          
          
        <li class="nav-item">
         <a class="nav-link" href="table.php?id=<?php echo $row["id"]?>"><?php echo $row["table_text"]?></a>
        </li>
          

                    <?php 
$cnt=$cnt+1;
} }} else {?>
<tr>
    <th style="text-align:center; color:red;" colspan="6">Нету моделей</th>
</tr>
<?php } ?>           
          
        
      </ul>
    </div>
  </div>
</nav>
