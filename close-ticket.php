<?php
include 'config.php';
if(isset($_GET['id'])){
    $stmt = mysqli_prepare($conn,
    "UPDATE tickets SET status='Closed' WHERE id=?");
    mysqli_stmt_bind_param(
        $stmt,
        "i",
        $_GET['id']
    );
    mysqli_stmt_execute($stmt);
}
header('Location: dashboard.php');
?>