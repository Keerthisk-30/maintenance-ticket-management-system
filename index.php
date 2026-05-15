<?php include 'config.php'; ?>
<!DOCTYPE html><html><head>
<title>Maintenance System</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="style.css">
</head><body>
<div class="container py-5">
<h1 class="text-center text-primary mb-5">Professional Maintenance Ticket System</h1>
<div class="row g-4">
<div class="col-md-4"><div class="card p-4 shadow text-center"><i class="fa-solid fa-ticket fa-3x text-primary"></i><h4 class="mt-3">Open Ticket</h4><a href="open-ticket.php" class="btn btn-primary mt-3">Create</a></div></div>
<div class="col-md-4"><div class="card p-4 shadow text-center"><i class="fa-solid fa-magnifying-glass fa-3x text-warning"></i><h4 class="mt-3">Check Status</h4><a href="check-status.php" class="btn btn-warning mt-3">Track</a></div></div>
<div class="col-md-4"><div class="card p-4 shadow text-center"><i class="fa-solid fa-user-shield fa-3x text-success"></i><h4 class="mt-3">Admin Panel</h4><a href="login.php" class="btn btn-success mt-3">Login</a></div></div>
</div></div></body></html>