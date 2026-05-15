<?php
include 'config.php';
$error = '';
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $stmt = mysqli_prepare($conn,
    "SELECT * FROM users WHERE email=?");
    mysqli_stmt_bind_param($stmt,"s",$email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);
    if($user && password_verify($password,$user['password'])){
        $_SESSION['user'] = $user['email'];
        $_SESSION['user_name'] = $user['name'];
        header('Location: user-dashboard.php');
        exit;
    }else{
        $error = "Invalid Email or Password";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>User Login</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="style.css">
</head>
<body class="login-bg d-flex justify-content-center align-items-center">
<div class="card login-card shadow-lg p-5" style="width:400px">
    <h2 class="text-center mb-4">
        User Login
    </h2>
    <?php if($error): ?>
        <div class="alert alert-danger">
            <?= $error ?>
        </div>
    <?php endif; ?>
    <form method="POST">
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
        <button class="btn btn-success w-100">
            Login
        </button>
    </form>
    <a href="register.php" class="d-block text-center mt-3">
        Create Account
    </a>
</div>
</body>
</html>