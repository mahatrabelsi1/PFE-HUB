<?php
session_start();
require_once 'config.php'; // Ensure this contains your correct database connection setup

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize input data
    $email = isset($_POST['email']) ? $conn->real_escape_string($_POST['email']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    // Prepare SQL query to fetch user data based on email
    $sql = "SELECT email, password, role FROM user WHERE email = ?";

    // Prepare the statement with the SQL query
    $stmt = $conn->prepare($sql);

    if (!$stmt) { // Check for errors during preparation
        die("Error preparing statement: " . $conn->error);
    }

    // Bind parameters to prevent SQL injection
    $stmt->bind_param("s", $email);

    // Execute the prepared statement
    $stmt->execute();

    // Get the result set (if any)
    $result = $stmt->get_result();
        
    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();

        // Verify if the entered password matches the stored hashed password
        if ($password == $user['password']) 
        {
            // Password is correct, proceed with setting session variables
            $_SESSION['email'] = $user['email'];

            // Store role in a variable
            $role = $user['role'];

            // Redirect based on role
            if ($role === 'teacher') {
                header("Location: ../teacherpage.html");
                exit;
            } elseif ($role === 'student') {
                header("Location: studentHome.php");
                exit;
            } else {
                echo "Invalid role specified: " . $role;            }
        } else {
            // Incorrect password
            echo "Invalid password. Please try again.";
        }
    } else {
        // No user found with that email address
        echo "No user found with that email address. Please try again.";
    }

    // Always close the statement and connection
    $stmt->close();
    $conn->close();
} else {
    // Not a POST request
    echo "Invalid request method. Please use the login form.";
}
?>
