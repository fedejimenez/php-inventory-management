<?php  
  
session_start();

class Connect{

  protected $dbh;

  protected function connection(){
    try {
      // $connect = $this->dbh = new PDO("mysql:local=localhost;dbname=dbphpsystem", "root", "root");
      //Get Heroku ClearDB connection information
      
      $url = parse_url(getenv("CLEARDB_DATABASE_URL"));
      $server = $url["host"];
      $username = $url["user"];
      $password = $url["pass"];
      $db = substr($url["path"], 1);

      $dbstart = 'mysql:host=' . $server . ';dbname=' . $db;
      $connect = $this->dbh = new PDO($dbstart, $username, $password);
      return $connect;
    
    } catch (Exception $e) {
      print "Error! " . $e->getMessage() . "<br/>";  
      die();
    }
  } // close function connection

  public static function transform_dates($string){
    $string = str_replace(
      array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'),
      array('JANUARY', 'FEBRUARY', 'MARCH', 'APRIL', 'MAY', 'JUNE', 'JULY', 'AUGUST', 'SEPTEMBER', 'OCTOBER', 'NOVEMBER', ' DECEMBER'),
     $string
    );        
    return $string;
  }

  public function set_names(){
    return $this->dbh->query("SET NAMES 'utf8'");
  }

  public function route(){
    return "https://purchases-sales-system.herokuapp.com/";
    // return "http://localhost/projects/phpsystem/";
  }


}
?>