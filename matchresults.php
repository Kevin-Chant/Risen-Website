<!DOCTYPE html>
<html lang="en">

<head>
      <!-- Meta Data -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Tab Information -->
    <title>Risen eSports</title>
    <link rel='shortcut icon' type='image/x-icon' href='favicon.ico' />

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>


    <!-- Custom styles for this page -->
    <link rel="stylesheet" href="stylesheet.css">


</head>

<body onload="displayWeek(event, 1, 'Rampage');">
<!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
    <div class="container">
        <a class="navbar-brand js-scroll-trigger" href="http://www.risenesports.org/">Risen eSports</a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">

          <ul class="navbar-nav ml-auto">
              <li class="nav-item">
            <a class="nav-link" href="http://www.risenesports.org/search.php">Statistics</a>
              </li>
          </ul>
          <ul class="navbar-nav ml-auto">
              <li class="nav-item">
            <a class="nav-link" href="http://www.risenesports.org/news.php">News</a>
              </li>
          </ul>
          <ul class="navbar-nav ml-auto">
              <li class="nav-item">
            <a class="nav-link" href="http://www.risenesports.org/leagues.php">League Information</a>
              </li>
          </ul>
          <ul class="navbar-nav ml-auto">
              <li class="nav-item">
            <a class="nav-link" href="http://www.risenesports.org/admincontact.php">Admin & Contact Information</a>
              </li>
          </ul>
        </div>
    </div>
  </nav>

    <!-- Banner -->
    <div class="masthead"></div>





<h1>Risen Regular Season Match Results</h1>

<div>
  <?php

  // Create connection to SQL server
  $servername="localhost";
  $username="root";
  $password="";
  $dbname="sys";
  $conn= new mysqli($servername, $username, $password, $dbname);
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
  
  // Loop to get data for each league
    $leagues = [0 => "Rampage", 1 => "Dominate", 2 => "Alumnus", 3 => "Champions"];
    $teams = "SELECT * FROM teams";
    $result = $conn->query($teams);
    $team_records = [];
    if (isset($result) and $result->num_rows > 0) {
      while($row=$result->fetch_assoc()) {
        // Initialize empty array for season if this is first team from that season
        if (!array_key_exists($row["season"], $team_records)) {
          $team_records[$row["season"]] = [];
        }
        $team_records[$row["season"]][$row["teamAbbrv"]] = ["wins" => $row["numWins"], "losses" => $row["numLosses"]];
      }
    }
    foreach (array_keys($team_records) as $season) {
      foreach ($leagues as $league) {
        echo "<table id='season $season $league data table' style='display:none'>";
        for ($week = 1; $week < 10; $week++) {
          echo "<tr>";
          // Query to get all info in proper order
          $sql = "SELECT * FROM matchhistory WHERE League = '".$league."' AND Week = ". $week." AND Season = ".$season;
          $result = $conn->query($sql);
          if (isset($result) and $result->num_rows > 0) {
              // output data of each row
              while($row = $result->fetch_assoc()) {
                  echo "<td>";
                  echo implode(",",array_slice($row, 2));
                  echo ",".implode(",",$team_records[$season][$row["Team1"]]).",".implode(",",$team_records[$season][$row["Team2"]]);
                  echo "</td>";
              }
          }
          echo "</tr>\n";
        }



        echo "</table>\n";
      }
    }
  ?>
</div>

<div>
  League:
  <select id="league" onchange="displayWeek(event, null, this.options[this.selectedIndex].value);">
    <option value="Rampage">Rampage</option>
    <option value="Dominate">Dominate</option>
    <option value="Alumnus">Alumnus</option>
    <option value="Champions">Champions</option>
  </select>
</div>

<div class="tab">
  <button class="week-prefix">Week</button>
  <button class="tablinks" id=1 onclick="displayWeek(event, 1, null);">1</button>
  <button class="tablinks" id=2 onclick="displayWeek(event, 2, null);">2</button>
  <button class="tablinks" id=3 onclick="displayWeek(event, 3, null);">3</button>
  <button class="tablinks" id=4 onclick="displayWeek(event, 4, null);">4</button>
  <button class="tablinks" id=5 onclick="displayWeek(event, 5, null);">5</button>
  <button class="tablinks" id=6 onclick="displayWeek(event, 6, null);">6</button>
  <button class="tablinks" id=7 onclick="displayWeek(event, 7, null);">7</button>
  <button class="tablinks" id=8 onclick="displayWeek(event, 8, null);">8</button>
  <button class="tablinks" id=9 onclick="displayWeek(event, 9, null);">9</button>
  <button class="tablinks" id=10 onclick="displayWeek(event, 10, null);">10</button>
</div>

<div id="TableContainer" class="tabcontent">

</div>


<script src="main.js"></script>






<!-- Bootstrap core JavaScript -->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/popper/popper.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>

<!-- Plugin JavaScript -->
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>
<script src="vendor/scrollreveal/scrollreveal.min.js"></script>

<!-- Custom scripts for this template -->
<script src="js/creative.min.js"></script>





</body>

</html>

