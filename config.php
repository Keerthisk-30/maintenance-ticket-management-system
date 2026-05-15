<?php
session_start();
/* MySQL Connection */
$conn = mysqli_connect(
    "localhost",
    "root",
    "",
    "helpdesk_system"
);
/* Connection Check */
if(!$conn){
    die("Database Connection Failed");
}
/* Admin Credentials */
$username = "admin";
$password = "admin123";
?>