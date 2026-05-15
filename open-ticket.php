<?php 
include 'config.php';
$msg='';
/* Check User Login */
if(!isset($_SESSION['user'])){
    header('Location: user-login.php');
    exit;
}
if($_SERVER['REQUEST_METHOD']=='POST'){
    /* Default Attachment Path */
    $target = '';
    /* File Upload Logic */
    if(isset($_FILES['attachment']) && $_FILES['attachment']['name'] != ''){
        if(!is_dir('uploads')){
            mkdir('uploads');
        }
        $filename = time() . "_" . basename($_FILES['attachment']['name']);
        $target = "uploads/" . $filename;
        move_uploaded_file($_FILES['attachment']['tmp_name'], $target);
    }
    /* Insert Ticket */
    $stmt = mysqli_prepare($conn,
    "INSERT INTO tickets(name,department,email,issue,priority,attachment) VALUES(?,?,?,?,?,?)");
    mysqli_stmt_bind_param(
        $stmt,
        "ssssss",
        $_POST['name'],
        $_POST['department'],
        $_SESSION['user'],
        $_POST['issue'],
        $_POST['priority'],
        $target
    );
    mysqli_stmt_execute($stmt);
    $ticket_id = mysqli_insert_id($conn);
    $msg = "Ticket Created Successfully. Your Ticket ID is: " . $ticket_id;
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Open Ticket</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="style.css">
</head>
<body>
<!-- Sidebar -->
<div class="sidebar">
    <h2 class="mb-4">
        <i class="fa-solid fa-screwdriver-wrench"></i>
        HelpDesk
    </h2>
    <a href="user-dashboard.php">
        <i class="fa-solid fa-table"></i>
        My Tickets
    </a>
    <a href="open-ticket.php">
        <i class="fa-solid fa-ticket"></i>
        Open Ticket
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
    <div class="card p-5 shadow border-0">
        <h2 class="mb-4 text-primary">
            <i class="fa-solid fa-ticket"></i>
            Open Ticket
        </h2>
        <!-- Success Message -->
        <?php if($msg): ?>
            <div class="alert alert-success">
                <?= $msg ?>
            </div>
        <?php endif; ?>
        <!-- Form -->
        <form method="POST" enctype="multipart/form-data">
            <!-- Name -->
            <input 
                type="text" 
                name="name" 
                class="form-control mb-3" 
                placeholder="Enter Name" 
                required
            >
            <!-- Department -->
            <input 
                type="text" 
                name="department" 
                class="form-control mb-3" 
                placeholder="Enter Department" 
                required
            >
            <!-- Issue -->
            <textarea 
                name="issue" 
                class="form-control mb-3" 
                placeholder="Describe the Issue"
                rows="5"
                required
            ></textarea>
            <!-- Priority -->
            <select name="priority" class="form-select mb-3">
                <option value="Low">
                    🟢 Low
                </option>
                <option value="Medium">
                    🟠 Medium
                </option>
                <option value="High">
                    🔴 High
                </option>
            </select>
            <!-- File Upload -->
            <input 
                type="file" 
                name="attachment" 
                class="form-control mb-3"
                accept=".jpg,.jpeg,.png,.pdf,.doc,.docx"
            >
            <!-- Submit -->
            <button class="btn btn-primary w-100">
                Submit Ticket
            </button>
        </form>
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