<?php


 // * A Class for interacting with the national_parks database table
 // *
 // * contains static methods for retrieving records from the database
 // * contains an instance method for persisting a record to the database
 // *
 // * Usage Examples
 // *
 // * Retrieve a list of parks and display some values for each record
 // // *
 //       $parks = Park::all();
 //       foreach($parks as $park) {
 //           echo $park->id . PHP_EOL;
 //           echo $park->name . PHP_EOL;
 //           echo $park->description . PHP_EOL;
 //           echo $park->areaInAcres . PHP_EOL;
 //      }

 // // * Inserting a new record into the database

 //       $park = new Park();
 //       $park->name = 'Acadia';
 //       $park->location = 'Maine';
 //       $park->areaInAcres = 48995.91;
 //       $park->dateEstablished = '1919-02-26';

 //       $park->insert();

class Park
{

    // ///////////////////////////////////
    // // Static Methods and Properties //
    // ///////////////////////////////////

    // /**
    //  * our connection to the database
    //  */
    public static $dbc = null;

    /**
     * establish a database connection if we do not have one
     */
    public static function dbConnect() {
        if (! is_null(self::$dbc)) {
            return;
        }
        self::$dbc = require 'db_connect.php';
    }

    /**
     * returns the number of records in the database
     */
    public static function count() {
        // TODO: call dbConnect to ensure we have a database connection

        self::dbConnect();
        // TODO: use the $dbc static property to query the database for the
        //       number of existing park records
    $statement = self::$dbc->prepare("SELECT count(*) FROM national_parks");

    $statement->execute();

    return $statement->fetchColumn();
    }

    /**
     * returns all the records
     */
    public static function all() {
        // TODO: call dbConnect to ensure we have a database connection
        self::dbConnect();
        // TODO: use the $dbc static property to query the database for all the
        //       records in the parks table
        $statement = self::$dbc->prepare("SELECT * FROM national_parks");
        $statement->execute();

        // TODO: iterate over the results array and transform each associative
        //       array into a Park object
        $parks = array();
        while ($park = $statement->fetch(PDO::FETCH_ASSOC)) {
            $parks[] = $park;
        }

        // TODO: return an array of Park objects
        return $parks;
    }

    /**
     * returns $resultsPerPage number of results for the given page number
     */
    public static function paginate($limit, $offset) {
        // TODO: call dbConnect to ensure we have a database connection
        self::dbConnect();
        // TODO: calculate the limit and offset needed based on the passed
        //       values
        $statement = self::$dbc->prepare("SELECT * FROM national_parks LIMIT :limit OFFSET :offset");
        $statement->bindValue(':limit', $limit, PDO::PARAM_INT);
        $statement->bindValue(':offset', $offset, PDO::PARAM_INT);

        $statement->execute();

        // TODO: use the $dbc static property to query the database with the



        //       calculated limit and offset
        // TODO: return an array of the found Park objects
        return $statement->fetchAll(PDO::FETCH_ASSOC);

}

    /////////////////////////////////////
    // Instance Methods and Properties //
    /////////////////////////////////////

    /**
     * properties that represent columns from the database
     */
    public $id;
    public $name;
    public $location;
    public $dateEstablished;
    public $areaInAcres;
    public $description;

    /**
     * inserts a record into the database
     */
    public function insert() {
        // TODO: call dbConnect to ensure we have a database connection
        self::dbConnect();
        // TODO: use the $dbc static property to create a prepared statement for
        //       inserting a record into the parks table

        $userInput = "INSERT into national_parks (name, location, date_established, area_in_acres, description)
                    VALUES (:name, :location, :date_established, :area_in_acres, :description)";
        // TODO: use the $this keyword to bind the values from this object to
        //       the prepared statement
        $statement = self::$dbc->prepare($userInput);
        $statement->bindValue(':name', $this->name, PDO::PARAM_STR);
        $statement->bindValue(':location', $this->location, PDO::PARAM_STR);
        $statement->bindValue(':date_established', $this->dateEstablished, PDO::PARAM_STR);
        $statement->bindValue(':area_in_acres', $this->areaInAcres, PDO::PARAM_STR);
        $statement->bindValue(':description', $this->description, PDO::PARAM_STR);

        $statement->execute();
        // TODO: excute the statement and set the $id property of this object to
        //       the newly created id
        $this->id = self::$dbc->lastInsertId();


    }
}
