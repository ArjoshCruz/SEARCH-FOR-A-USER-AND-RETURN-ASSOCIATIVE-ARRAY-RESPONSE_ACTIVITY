<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'dbConfig.php';
require_once 'models.php';
require_once 'validate.php';

// Insert to Database
if (isset($_POST['insertNewTeacherBtn'])) {
    $created_by = $_SESSION['username'];
    $user_id = $_SESSION['user_id'];

    $first_name = sanitizeInput($_POST['firstName']);
    $last_name = sanitizeInput($_POST['lastName']);
    $age = sanitizeInput($_POST['age']);
    $gender = sanitizeInput($_POST['gender']);
    $email = sanitizeInput($_POST['email']);
    $yrsOfExperience = sanitizeInput($_POST['yrsOfExperience']);
    $position = sanitizeInput($_POST['position']);
    $subjectSpecialization = sanitizeInput($_POST['subjectSpecialization']);

    $response = insertIntoTeacherRecords($pdo, $first_name, $last_name, $age, $gender, $email, $yrsOfExperience, $position, $subjectSpecialization, $created_by, $user_id);
    $_SESSION['message'] = $response['message'];
    $_SESSION['statusCode'] = $response['statusCode'];

    header("Location: ../index.php");
}

// Edit
if (isset($_POST['editNewTeacherBtn'])) {
    $updated_by = $_SESSION['username'];
    $user_id = $_SESSION['user_id'];

    $teacher_id = $_GET['teacher_id'];
    $first_name = sanitizeInput($_POST['firstName']);
    $last_name = sanitizeInput($_POST['lastName']);
    $age = sanitizeInput($_POST['age']);
    $gender = sanitizeInput($_POST['gender']);
    $email = sanitizeInput($_POST['email']);
    $yrsOfExperience = sanitizeInput($_POST['yrsOfExperience']);
    $position = sanitizeInput($_POST['position']);
    $subjectSpecialization = sanitizeInput($_POST['subjectSpecialization']);

    $response = editTeacher($pdo, $first_name, $last_name, $age, $gender, $email, $yrsOfExperience, $position, $subjectSpecialization, $teacher_id , $updated_by, $user_id);
    $_SESSION['message'] = $response['message'];
    $_SESSION['statusCode'] = $response['statusCode'];

    header("Location: ../index.php");
}

// Delete
if (isset($_POST['deleteTeacherBtn'])) {
    $deleted_by = $_SESSION['username'];
    $user_id = $_SESSION['user_id'];

    $teacher_id = $_GET['teacher_id'];

    $response = deleteTeacher($pdo, $teacher_id, $deleted_by);
    $_SESSION['message'] = $response['message'];
    $_SESSION['statusCode'] = $response['statusCode'];

    header("Location: ../index.php");
}

// Register Button
if (isset($_POST['registerUserBtn'])) {
    $username = sanitizeInput($_POST['username']);
    $firstName = sanitizeInput($_POST['first_name']);
    $lastName = sanitizeInput($_POST['last_name']);
    $password = sanitizeInput($_POST['password']);

    $confirm_password = sanitizeInput($_POST['confirm_password']);

    if (!empty($username) && !empty($password) && !empty($confirm_password)) {
        
        if ($password == $confirm_password) {

			if (validatePassword($password)) {

				$insertQuery = insertNewUser($pdo, $username, $firstName, $lastName, sha1($password));

				if ($insertQuery) {
					header("Location: ../acc/login.php");
				}
				else {
					header("Location: ../acc/register.php");
				}
			}

			else {
				$_SESSION['message'] = "Password should be more than 8 characters and should contain both uppercase, lowercase, and numbers";
				header("Location: ../acc/register.php");
			}
		}

		else {
			$_SESSION['message'] = "Please check if both passwords are equal!";
			header("Location: ../acc/register.php");
		}
    } else {
        $_SESSION['message'] = "Please make sure the input fields are not empty for registration!";
        header("Location: ../acc/login.php");
    }
}

if (isset($_POST['loginUserBtn'])) {
    $username = sanitizeInput($_POST['username']);
    $password = sha1($_POST['password']); 

    if (!empty($username) && !empty($password)) {
        // Call loginUser function to handle login verification
        $loginQuery = loginUser($pdo, $username, $password);

        if ($loginQuery) {
            header("Location: ../index.php");
            exit;
        } else {
            $_SESSION['message'] = "Username/password invalid";
            header("Location: ../acc/login.php");
            exit;
        }
    } else {
        $_SESSION['message'] = "Please make sure the input fields are not empty for the login!";
        header("Location: ../acc/login.php");
        exit;
    }
}

if (isset($_GET['logoutAUser'])) {
    unset($_SESSION['username']);
    header("Location: ../acc/login.php");
}
?>