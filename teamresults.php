<html>
<title>Match Results</title>

<head>
  <link rel="stylesheet" href="stylesheet.css">
</head>



<form action="teamresults.php" method="post">
	Search for all results for a specific team:<br/>
	<input type="text", name="team", maxlength="4" size="4">
  <select name="league">
    <option value="Rampage">Rampage</option>
    <option value="Dominate">Dominate</option>
    <option value="Alumnus">Alumnus</option>
    <option value="Champions">Champions</option>
  </select>
	<input type="submit", value="Find Results">
</form>


<?php
		echo $_POST["team"];
    echo '<br>';
		echo $_POST["league"];
?>



</body>

</html>

