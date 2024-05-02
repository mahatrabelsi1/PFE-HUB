<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="keywords" content="" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <link rel="shortcut icon" href="images/logo.png" type="">
  <title>PFE-HUB</title>
  <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
  <link href="css/font-awesome.min.css" rel="stylesheet" />
  <link href="css/style.css" rel="stylesheet" />
</head>
<body class="sub_page">
  <div class="hero_area">
    <header class="header_section">
      <div class="container-fluid">
        <nav class="navbar navbar-expand-lg custom_nav-container ">
          <a class="navbar-brand" href="#"><img src="images/logo.png" alt="logo" style="height:80px;width: 150px;"></a>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav  ">
              <li class="nav-item ">
                <a class="nav-link" href="index.html">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="about.html">About</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="service.html">Services</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="team.html">Team</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="account.html"><i class="fa fa-user" aria-hidden="true"></i> User</a>
              </li>
            </ul>
          </div>
        </nav>
      </div>
    </header>
  </div>

  <div class="about_section layout_padding" style="color: white;">
    <h1 style="text-align: center;">THE SUBJECT</h1>
    <br>
    <!-- PHP Code to Fetch Subjects and Display in Table -->
    <?php
    require_once("php/config.php");
    session_start();
    
    if (isset($_POST['selected_subject']) && !empty($_POST['selected_subject'])) {
      $subjectName = $_POST['selected_subject'];

        $sql = "SELECT s.nom_sujet, s.source_sujet, s.skills_required, s.description, s.progress
            FROM sujet s
        
            WHERE s.nom_sujet = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $subjectName); // Change "i" to "s" if $subjectName is a string
        $stmt->execute();
        
        $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                echo "<div style='text-align: center; margin-top: 50px;'>";
                echo "<h2>" . htmlspecialchars($row["nom_sujet"]) . "</h2>";
                echo "<p><strong>Subject Source:</strong> " . htmlspecialchars($row["source_sujet"]) . "</p>";
                echo "<p><strong>Skills Required:</strong> " . htmlspecialchars($row["skills_required"]) . "</p>";
                echo "<p><strong>Description:</strong> " . htmlspecialchars($row["description"]) . "</p>";
                echo "<p><strong>Progress:</strong> " . htmlspecialchars($row["progress"]) . "</p>";
                echo "</div>";
            } else {
                echo "<p>No subject found with the provided ID.</p>";
            }
            $stmt->close();
    } else {
        echo "<p>Subject ID not set in session.</p>";
    }
    $conn->close();
    ?>
  </div>

  <section class="info_section ">
    <div class="container">
      <!-- Additional Content -->
    </div>
  </section>
</body>
</html>
