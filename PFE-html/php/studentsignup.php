<?php
session_start();

require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $filliere = $conn->real_escape_string($_POST['filliere']);
    $group = $conn->real_escape_string($_POST['group']);
    $skills = $conn->real_escape_string($_POST['skills']);
    $cin = $conn->real_escape_string($_SESSION['cin']);
    $name = $conn->real_escape_string($_SESSION['name']);
    $last_name = $conn->real_escape_string($_SESSION['last_name']);
    $email = $conn->real_escape_string($_SESSION['email']);
    $password = $_SESSION['password'];  // Assuming this is already hashed
    $role=$_SESSION['role'];

    // Insert into user table
    $stmt = $conn->prepare("INSERT INTO user (cin, name, last_name, email, password,role) VALUES (?, ?, ?, ?, ?,?)");
    $stmt->bind_param("ssssss", $cin, $name, $last_name, $email, $password,$role);
    if ($stmt->execute()) {
        $user_id = $conn->insert_id; // Get the ID of the newly inserted record

        // Insert into student table
        $stmt = $conn->prepare("INSERT INTO student (studentid, name, last_name, filliere, `group`, skills) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssss", $user_id, $name, $last_name, $filliere, $group, $skills);
        if ($stmt->execute()) {
            echo "<script>alert('Registration successful!'); window.location.href='../student-home.html';</script>";
            exit;
        } else {
            echo "<script>alert('Error: " . $stmt->error . "'); window.location.href='register.html';</script>";
            exit;
        }
    } else {
        echo "<script>alert('Error inserting user: " . $stmt->error . "'); window.location.href='register.html';</script>";
        exit;
    }
    $stmt->close();
    $conn->close();
} else {
    echo "<p>Required information is missing from the session. Please make sure all steps are properly followed.</p>";
}
?>
