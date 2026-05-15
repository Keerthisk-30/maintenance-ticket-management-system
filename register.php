<?php
include 'config.php';
$msg = '';
$error = '';
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    /* Check Existing Email */
    $check = mysqli_prepare($conn,
    "SELECT * FROM users WHERE email=?");
    mysqli_stmt_bind_param($check,"s",$email);
    mysqli_stmt_execute($check);
    $result = mysqli_stmt_get_result($check);
    if(mysqli_num_rows($result) > 0){
        $error = "Email Already Registered";
    }else{
        $stmt = mysqli_prepare($conn,
        "INSERT INTO users(name,email,password) VALUES(?,?,?)");
        mysqli_stmt_bind_param(
            $stmt,
            "sss",
            $name,
            $email,
            $password
        );
        mysqli_stmt_execute($stmt);
        $msg = "Registration Successful";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>User Registration</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="style.css">
</head>
<body class="login-bg d-flex justify-content-center align-items-center">
<div class="card login-card shadow-lg p-5" style="width:400px">
    <h2 class="text-center mb-4">
        User Registration
    </h2>
    <?php if($msg): ?>
        <div class="alert alert-success">
            <?= $msg ?>
        </div>
    <?php endif; ?>
    <?php if($error): ?>
        <div class="alert alert-danger">
            <?= $error ?>
        </div>
    <?php endif; ?>
    <form method="POST">
        <input 
            type="text"
            name="name"
            class="form-control mb-3"
            placeholder="Enter Name"
            required
        >
        <input 
            type="email"
            name="email"
            class="form-control mb-3"
            placeholder="Enter Email"
            required
        >
        <input 
            type="password"
            name="password"
            class="form-control mb-3"
            placeholder="Enter Password"
            required
        >
        <button class="btn btn-primary w-100">
            Register
        </button>
    </form>
    <a href="user-login.php" class="d-block text-center mt-3">
        Already have account?
    </a>
</div>
</body>
</html>