<?php
$conn = mysqli_connect("localhost", "db_user", "db_pass") or die(mysqli_error($conn));
$db = mysqli_select_db($conn, "db_name") or die(mysqli_error($conn));
?>
