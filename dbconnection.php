<?php
$con=mysqli_connect("localhost", "root", "", "users");
if(mysqli_connect_errno()){
echo "Connection Fail".mysqli_connect_error();
}
?>