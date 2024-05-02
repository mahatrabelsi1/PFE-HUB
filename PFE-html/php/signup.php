<?php
session_start();

require_once 'config.php'; // Ensure this points to a real config file

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Sanitize and prepare user input
    $name = $conn->real_escape_string($_POST['name']);
    $last_name = $conn->real_escape_string($_POST['last_name']);
    $email = $conn->real_escape_string($_POST['email']);
    $cin = $conn->real_escape_string($_POST['cin']); // Assuming 'cin' is needed for the teacher table
    $password = $_POST['password']; // Get raw password directly from the form
    $role = $conn->real_escape_string($_POST['Role']);

    // Check if the email already exists
    $emailCheckStmt = $conn->prepare("SELECT email FROM user WHERE email = ?");
    $emailCheckStmt->bind_param("s", $email);
    $emailCheckStmt->execute();
    $emailCheckResult = $emailCheckStmt->get_result();
    if ($emailCheckResult->num_rows > 0) {
        echo "This email address is already registered. Please use a different email.";
        $emailCheckStmt->close();
        $conn->close();
        exit;
    }

    // Insert user into the database without hashing the password
    //$insertUserStmt = $conn->prepare("INSERT INTO user (name, last_name, email, password, role, cin) VALUES (?, ?, ?, ?, ?, ?)");
    //$insertUserStmt->bind_param("ssssss", $name, $last_name, $email, $password, $role, $cin);

    $_SESSION['name'] = $name;
    $_SESSION['last_name'] = $last_name;
    $_SESSION['email']  = $email;
    $_SESSION['password'] = $password;
    $_SESSION['cin'] = $cin;
    $_SESSION['role'] = $role;

    switch ($role) {
        case 'teacher':
            header('Location: ../sign-up-teacher.html'); // Redirect to further registration or a specific page
            break;
        case 'student':
            header('Location: ../sign-up-student.html');
            break;
        case 'administration-employee':
            header('Location: ../sign-up-administration.html');
            break;
        case 'enterprise-representative':
            header('Location: ../sign-up-entreprise.html');
            break;
        default:
            echo "Invalid role specified.";
            break;
    }
    exit;

    

    $conn->close();
} else {
    echo "<p>Please fill out the form completely.</p>";
}
?>
