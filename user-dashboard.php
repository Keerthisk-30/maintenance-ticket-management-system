<?php
include 'config.php';
/* Check User Login */
if(!isset($_SESSION['user'])){
    header('Location: user-login.php');
    exit;
}
/* Fetch User Tickets */
$stmt = mysqli_prepare($conn,
"SELECT * FROM tickets WHERE email=? ORDER BY id DESC");
mysqli_stmt_bind_param(
    $stmt,
    "s",
    $_SESSION['user']
);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
/* Ticket Statistics */
$total = mysqli_fetch_assoc(
mysqli_query($conn,
"SELECT COUNT(*) as total FROM tickets WHERE email='" . $_SESSION['user'] . "'")
)['total'];
$open = mysqli_fetch_assoc(
mysqli_query($conn,
"SELECT COUNT(*) as total FROM tickets WHERE email='" . $_SESSION['user'] . "' AND status='Open'")
)['total'];
$closed = mysqli_fetch_assoc(
mysqli_query($conn,
"SELECT COUNT(*) as total FROM tickets WHERE email='" . $_SESSION['user'] . "' AND status='Closed'")
)['total'];
?>
<!DOCTYPE html>
<html>
<head>
<title>User Dashboard</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="style.css">
</head>
<body>
<!-- Sidebar -->
<div class="sidebar">
    <h2 class="mb-4">
        <i class="fa-solid fa-user"></i>
        User Panel
    </h2>
    <a href="user-dashboard.php">
        <i class="fa-solid fa-table"></i>
        My Tickets
    </a>
    <a href="open-ticket.php">
        <i class="fa-solid fa-ticket"></i>
        Create Ticket
    </a>
    <a href="check-status.php">
        <i class="fa-solid fa-magnifying-glass"></i>
        Check Status
    </a>
    <a href="logout.php">
        <i class="fa-solid fa-right-from-bracket"></i>
        Logout
    </a>
    <!-- Dark Mode -->
    <button 
        onclick="toggleTheme()" 
        class="btn btn-dark w-100 mt-4"
    >
        🌙 Dark Mode
    </button>
</div>
<!-- Main Content -->
<div class="main">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold">
                Welcome <?= $_SESSION['user_name'] ?>
            </h2>
            <p class="text-muted">
                Manage your tickets here
            </p>
        </div>
        <div>
            <h5>
                <?= date("d M Y h:i A") ?>
            </h5>
        </div>
    </div>
    <!-- Statistics Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card-box bg-blue shadow">
                <h5>Total Tickets</h5>
                <h1><?= $total ?></h1>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card-box bg-orange shadow">
                <h5>Open Tickets</h5>
                <h1><?= $open ?></h1>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card-box bg-green shadow">
                <h5>Closed Tickets</h5>
                <h1><?= $closed ?></h1>
            </div>
        </div>
    </div>
    <!-- Tickets Table -->
    <div class="card shadow border-0">
        <div class="card-body">
            <h4 class="mb-4">
                My Tickets
            </h4>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Department</th>
                            <th>Issue</th>
                            <th>Priority</th>
                            <th>Status</th>
                            <th>Attachment</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td>
                                <?= $row['id'] ?>
                            </td>
                            <td>
                                <?= $row['department'] ?>
                            </td>
                            <td>
                                <?= $row['issue'] ?>
                            </td>
                            <td>
                                <?php 
                                if(strpos($row['priority'], 'High') !== false){
                                    echo '<span class="badge bg-danger">High</span>';
                                }elseif(strpos($row['priority'], 'Medium') !== false){
                                    echo '<span class="badge bg-warning text-dark">Medium</span>';
                                }else{
                                    echo '<span class="badge bg-success">Low</span>';
                                }
                                ?>
                            </td>
                            <td>
                                <?php if($row['status'] == 'Open'): ?>
                                    <span class="badge bg-warning text-dark">
                                        Open
                                    </span>
                                <?php else: ?>
                                    <span class="badge bg-success">
                                        Closed
                                    </span>
                                <?php endif; ?>
                            </td>
                            <!-- Attachment -->
                            <td>
                                <?php if($row['attachment'] != ''): ?>
                                    <a 
                                        href="<?= $row['attachment'] ?>" 
                                        target="_blank"
                                        class="btn btn-primary btn-sm"
                                    >
                                        <i class="fa-solid fa-paperclip"></i>
                                        View
                                    </a>
                                <?php else: ?>
                                    <span class="text-muted">
                                        No File
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?= $row['created_at'] ?>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- Dark Mode -->
<script>
function toggleTheme(){
    document.body.classList.toggle('dark');
}
</script>
</body>
</html>