<?php
class Match{
 
    // database connection and table name
    private $conn;
    private $table_name = "matchhistory";
 
    // object properties
    public $id;
    public $Season;
    public $League;
    public $Week;
    public $Team1;
    public $Team2;
    public $Winner;
    public $Score;
    public $Game1Draft;
    public $Game1Postgame;
    public $Game1History;
    public $Game2Draft;
    public $Game2Postgame;
    public $Game2History;
    public $Game3Draft;
    public $Game3Postgame;
    public $Game3History;
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    function read() {
        // select all query
        $query = "SELECT
                    *
                FROM
                    " . $this->table_name;
     
        // prepare query statement
        $stmt = $this->conn->prepare($query);
     
        // execute query
        $stmt->execute();
        return $stmt;
    }

    function create() {
        // query to insert record
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    Season=:Season, League=:League, Week=:Week, Team1=:Team1, Team2=:Team2, Winner=:Winner, Score=:Score, 
                    Game1Draft=:Game1Draft, Game1Postgame=:Game1Postgame, Game1History=:Game1History,
                    Game2Draft=:Game2Draft, Game2Postgame=:Game2Postgame, Game2History=:Game2History,
                    Game3Draft=:Game3Draft, Game3Postgame=:Game3Postgame, Game3History=:Game3History,
                    ";



        // prepare query
        $stmt = $this->conn->prepare($query);
        foreach ($this as $key => $value) {
            // sanitize
            if ($key == "id" || $key == "conn" || $key == "table_name") {
                continue;
            }
            $this->$key=htmlspecialchars(strip_tags($value));
            // bind value
            $stmt->bindParam(":".$key, $this->$key);
        }
        
        printf("Query:\n %s \n",$query);
     
        // execute query
        if($stmt->execute()){
            return true;
        }
        print_r($stmt->errorInfo());
        return false;
    }
}