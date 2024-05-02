<?php
require_once("config.php"); 

$sql = "SELECT source_sujet, nom_sujet, skills_required FROM sujet WHERE status = 'available' AND valide=0";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Start the table before the loop
    echo "<table border='1'>";
    echo "<tr><th>Name</th><th>Source</th><th>Skills</th></tr>";

    while ($row = $result->fetch_assoc()) {
        // Output each row
        echo "<tr><td>" . htmlspecialchars($row["nom_sujet"]) . "</td><td>" . htmlspecialchars($row["source_sujet"]) . "</td><td>" . htmlspecialchars($row["skills_required"]) . "</td></tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}

$conn->close();
?>
