<?php
session_start(); // Start the session at the top of the script

require_once 'config.php'; // Include the database configuration file

// Check if the form is submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {


    $name = $_SESSION['name'];
    $last_name = $_SESSION['last_name'];
    $cin = $_SESSION['cin']; // Assuming 'cin' was stored in session earlier
    $password  = $_SESSION['password'];
    $email  = $_SESSION['email'];
    $role = $_SESSION['role'];
    $nodep = $_POST['department'];
    $conn->query("INSERT INTO user (name, last_name, email, password, role, cin) VALUES ('$name', '$last_name', '$email', '$password', '$role', '$cin'  )");
    $conn->commit();
    $userId = $conn->insert_id;


    // Check if a teacher record already exists for this user
    $checkStmt = $conn->prepare("SELECT teacherid FROM teacher WHERE teacherid = ?");
    $checkStmt->bind_param("i", $userId);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();
    if ($checkResult->num_rows > 0) {
        echo "<p>A teacher record already exists for this user ID. Please check your data.</p>";
        $checkStmt->close();
        $conn->close();
        exit;
    }

    // Prepare SQL to prevent SQL injection and insert a new teacher
    $stmt = $conn->prepare("INSERT INTO teacher (teacherid, nodep, name, last_name) VALUES (?,  ?, ?, ?)");
    $stmt->bind_param("isss", $userId,  $nodep, $name, $last_name);

    // Execute and check for success
    if ($stmt->execute()) {
        echo "<p>Registered successfully!</p>";
        header("Location: ../teacherPage.html"); // Redirect to the teacher's main page
        exit;
    } else {
        echo "<p>Error: " . $stmt->error . "</p>";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "<p>Invalid request method or missing data. Please make sure all steps are properly followed.</p>";
}
?>

?>
