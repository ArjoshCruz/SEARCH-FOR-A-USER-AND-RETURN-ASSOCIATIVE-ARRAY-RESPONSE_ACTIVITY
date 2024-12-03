<?php 
require_once '../core/dbConfig.php';
require_once '../core/models.php';

if (!isset($_SESSION['username'])) {
    header("Location: acc/login.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pupil</title>
    <link rel="stylesheet" href="../styles/audit.css">
    <style>
        /* Header */
        header {
            background-color: #033669;
        }

        header h1 {
            color: #edde79;
            text-align: center;
            font-size: 50px;
        

            padding: 30px 0 0;
        }

        .admin-action {
            display: flex;
            justify-content: flex-end;
            padding: 20px; /* Optional: Adds spacing around the menu */
            margin: 0 20px;
        }

        .admin-action ul {
            list-style-type: none;
            padding: 0;
            display: flex;
            gap: 20px;
            margin: 0; /* Removes default margin */
        }

        .admin-action ul li a {
            text-decoration: none;
            color: #edde79; /* Yellow font color */
            font-size: 16px;
        }

        .admin-action ul li a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    
    <?php if (isset($_SESSION['username'])) {?>
    <header>
        <h1>Teacher Application</h1>

        <div class="admin-action">
            <ul class="ul-head">
                <li>
                    <a href="../index.php">Home</a>
                </li>
                <li class="li-head">
                    <a href="viewAllUsers.php" class="a-head">See Admin List</a>
                </li>
                <li class="li-head" class="a-head">
                    <a href="../auditLog.php">Audit Log</a>
                </li>
                <li class="li-head" class="a-head">
                    <a href="../core/handleForms.php?logoutAUser=1">Logout</a>
                    <?php } else { echo "<h1>No user Logged in</h1>";}?>
                </li>
            </ul>
        </div>
    </header>

    <section style="margin-top: 50px;">
        <?php $getUserByID = getUserByID($pdo, $_GET['user_id']);?>
        <h3>Username: <?php echo $getUserByID['username'];?></h3>
        <h3>Firstname: <?php echo $getUserByID['first_name'];?></h3>
        <h3>Lastname: <?php echo $getUserByID['last_name'];?></h3>
        <h3>Date Joined: <?php echo $getUserByID['date_added'];?></h3>
    </section>
</body>
</html>