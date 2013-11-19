<?php
    class databaseConnection
    {
        private static $db_host="";
        private static $db_name="";
        private static $username="";
        private static $password="";
        private static $link = NULL;
        public static function getConnection()
        {
            if(self::$link == NULL)
            {   
                self::$link = mysql_connect(self::$db_host,self::$username,self::$password);
                mysql_select_db(self::$db_name);
                
                if (!self::$link) {
                    die('Could not connect: ' . mysql_error());
                }
            }
            return self::$link;
        }   
    }
?>