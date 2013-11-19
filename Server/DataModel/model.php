<?php 

include 'config.php';
include 'user.php';

class model
{   
    static $model = NULL;
    static $users = NULL;
    
    function __construct() {
        if(self::$model == NULL)
        {
            echo("First time model request\n");
            $this->InitializeModel();       
        }
        return self::$model;
    }
    
    private static function initializeModel()
    {
        $users = self::getUsers();
        var_dump($users);
        echo("Initializing\n");
        self::$model = "Kalle";
    }
    
    private static function getUsers()
    {
        $link = databaseConnection::getConnection();   
        $dbUsers = array();
        $sql = 'SELECT * FROM `user`';
        $result = mysql_query($sql,$link);
        $i = 0;
        while ($row = mysql_fetch_array($result, MYSQL_BOTH)) 
        {
            $dbUser = new user;
            $dbUser->name = $row['name'];
            $dbUser->email = $row['email'];
            $dbUsers[$i] = $dbUser;
            $i++;
        }
        return $dbUsers;
        
    }
}
?>