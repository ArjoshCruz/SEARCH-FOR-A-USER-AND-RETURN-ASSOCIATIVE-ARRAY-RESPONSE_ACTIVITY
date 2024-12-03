<?php require_once '../core/models.php'?>
<?php require_once '../core/handleForms.php'?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Title</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../styles/login.css">

<body>

    <header>
        <h1>Teacher Application</h1>
    </header>

    <h2><strong>LOGIN</strong></h2>

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
                    <i class="fas fa-lock"></i>
                    <input type="password" placeholder="Password" name="password" required>
                </div>
            </p>
            <p class="btn">
                <input class="submit-btn" type="submit" value="Login" name="loginUserBtn">
            </p>
        </form>
        <p>Don't have an account? You may register <a href="register.php">here</a></p>
    </section>

    <?php if (isset($_SESSION['message'])) { ?>
    <h1 style="color: red;"><?php echo $_SESSION['message']?></h1>
    <?php }?>
    <?php unset($_SESSION['message']);?>
</body>
</html>