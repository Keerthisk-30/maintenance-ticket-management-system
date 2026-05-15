<?php include 'config.php'; ?>
<!DOCTYPE html>
<html>
<head>
<title>Maintenance Ticket Management System</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="style.css">
<style>
.hero{
    background: linear-gradient(135deg,#1e3a8a,#2563eb);
    color:white;
    padding:80px 20px;
    border-radius:20px;
    margin-bottom:40px;
}
.card{
    border:none;
    border-radius:20px;
    transition:0.3s;
}
.card:hover{
    transform:translateY(-8px);
}
.icon-box{
    font-size:60px;
    margin-bottom:20px;
}
</style>
</head>
<body>
<div class="container py-5">
    <!-- Hero Section -->
    <div class="hero text-center shadow">
        <h1 class="display-5 fw-bold">
            Maintenance Ticket Management System
        </h1>
        <p class="mt-3 fs-5">
            A professional helpdesk solution for managing maintenance requests efficiently.
        </p>
    </div>
    <!-- Cards Section -->
    <div class="row g-4">
        <!-- User Panel -->
        <div class="col-md-4">
            <div class="card shadow-lg p-4 text-center h-100">
                <div class="icon-box text-primary">
                    <i class="fa-solid fa-user"></i>
                </div>
                <h3>User Panel</h3>
                <p class="text-muted">
                    Register, login, create tickets, upload attachments, and track maintenance requests.
                </p>
                <div class="d-grid gap-2">
                    <a href="register.php" class="btn btn-primary">
                        Register
                    </a>
                    <a href="user-login.php" class="btn btn-outline-primary">
                        User Login
                    </a>
                </div>
            </div>
        </div>
        <!-- Track Ticket -->
        <div class="col-md-4">
            <div class="card shadow-lg p-4 text-center h-100">
                <div class="icon-box text-warning">
                    <i class="fa-solid fa-ticket"></i>
                </div>
                <h3>Track Tickets</h3>
                <p class="text-muted">
                    Check ticket status and monitor maintenance issue progress in real time.
                </p>
                <a href="check-status.php" class="btn btn-warning">
                    Check Status
                </a>
            </div>
        </div>
        <!-- Admin Panel -->
        <div class="col-md-4">
            <div class="card shadow-lg p-4 text-center h-100">
                <div class="icon-box text-success">
                    <i class="fa-solid fa-user-shield"></i>
                </div>
                <h3>Admin Panel</h3>
                <p class="text-muted">
                    Manage tickets, monitor analytics, close requests, and control the system.
                </p>
                <a href="login.php" class="btn btn-success">
                    Admin Login
                </a>
            </div>
        </div>
    </div>
    <!-- Footer -->
    <div class="text-center mt-5 text-muted">
        <p>
            Developed using PHP, MySQL, Bootstrap, JavaScript, and Chart.js
        </p>
    </div>
</div>
</body>
</html>