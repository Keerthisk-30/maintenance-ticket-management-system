<?php
include 'config.php';
$error='';
if($_SERVER['REQUEST_METHOD']=='POST'){
    if($_POST['username']==$username && $_POST['password']==$password){
        $_SESSION['admin']=true;
        header('Location: dashboard.php');
        exit;
    }else{
        $error='Invalid Credentials';
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Admin Login</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="style.css">
</head>
<body class="login-bg d-flex justify-content-center align-items-center">
<div class="card login-card shadow-lg p-5" style="width:400px">
    <h2 class="text-center mb-4">
        Admin Login
    </h2>
    <?php if($error): ?>
        <div class="alert alert-danger">
            <?= $error ?>
        </div>
    <?php endif; ?>
    <form method="POST">
        <input 
            type="text" 
            name="username" 
            class="form-control mb-3" 
            placeholder="Username"
            required
        >
        <input 
            type="password" 
            name="password" 
            class="form-control mb-3" 
            placeholder="Password"
            required
        >
        <button class="btn btn-primary w-100">
            Login
        </button>
    </form>
    <p class="text-center mt-3">
        admin / admin123
    </p>
</div>
</body>
</html>