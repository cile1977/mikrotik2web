<?php
include "net_dbconfig.php";
$routerID = $_GET['routerID'];
$routerID = mysqli_real_escape_string($conn,$routerID);

//dohvati id routera po nazivu
$query="SELECT name,signal_time FROM netwatch where id=$routerID";
$result=mysqli_query($conn,$query) or die(mysql_error($conn));
$row = mysqli_fetch_assoc($result);
$routerName = $row['name'];
$signalTime = $row['signal_time'];
?>
<html>
        <head>
                <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
                <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        </head>
        <body>
                <div class="container">
                <?php
                echo "<h2>Pristupna točka: ".$routerName."</h2>";
                echo "<p>Podaci od: ".$signalTime."</p>";
                ?>
                <table class="table">
                <thead><tr><th class="col-md-7">Korisnik</th><th class="col-md-5">Signal</th></tr></thead>
                <tbody>
                <?php        
                $query="SELECT * FROM netwatch_signal where routerId=$routerID order by user";
                $result=mysqli_query($conn,$query) or die(mysql_error($conn));
                while($row = mysqli_fetch_assoc($result)) {
                  $routerId = $row['routerId'];
                  $user = $row['user'];
                  $signal = $row['signal'];
                  $numSignal = (int)substr($signal,1,2);
                
                  if ($numSignal>80)
                  {
                      echo '<tr class="danger">';
                  } else
                  {
                      echo '<tr class="success">';
                  }
                  echo "<td>".$user."</td>";
                  echo "<td>".$signal."</td>";
                  echo "</tr>";
                  }
                ?>
                </tbody>
                </table>
                </div>
        </body>
</html>
