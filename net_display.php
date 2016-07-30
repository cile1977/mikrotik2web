<html>
<head>
	<style> table, th, td {padding: 5px;} </style>
</head>
<body>
	<table>
	<?php
	include "net_dbconfig.php";
	
	$query="SELECT * FROM netwatch";
	$result=mysqli_query($conn,$query)or die(mysql_error($conn));
	
	while($row = mysqli_fetch_assoc($result)) {
	   $id = $row['id'];
	   $name = $row['name'];
	   $status = $row['status'];
	   $time = $row['time'];
	   $filename = $name."_reg_table.txt";
	   //dohvati trenutni broj konekcija za točku
	   $sqlCnt="SELECT count(*) AS cnt_konekcije FROM netwatch_signal where routerId=$id";
	   $resultCnt=mysqli_query($conn,$sqlCnt)or die(mysql_error($conn));
	   $rowCnt = mysqli_fetch_assoc($resultCnt);
	   $brojKonekcija = $rowCnt['cnt_konekcije'];
	
	   echo "<tr>";
	   if ($status=="1")
	    {
	    echo '<td align=center><img src="/net_green_icon.png" style="width:30px;"></td>';
	    echo "<td align=left><font color=#04B404><a href=\"/net_display_signal.php?routerID=".$id."\" target=\"_blank\">".$name."</a></font></td>";
	    }else{
	    echo '<td align=center><img src="/net_red_icon.png" style="width:30px;"></td>';
	    echo "<td align=left><font color=#FF0000>".$name."</font></td>";
	    }
	   echo "<td align=left>".$brojKonekcija."</td>";   
	   echo "<td align=left><font size=0.5em>";
	   echo $time;
	   echo "</font></td></tr>";
	   }
	?>
	</table>
	<font size=0.5em><p style="line-height:1">Broj iza naziva pristupne točke pokazuje koliko trenutno ima konekcija na toj točki.</p>
	<p style="line-height:1">Vrijeme označava kad je bila zadnja izmjena statusa. Ako je točka nedostupna, vrijeme pokazuje od kada je nedostupna.
	U suprotnom, vrijeme pokazuje od kada je proradila, tj. koliko dugo nije bilo prekida rada (kvar, restart).</p>
	<p style="line-height:1">Klik na naziv pristupne točke vodi na popis spojenih klijenata na kojem se može vidjeti jačina signala.</p></font>
</body>
</html>
