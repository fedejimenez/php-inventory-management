<?php  
  
session_start();

class Connect{

  protected $dbh;

  protected function connection(){
    try {
      $connect = $this->dbh = new PDO("mysql:local=localhost;dbname=dbphpsystem", "root", "root");
      return $connect;
    
    } catch (Exception $e) {
      print "Error! " . $e->getMessage() . "<br/>"; 
      die();
    }
  } // close function connection

  public function set_names(){
    return $this->dbh->query("SET NAMES 'utf8'");
  }

  public function route(){
    return "http://localhost/projects/phpsystem/";
  }

}
?>