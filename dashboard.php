<?php
include 'config.php';
/* Default Search Values */
$search = '';
$priority_filter = '';
/* Admin Authentication */
if(!isset($_SESSION['admin'])){
    header('Location: login.php');
    exit;
}
/* Search & Filter */
$where = "1=1";
if(isset($_GET['search']) && $_GET['search'] != ''){
    $search = $_GET['search'];
    $where .= " AND (
        name LIKE '%$search%' OR
        department LIKE '%$search%' OR
        issue LIKE '%$search%'
    )";
}
if(isset($_GET['priority']) && $_GET['priority'] != ''){
    $priority_filter = $_GET['priority'];
    $where .= " AND priority='$priority_filter'";
}
/* Statistics */
$total = mysqli_fetch_assoc(
mysqli_query($conn,
"SELECT COUNT(*) as total FROM tickets")
)['total'];
$open = mysqli_fetch_assoc(
mysqli_query($conn,
"SELECT COUNT(*) as total FROM tickets WHERE status='Open'")
)['total'];
$closed = mysqli_fetch_assoc(
mysqli_query($conn,
"SELECT COUNT(*) as total FROM tickets WHERE status='Closed'")
)['total'];
$high = mysqli_fetch_assoc(
mysqli_query($conn,
"SELECT COUNT(*) as total FROM tickets WHERE priority='High'")
)['total'];
/* Fetch Tickets */
$result = mysqli_query($conn,
"SELECT * FROM tickets WHERE $where ORDER BY id DESC");
?>
<!DOCTYPE html>
<html>
<head>
<title>Dashboard</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="style.css">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<!-- Sidebar -->
<div class="sidebar">
    <h2 class="mb-4">
        <i class="fa-solid fa-screwdriver-wrench"></i>
        HelpDesk
    </h2>
    <a href="dashboard.php">
        <i class="fa-solid fa-chart-line"></i>
        Dashboard
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
    <!-- Welcome -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4>
                Welcome Admin
            </h4>
        </div>
        <div>
            <h6>
                <?= date("d M Y h:i A") ?>
            </h6>
        </div>
    </div>
    <!-- Statistics Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card-box bg-blue shadow">
                <h4>Total Tickets</h4>
                <h1><?= $total ?></h1>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card-box bg-orange shadow">
                <h4>Open Tickets</h4>
                <h1><?= $open ?></h1>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card-box bg-green shadow">
                <h4>Closed Tickets</h4>
                <h1><?= $closed ?></h1>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card-box shadow bg-danger text-white">
                <h4>High Priority</h4>
                <h1><?= $high ?></h1>
            </div>
        </div>
    </div>
    <!-- Search & Filter -->
    <div class="card shadow border-0 mb-4">
        <div class="card-body">
            <form method="GET">
                <div class="row g-3">
                    <div class="col-md-5">
                        <input 
                            type="text"
                            name="search"
                            class="form-control"
                            placeholder="Search Tickets"
                            value="<?= $search ?>"
                        >
                    </div>
                    <div class="col-md-4">
                        <select name="priority" class="form-select">
                            <option value="">
                                All Priorities
                            </option>
                            <option value="Low">
                                Low
                            </option>
                            <option value="Medium">
                                Medium
                            </option>
                            <option value="High">
                                High
                            </option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-primary w-100">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            Search
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- Chart -->
    <div class="card shadow border-0 mb-4">
        <div class="card-body text-center">
            <h3 class="mb-4">
                Ticket Analytics
            </h3>
            <div style="width:400px; margin:auto;">
                <canvas id="ticketChart"></canvas>
            </div>
        </div>
    </div>
    <!-- Tickets Table -->
    <div class="card shadow border-0">
        <div class="card-body">
            <h4 class="mb-4">
                All Tickets
            </h4>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Department</th>
                            <th>Issue</th>
                            <th>Priority</th>
                            <th>Status</th>
                            <th>Attachment</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td>
                                <?= $row['id'] ?>
                            </td>
                            <td>
                                <?= $row['name'] ?>
                            </td>
                            <td>
                                <?= $row['department'] ?>
                            </td>
                            <td>
                                <?= $row['issue'] ?>
                            </td>
                            <td>
                                <?php 
                                if($row['priority'] == 'High'){
                                    echo '<span class="badge bg-danger">High</span>';
                                }elseif($row['priority'] == 'Medium'){
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
                                    No File
                                <?php endif; ?>
                            </td>
                            <!-- Action -->
                            <td>
                                <?php if($row['status'] != 'Closed'): ?>
                                    <a 
                                        href="close-ticket.php?id=<?= $row['id'] ?>"
                                        class="btn btn-success btn-sm"
                                    >
                                        Close
                                    </a>
                                <?php else: ?>
                                    Completed
                                <?php endif; ?>
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
<!-- Chart -->
<script>
const ctx = document.getElementById('ticketChart');
new Chart(ctx, {
    type: 'pie',
    data: {
        labels: ['Open Tickets', 'Closed Tickets'],
        datasets: [{
            data: [<?= $open ?>, <?= $closed ?>],
            backgroundColor: [
                '#f59e0b',
                '#16a34a'
            ]
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true
    }
});
</script>
</body>
</html>