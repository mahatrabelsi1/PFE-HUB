<?php
require_once("config.php");

$subjectId = $_SESSION['subjectid']; 

$sql = "SELECT s.nom_sujet, s.source_sujet, s.skills_required, s.description, s.progress,
               t.name AS teacher_name, t.last_name AS teacher_last_name,
               e.nameentreprise,
               st.name AS student_name, st.last_name AS student_last_name
        FROM sujet s
        JOIN teacher t ON s.idtearesp = t.teacherid
        JOIN entreprise e ON s.identreprise = e.entrepriseid
        WHERE s.idsujet = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $subjectId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    ?>
    <div style="text-align: center; margin-top: 50px;">
        <h2><?php echo $row["nom_sujet"]; ?></h2>
        <p><strong>Subject Source:</strong> <?php echo $row["source_sujet"]; ?></p>
        <p><strong>Skills Required:</strong> <?php echo $row["skills_required"]; ?></p>
        <p><strong>Description:</strong> <?php echo $row["description"]; ?></p>
        <p><strong>Progress:</strong> <?php echo $row["progress"]; ?></p>
        <p><strong>Teacher:</strong> <?php echo $row["teacher_name"] . " " . $row["teacher_last_name"]; ?></p>
        <p><strong>Company:</strong> <?php echo $row["nameentreprise"]; ?></p>
        <p><strong>Student:</strong> <?php echo $row["student_name"] . " " . $row["student_last_name"]; ?></p>
    </div>
    <?php
} else {
    echo "No subject found with the provided ID.";
}

$stmt->close();
$conn->close();
?>