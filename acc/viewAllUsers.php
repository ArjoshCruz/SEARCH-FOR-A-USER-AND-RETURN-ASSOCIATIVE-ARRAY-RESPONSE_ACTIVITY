<?php require_once '../core/handleForms.php'?>
<?php require_once '../core/models.php'?>

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
<body >
    <?php if (isset($_SESSION['username'])) {?>
    <header>
        <h1>Teacher Application</h1>

        <div class="admin-action">
            <ul class="ul-head">
                <li class="li-head">
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
    
    <h2 style="margin-top: 30px;">ADMINS</h2>
    <table style="width:50%; margin: auto; ">
            <tr>
                <th style="text-align: center;">Admin List</th>
            </tr>

            <?php
            $getAllUsers = getAllUsers($pdo);
            foreach ($getAllUsers as $row) { ?>
            <tr>
                <td style="text-align: center;">
                    <a href="viewuser.php?user_id=<?php echo $row['user_id']; ?>&username=<?php echo $row['username']; ?>">
                    <?php echo htmlspecialchars($row['username']); ?>
                    </a>
                </td>
                
            </tr>
            <?php }?>
        </table>

</body>
</html>