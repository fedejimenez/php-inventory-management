<?php  
  
session_start();

class Connect{

  protected $dbh;

  protected function connection(){
    try {
      // $connect = $this->dbh = new PDO("mysql:local=localhost;dbname=dbphpsystem", "root", "root");
      //Get Heroku ClearDB connection information
      $cleardb_url      = parse_url(getenv("CLEARDB_DATABASE_URL"));
      $cleardb_server   = $cleardb_url["host"];
      $cleardb_username = $cleardb_url["user"];
      $cleardb_password = $cleardb_url["pass"];
      $cleardb_db       = substr($cleardb_url["path"],1);


      $active_group = 'default';
      $query_builder = TRUE;

      $db['default'] = array(
          'dsn'    => '',
          'hostname' => $cleardb_server,
          'username' => $cleardb_username,
          'password' => $cleardb_password,
          'database' => $cleardb_db,
          'dbdriver' => 'mysqli',
          'dbprefix' => '',
          'pconnect' => FALSE,
          'db_debug' => (ENVIRONMENT !== 'production'),
          'cache_on' => FALSE,
          'cachedir' => '',
          'char_set' => 'utf8',
          'dbcollat' => 'utf8_general_ci',
          'swap_pre' => '',
          'encrypt' => FALSE,
          'compress' => FALSE,
          'stricton' => FALSE,
          'failover' => array(),
          'save_queries' => TRUE
      );
      $connect = $this->dbh = new PDO($db['default']);
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
    return "http://localhost/projects/phpsystem/";
  }


}
?>