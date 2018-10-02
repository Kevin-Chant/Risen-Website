<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/match.php';
 
// instantiate database and match object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$match = new Match($db);
 
// query matches
$stmt = $match->read();
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    // matches array
    $matches_arr=array();
    $matches_arr["records"]=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
        $match_item=array(
            "id" => $id,
            "Season" => $Season,
            "League" => $League,
            "Week" => $Week,
            "Team1" => $Team1,
            "Team2" => $Team2,
            "Winner" => $Winner,
            "Score" => $Score,
            "Game1draft" => $Game1Draft,
            "Game1postgame" => $Game1Postgame,
            "Game1history" => $Game1History,
            "Game2draft" => $Game2Draft,
            "Game2postgame" => $Game2Postgame,
            "Game2history" => $Game2History,
            "Game3draft" => $Game3Draft,
            "Game3postgame" => $Game3Postgame,
            "Game3history" => $Game3History
        );
 
        array_push($matches_arr["records"], $match_item);
    }
 
    echo json_encode($matches_arr);
}
 
else{
    echo json_encode(
        array("message" => "No matches found.")
    );
}
?>