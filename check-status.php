<?php 
include 'config.php';
$ticket = null;
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $stmt = mysqli_prepare($conn,
    "SELECT * FROM tickets WHERE id=?");
    mysqli_stmt_bind_param(
        $stmt,
        "i",
        $_POST['ticket_id']
    );
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $ticket = mysqli_fetch_assoc($result);
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Check Ticket Status</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="style.css">
</head>
<body>
<!-- Sidebar -->
<div class="sidebar">
    <h2>HelpDesk</h2>
    <a href="dashboard.php">Dashboard</a>
    <a href="open-ticket.php">Open Ticket</a>
    <a href="check-status.php">Check Status</a>
    <a href="logout.php">Logout</a>
</div>
<!-- Main Content -->
<div class="main">
    <div class="card p-5 shadow border-0">
        <h2 class="mb-4 text-primary">
            Check Ticket Status
        </h2>
        <form method="POST">
            <input 
                type="number" 
                name="ticket_id" 
                class="form-control mb-3" 
                placeholder="Enter Ticket ID"
                required
            >
            <button class="btn btn-primary">
                Check Status
            </button>
        </form>
        <?php if($ticket): ?>
            <div class="mt-5">
                <table class="table table-bordered table-hover">
                    <tr>
                        <th>Name</th>
                        <td><?= $ticket['name'] ?></td>
                    </tr>
                    <tr>
                        <th>Department</th>
                        <td><?= $ticket['department'] ?></td>
                    </tr>
                    <tr>
                        <th>Issue</th>
                        <td><?= $ticket['issue'] ?></td>
                    </tr>
                    <tr>
                        <th>Priority</th>
                        <td>
                            <?= $ticket['priority'] ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            <?php if($ticket['status'] == 'Open'): ?>
                                <span class="badge bg-warning">
                                    Open
                                </span>
                            <?php else: ?>
                                <span class="badge bg-success">
                                    Closed
                                </span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Attachment</th>
                        <td>
                            <?php if($ticket['attachment'] != ''): ?>
                                <a 
                                    href="<?= $ticket['attachment'] ?>" 
                                    target="_blank"
                                    class="btn btn-primary btn-sm"
                                >
                                    View File
                                </a>
                            <?php else: ?>
                                No File
                            <?php endif; ?>
                        </td>
                    </tr>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>
</body>
</html>