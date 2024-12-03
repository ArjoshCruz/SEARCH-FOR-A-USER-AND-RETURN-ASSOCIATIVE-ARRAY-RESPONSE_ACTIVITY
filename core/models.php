<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Fetching Data
function getAllTeacher($pdo): mixed {
    $sql = "SELECT * FROM teacher_records";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute();

    if ($executeQuery) {
        return $stmt->fetchAll();
    }
}

function getTeacherByID($pdo, $teacher_id) {
    $sql = "SELECT * FROM teacher_records
            WHERE teacher_id = ?";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$teacher_id]);

    if ($executeQuery) {
        return $stmt->fetch();
    }
}

// Insert to Database
function insertIntoTeacherRecords($pdo, $first_name, $last_name, $age, $gender, $email, $yrs_of_experience, $position, $subject_specialization, $created_by, $user_id) {
    $sql = "INSERT INTO teacher_records (first_name, last_name, age, gender, email, yrs_of_experience, position, subject_specialization, created_by, user_id) 
            VALUES (?,?,?,?,?,?,?,?,?,?)";
    $stmt = $pdo->prepare($sql);

    try {
        $executeQuery = $stmt->execute([$first_name, $last_name, $age, $gender, $email, $yrs_of_experience, $position, $subject_specialization, $created_by, $user_id]);

        if ($executeQuery) {
            $attribute_id = $pdo->lastInsertId(); // Get the inserted record's ID
            insertAuditLog($pdo, $created_by, 'Insert', $attribute_id, 'Inserted in Teacher Records Table'); // Call audit log
            return ["message" => "Teacher added successfully.", "statusCode" => 200];
        } else {
            return ["message" => "Failed to add teacher.", "statusCode" => 400];
        }
    } catch (Exception $e) {
        return ["message" => "Error: " . $e->getMessage(), "statusCode" => 500];
    }
}


// Edit
function editTeacher($pdo, $first_name, $last_name, $age, $gender, $email, $yrs_of_experience, $position, $subject_specialization, $teacher_id, $updated_by) {
    $sql = "UPDATE teacher_records
            SET first_name = ?,
                last_name = ?,
                age = ?,
                gender = ?,
                email = ?,
                yrs_of_experience = ?,
                position = ?,
                subject_specialization = ?,
                updated_by = ?
            WHERE teacher_id = ?";
    $stmt = $pdo->prepare($sql);

    try {
        $executeQuery = $stmt->execute([$first_name, $last_name, $age, $gender, $email, $yrs_of_experience, $position, $subject_specialization, $updated_by, $teacher_id]);

        if ($executeQuery) {
            insertAuditLog($pdo, $updated_by, 'Update', $teacher_id, 'Updated in Teacher Records Table');
            return ["message" => "Teacher updated successfully.", "statusCode" => 200];
        } else {
            return ["message" => "Failed to update teacher.", "statusCode" => 400];
        }
    } catch (Exception $e) {
        return ["message" => "Error: " . $e->getMessage(), "statusCode" => 500];
    }
}

// Delete
function deleteTeacher($pdo, $teacher_id, $deleted_by) {
    $sql = "DELETE FROM teacher_records WHERE teacher_id = ?";
    $stmt = $pdo->prepare($sql);

    try {
        $executeQuery = $stmt->execute([$teacher_id]);

        if ($executeQuery) {
            insertAuditLog($pdo, $deleted_by, 'Delete', $teacher_id, 'Deleted from Teacher Records Table');
            return ["message" => "Teacher deleted successfully.", "statusCode" => 200];
        } else {
            return ["message" => "Failed to delete teacher.", "statusCode" => 400];
        }
    } catch (Exception $e) {
        return ["message" => "Error: " . $e->getMessage(), "statusCode" => 500];
    }
}



// Search
function searchForATeacher($pdo, $searchQuery, $searched_by) {
    $sql = "SELECT * FROM teacher_records
            WHERE 
                first_name LIKE ? OR 
                last_name LIKE ? OR 
                age LIKE ? OR 
                gender LIKE ? OR 
                email LIKE ? OR 
                yrs_of_experience LIKE ? OR 
                position LIKE ? OR 
                subject_specialization LIKE ?";
    
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([
        "%$searchQuery%", "%$searchQuery%", "%$searchQuery%", "%$searchQuery%",
        "%$searchQuery%", "%$searchQuery%", "%$searchQuery%", "%$searchQuery%"
    ]);
    
    if ($executeQuery) {
        // Log the search action in the audit log
        insertAuditLog($pdo, $searched_by, 'Search', 0, 'Searched for "' . $searchQuery . '" in Teacher Records Table');
        
        return $stmt->fetchAll(); // Return search results
    }
    return []; // Return an empty array if no results found
}


// Insert new user acc
function insertNewUser($pdo, $username, $first_name, $last_name, $password) {
    $checkUserSql = "SELECT * FROM user_acc
                    WHERE username = ?";
    $checkUserSqlStmt = $pdo->prepare($checkUserSql);
    $checkUserSqlStmt->execute([$username]);

    if ($checkUserSqlStmt->rowCount() == 0) {
        $sql = "INSERT INTO user_acc (username, first_name, last_name, password) VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $executeQuery = $stmt->execute([$username, $first_name, $last_name, $password]);

        if ($executeQuery) {
            $_SESSION['message'] = "User Successfully Inserted";
            return true;
        } else {
            $_SESSION['message'] = "An error occurred from the query"; 
        }
    } else {
        $_SESSION['message'] = "User already exists"; 
    }
}

// Login User
function loginUser($pdo, $username, $password) {
    $sql = "SELECT * FROM user_acc WHERE username = ?";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$username]);

    if ($executeQuery) {
        $userInfoRow = $stmt->fetch();
        $usernameFromDB = $userInfoRow['username'];
        $passwordFromDB = $userInfoRow['password'];

        if ($password == $passwordFromDB) {
            $_SESSION['username'] = $usernameFromDB;
            $_SESSION['message'] = "Login is successful";
            return true;
        }
    }
}

function getAllUsers($pdo) {
    $sql = "SELECT * FROM user_acc";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute();

    if ($executeQuery) {
        return $stmt->fetchAll();
    }
}

function getUserByID($pdo, $user_id) {
    $sql = "SELECT * FROM user_acc
            WHERE user_id = ?";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$user_id]);
    if ($executeQuery) {
        return $stmt->fetch();
    }
}

// Audit Log
function insertAuditLog($pdo, $username, $action_made, $attribute_id, $details)
{
  $sql = "INSERT INTO audit_log (username, action_made, attribute_id, details) VALUES (?, ?, ?, ?)";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$username, $action_made, $attribute_id, $details]);
}

function getAllAuditLog($pdo)
{
  $sql = "SELECT * FROM audit_log";
  $stmt = $pdo->prepare($sql);
  $executeQuery = $stmt->execute();

  if ($executeQuery) {
    return $stmt->fetchAll();
  }

}
?>