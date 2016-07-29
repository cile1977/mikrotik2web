<?php
  include "net_dbconfig.php";
  
  //get data from header
  $router=$_GET['router'];
  $status=$_GET['status'];
  $time=$_GET['time'];
  
  $router=mysqli_real_escape_string($conn,$router);
  $status=mysqli_real_escape_string($conn,$status);
  $time=mysqli_real_escape_string($conn,$time);
  
  $query="UPDATE netwatch SET status='".$status."', time='".$time."' WHERE id='".$router."'";
  
  $result=mysqli_query($conn,$query) or die(mysqli_error($conn));
?>
