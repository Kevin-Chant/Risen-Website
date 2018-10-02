<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// get database connection
include_once '../config/database.php';
 
// instantiate match object
include_once '../objects/match.php';
 
$database = new Database();
$db = $database->getConnection();
 
$match = new Match($db);
 
// get posted data
$data = json_decode(file_get_contents("php://input"));
if (is_null($data)) {
	parse_str(file_get_contents("php://input"), $data);
}
echo("Data is\n");
echo(print_r($data));
echo("\n");
 
// set match property values
foreach ($data as $key => $value) {
	if ($key == "submit") {
		continue;
	}
	$match->$key = $value;
}
 
// create the match
if($match->create()){
    echo '{';
        echo '"message": "match was created."';
    echo '}';
}
 
// if unable to create the match, tell the user
else{
    echo '{';
        echo '"message": "Unable to create match."';
    echo '}';
}
?>