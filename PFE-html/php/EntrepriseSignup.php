<?php
session_start(); 

require_once 'config.php'; 


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit']) && isset($_SESSION['name'], $_SESSION['last_name'], $_SESSION['email'], $_SESSION['password'])) {

    $desc = $conn->real_escape_string($_POST['description']);
    $name_entreprise = $conn->real_escape_string($_POST['nom_entreprise']);
    $cin = $conn->real_escape_string($_SESSION['cin']);
    $name = $conn->real_escape_string($_SESSION['name']);
    $last_name = $conn->real_escape_string($_SESSION['last_name']);
    $email = $conn->real_escape_string($_SESSION['email']);
    $password = $_SESSION['password']; 
    $hashed_password = $password; 


    $stmt = $conn->prepare("INSERT INTO user (name,lastname,email,password) VALUES (?,?,?,?)");
    $stmt->bind_param("ssss", $name,$last_name,$email,$hashed_password);
    $stmt->execute();

    $stmt = $conn->prepare("SELECT user_id 
                            FROM user
                            WHERE name= ?, lastname=?,password=?,email=?");
    $stmt->bind_param("ssss", $name,$last_name,$hashed_password,$email);    
    $stmt->execute();
    $result = $stmt->get_result();
    $id = $result->fetch_assoc();
    

    $stmt = $conn->prepare("INSERT INTO entreprise (entrepriseid,nameentreprise,description) VALUES (?, ?, ?)");
    $stmt->bind_param("iss",$id, $name_entreprise,$desc);

    if ($stmt->execute()) 
    {
        echo "<p>Registered successfully!</p>";
    } 
    else 
    {
        echo "<p>Error: " . $stmt->error . "</p>";
    }

    $stmt->close();
    $conn->close();
} 
else 
{
    echo "<p>Required information is missing from the session. Please make sure all steps are properly followed.</p>";
}
?>
