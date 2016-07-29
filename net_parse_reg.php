<?php
include "net_dbconfig.php";
//get data from header
$router = $_GET['router'];
$router = mysqli_real_escape_string($conn,$router);
$filename = $router."_reg_table.txt";
$txt_file = file_get_contents($filename);

//dohvati id routera po nazivu
$query="SELECT id FROM netwatch where name='$router'";
$result=mysqli_query($conn,$query) or die(mysql_error($conn));
$row = mysqli_fetch_assoc($result);
$routerID = $row['id'];

//update vremena signala
if (file_exists($filename)) {
    $signal_time = date("d.m.Y H:i", filectime($filename));
    $query="UPDATE netwatch SET signal_time='$signal_time' where id=$routerID";
    $result=mysqli_query($conn,$query) or die(mysql_error($conn));
}

//obriši prethodne podatke
$query="DELETE FROM netwatch_signal where routerId=$routerID";
$result=mysqli_query($conn,$query) or die(mysql_error($conn));

//parse txt datoteke i insert u tablicu
$rows = explode("\n", $txt_file);
array_shift($rows);
if ($routerID == 6)
    {
    //parse za hotspot
    foreach($rows as $row => $data)
        {
          if ($row<3) {continue;};
          $user = substr($data,40,17);
          $signal = substr($data,62);
          if (empty($signal)) {continue;};
          $query="INSERT INTO netwatch_signal VALUES ($routerID,'$user','$signal')";
          $result=mysqli_query($conn,$query) or die(mysql_error($conn));
          //echo $user." ".$signal."<br>";     
         }
    } else
    {
    //parse za normalne točke
    foreach($rows as $row => $data)
        {
          if ($row<3) {continue;};
          if ($row % 2 == 0)
          {
          $signal = substr($data,62);
          $query="INSERT INTO netwatch_signal VALUES ($routerID,'$user','$signal')";
          $result=mysqli_query($conn,$query) or die(mysql_error($conn));
          //echo $user." ".$signal."<br>";
          } else
          {
          $user = substr($data,7);               
          }
         }
    }
?>
