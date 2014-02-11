<?php
    class databaseConnection
    {
        private static $db_host="";
        private static $db_name="";
        private static $username="";
        private static $password="";
        private static $mysqli = NULL;
        public static function getConnection()
        {
            if(self::$mysqli == NULL)
            {
                self::$mysqli = new mysqli(self::$db_host, self::$username, self::$password, self::$db_name);   
                #self::$mysqli->mysqli_select_db(self::$db_name);
                if (mysqli_connect_errno()) 
                {
                    printf("Connect failed: %s\n", mysqli_connect_error());
                    exit();
                }
                self::$mysqli->set_charset('utf8');  
            }
            
            return self::$mysqli;
        }     
    }
?>