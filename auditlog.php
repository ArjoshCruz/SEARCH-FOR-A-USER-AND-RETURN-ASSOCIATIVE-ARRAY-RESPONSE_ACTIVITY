<?php
    require_once 'core/dbConfig.php';
    require_once 'core/models.php';
    
    if (!isset($_SESSION['username'])) {
        header("Location: acc/login.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="styles/audit.css">

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
                    <a href="index.php">Home</a>
                </li>
                <li class="li-head">
                    <a href="acc/viewAllUsers.php" class="a-head">See Admin List</a>
                </li>
                <li class="li-head" class="a-head">
                    <a href="auditLog.php">Audit Log</a>
                </li>
                <li class="li-head" class="a-head">
                    <a href="core/handleForms.php?logoutAUser=1">Logout</a>
                    <?php } else { echo "<h1>No user Logged in</h1>";}?>
                </li>
            </ul>
        </div>
    </header>

    <h2 style="margin-top: 30px; padding-bottom: 0;">AUDIT LOGS</h2>

<section class="table-div">
        <table style="width:80%; margin:50px 20px 0; ">
            <tr>
                <th>Audit ID</th>
                <th>Username</th>
                <th>Action Made</th>
                <th>Attribute ID</th>
                <th>Details</th>
                <th>Date</th>
            </tr>

            <?php $getAllAuditLog = getAllAuditLog($pdo)?>
            <?php foreach ($getAllAuditLog as $row) {?>
            <tr>
                <td><?php echo $row['audit_id']?></td>
                <td><?php echo $row['username']?></td>
                <td><?php echo $row['action_made']?></td>
                <td><?php echo $row['attribute_id']?></td>
                <td><?php echo $row['details']?></td>
                <td><?php echo $row['date_added']?></td>

            </tr>
            <?php }?>
        </table>
    </section>
</body>
</html>