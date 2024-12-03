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
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles/styles.css">

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

            <h2 style="padding: 10px 16px 0; color: #edde79;">User: <span style="color: white;"><?php echo $_SESSION['username'];?></span> </h2>
            <div class="admin-action">
                <ul>
                    <li>
                        <a href="index.php">Home</a>
                    </li>
                    <li>
                        <a href="acc/viewAllUsers.php">See Admin List</a>
                    </li>
                    <li>
                        <a href="auditLog.php">Audit Log</a>
                    </li>
                    <li>
                        <a href="core/handleForms.php?logoutAUser=1">Logout</a>
                        <?php } else { echo "<h1>No user Logged in</h1>";}?>
                    </li>
                </ul>
            </div>
        </header>
        
        

        <!-- Create New Teacher -->

        <h2 style="text-align: center; font-size: 40px; padding: 24px 0;">Add a Teacher</h2>

        <div class="form-div">
            <form class="application-form" action="core/handleForms.php" method="post">
                <h2>Personal Information</h2>

                <p>
                    <label for="firstName">First Name:  </label>
                    <input class="text" type="text" name="firstName" placeholder="e.g. Juan" required>
                </p>

                <p>        
                    <label for="lastName">Last Name:  </label>
                    <input class="text" type="text" name="lastName" placeholder="e.g. Delacruz" required>
                </p>


                <p>
                    <label for="age">Age:  </label>
                    <input class="number" type="number" name="age" placeholder="e.g. 18" required>
                </p>

                <p>
                    <label for="gender">Gender:  </label>
                    <select name="gender">
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Prefer Not to Say">Prefer Not to Say</option>
                    </select>
                </p>

                <p>
                    <label for="email">Email:  </label>
                    <input class="email" type="email" name="email" placeholder="e.g., j.delacruz@gmail.com" required>
                </p>
                
                <h2>Career Information</h2>
                <p>
                    <label for="yrsOfExperience">Years of Experience:  </label>
                    <input class="number" type="number" name="yrsOfExperience" placeholder="e.g. 5" required>
                </p>
                        
                <p>        
                    <label for="position">Position:  </label>
                    <input class="text" type="text" name="position" placeholder="e.g. Principal" required>
                </p>

                <p>        
                    <label for="subjectSpecialization">Subject Specialization:  </label>
                    <input class="text" type="text" name="subjectSpecialization" placeholder="e.g. Mathematics" required>
                </p>

                <br>

                <p class="form-btn">
                    <input class="submit-form" type="submit" name="insertNewTeacherBtn" value="Submit">
                    <button class="clear-form" type="reset">Clear</button>
                </p>
            </form>
        </div>

    <!-- Status -->
        <?php if (isset($_SESSION['message']) && isset($_SESSION['statusCode'])) { ?>

            <?php
                if (isset($_SESSION['statusCode']) == "Status Code: 200") { ?>

                <h2 style="padding: 20px; border-radius: 8px; margin: 20px 0; font-size: 16px; text-align: center; font-weight: bold; border: 2px solid green; background-color: transparent; color: green;">
                    <?php echo $_SESSION['message']; echo $_SESSION['statusCode'];?>
                </h2>
            <?php } else {?>
                <h2 style="padding: 20px; border-radius: 8px; margin: 20px 0; font-size: 16px; text-align: center; font-weight: bold; border: 2px solid red; background-color: transparent; color: red;">
                    <?php echo $_SESSION['message']; echo $_SESSION['statusCode'];?>
                </h2>
            <?php }
                unset($_SESSION['message'], $_SESSION['statusCode']);
            ?>
        <?php } ?>

        <hr>

        <form class="search-form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="GET">
            <h3>Search: </h3>
            <div class="search-bar-container">
                <span class="search-icon"><i class="fa fa-search"></i></span>
                <input class="search-bar" type="text" name="searchInput" placeholder="Search here" 
                    value="<?php echo isset($_GET['searchInput']) ? htmlspecialchars($_GET['searchInput']) : ''; ?>">
                <span class="clear-icon" onclick="document.querySelector('.search-bar').value = '';"><i class="fa fa-times"></i></span>
            </div>
            <input type="submit" name="searchBtn" value="Search">
            <input type="button" onclick="window.location.href='<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>'" value="Clear">
        </form>
        

        <!-- Table -->
        <div class="table-div">
            <table>
                <tr>
                    <th>Teacher ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Age</th>
                    <th>Gender</th>
                    <th>Email</th>
                    <th>Years of Experience</th>
                    <th>Position</th>
                    <th>Subject Specialization</th>
                    <th>Created By</th>
                    <th>Date Added</th>
                    <th>Action</th>
                    <th>Updated By</th>
                    <th>Date Updated</th>
                </tr>

                <?php
                if (isset($_GET['searchBtn']) && !empty($_GET['searchInput'])) {
                    // Prints out search result
                    $seeAllTeacher = searchForATeacher($pdo, $_GET['searchInput'], $_SESSION['username']);
                    if (empty($seeAllTeacher)) {
                        echo "<tr><td colspan='24' class='no-results'>No results found.</td></tr>";
                    }
                } else {
                    // Prints out all of Teacher's Data
                    $seeAllTeacher = getAllTeacher($pdo);
                }
                ?>
                <?php foreach ($seeAllTeacher as $row) {?>

                <tr>
                    <td><?php echo $row['teacher_id']; ?></td>
                    <td><?php echo $row['first_name']; ?></td>
                    <td><?php echo $row['last_name']; ?></td>
                    <td><?php echo $row['age']; ?></td>
                    <td><?php echo $row['gender']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['yrs_of_experience']; ?></td>
                    <td><?php echo $row['position']; ?></td>
                    <td><?php echo $row['subject_specialization']; ?></td>
                    <td><?php echo $row['created_by']?></td>

                        <td><?php echo $row['date_added']?></td>
                        <td>
                            <a class="edit" href="actions/editTeacher.php?teacher_id=<?php echo $row['teacher_id'];?>">Edit</a>
                            <a class="delete" href="actions/deleteTeacher.php?teacher_id=<?php echo $row['teacher_id'];?>">Delete</a>
                        </td>

                    <td><?php echo $row['updated_by']?></td>

                    <td><?php echo $row['date_updated']?></td>  
                </tr>
                <?php }?>
            </table>
        </div>

</body>
</html>