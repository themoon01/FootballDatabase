    <?php

    
    require_once 'pdoconfig.php';

    try {
        $conn = new PDO("mysql:host=$host;dbname=$dbname",$username, $password);
        }
      catch (PDOException $pe) {die("Could not connect to database $dbname :" . $pe->getMessage());
    }








    /*function OpenCon()
     {
     $dbhost = "localhost";
     $dbuser = "root";
     $dbpass = "Mjforever7!";
     $db = "football";
     $conn = new mysqli($dbhost, $dbuser, $dbpass,$db) or die("Connect failed: %s\n". $conn -> error);
     
     return $conn;
     }
     
    function CloseCon($conn)
     {
     $conn -> close();
     }*/
       
    ?>