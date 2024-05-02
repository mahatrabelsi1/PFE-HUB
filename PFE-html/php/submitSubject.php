<?php
session_start();

require_once 'config.php'; // Your database configuration file

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize input data
    $subjectName = $conn->real_escape_string($_POST['subject']);
    $description = $conn->real_escape_string($_POST['description']);
    $skillsRequired = $conn->real_escape_string($_POST['skills_required']);

    // Prepare the SQL query
    $sql = "INSERT INTO sujet(source_sujet, nom_sujet, skills_required, description, status) VALUES (?, ?, ?, ?, ?)";

    // Prepare statement
    if ($stmt = $conn->prepare($sql)) {
        $status = 'liber';  // Set the default status
        $source_sujet = 'teacher'; // Set the source as 'teacher'
        
        // Bind parameters and execute
        $stmt->bind_param("sssss", $source_sujet, $subjectName, $skillsRequired, $description, $status);
        if ($stmt->execute()) {
            // Using JavaScript for redirect after the alert
            echo "<script type='text/javascript'>
                    alert('Subject added successfully!');
                    window.location.href = '../teacherPage.html'; // Redirect to the teacher's home page
                  </script>";
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }
    $conn->close();
} else {
    // Not a POST request
    echo "Invalid request.";
}
?>
