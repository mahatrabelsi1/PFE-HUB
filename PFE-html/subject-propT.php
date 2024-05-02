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
          <img src="images/logo.png" style="height:80px;width: 150px;" id="logo">
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav  ">
              <li class="nav-item ">
                <a class="nav-link" href="index.html">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="about.html"> About </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="service.html">Services</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="team.html">Team</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="teacherPage.html"><i class="fa fa-user" aria-hidden="true"></i> User</a>
              </li>
            </ul>
          </div>
        </nav>
      </div>
    </header>
  </div>

  <div class="about_section layout_padding" style="color: white;">
    <h1 style="text-align: center;">LIST OF ALL SUBJECTS</h1>
    <br>
    <!-- PHP Code to Fetch Subjects and Display in Table with Radio Buttons -->
    <?php
    require_once("php/config.php");

    $sql = "SELECT source_sujet, nom_sujet, skills_required FROM sujet ";
    $result = $conn->query($sql);

    echo '<form action="subject.php" method="post">';
    if ($result->num_rows > 0) {
        echo "<table border='1' class='table' style='color: white;'>";
        echo "<tr><th>Select</th><th>Name</th><th>Source</th><th>Skills</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo '<td><input type="radio" name="selected_subject" value="' . htmlspecialchars($row["nom_sujet"]) . '">' . '</td>';
            echo "<td>" . htmlspecialchars($row["nom_sujet"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["source_sujet"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["skills_required"]) . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        echo '<button type="submit" class="btn btn-primary">Submit</button>';
    } else {
        echo "<p style='text-align: center;'>No subjects found.</p>";
    }
    echo '</form>';
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
