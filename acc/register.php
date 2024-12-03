<?php 
    require_once '../core/models.php';
    require_once '../core/dbConfig.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Title</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../styles/login.css">
</head>
<body>
    
    <header>
        <h1>Teacher Application</h1>
    </header>

    <h2><strong>REGISTER</strong></h2>

    <section class="form-div">
        
        <form action="../core/handleForms.php" method="POST">
            <p>
                <div class="input-container">
                    <i class="fas fa-user"></i>
                    <input type="text" placeholder="Username" name="username" required>
                </div>
            </p>
            <p>
                <div class="input-container">
                    <i class="fas fa-user"></i>
                    <input type="text" placeholder="First Name" name="first_name" required>
                </div>
            </p>
            <p>
                <div class="input-container">
                    <i class="fas fa-user"></i>
                    <input type="text" placeholder="Last Name" name="last_name" required>
                </div>
            </p>
            <p>
                <div class="input-container">
                    <i class="fas fa-lock"></i>
                    <input type="password" placeholder="Password" name="password" required>
                </div>
            </p>
            <p>
                <div class="input-container">
                    <i class="fas fa-lock"></i>
                    <input type="password" placeholder="Confirm Password" name="confirm_password">
                </div>
            </p>
            <p class="btn">
                <input class="submit-btn" type="submit" name="registerUserBtn" value="Register">
            </p>
        </form>
        <p>Already have an account? You may login <a href="login.php">here</a></p>
    </section>
    
    <?php if (isset($_SESSION['message'])) { ?>
    <h1 style="color: red;"><?php echo $_SESSION['message']?></h1>
    <?php }?>
    <?php unset($_SESSION['message']);?>
</body>
</html>