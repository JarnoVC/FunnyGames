<?php
    
    class DB{
        
        private static $conn;
        
        public static function Connection() {
            include_once(__DIR__ ."/../settings/settings.php");
            
            
            if(self::$conn === null){
                self::$conn = new PDO('mysql:host=' . SETTINGS["db"]["host"] . ';dbname=' .SETTINGS["db"]["name"], SETTINGS["db"]["user"], SETTINGS["db"]["password"]);
                //echo "connected";
                return self::$conn;
            } else {
                return self::$conn;
            }
            
            
            
        }
    
    }




    /*try {
        $conn = new PDO("mysql:host=localhost;dbname=funnygames", "root", "");
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "Connected successfully";
    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }*/
    
 