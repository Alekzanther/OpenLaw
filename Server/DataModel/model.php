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
        $users = self::getVotes();
        var_dump($users);
        $users = self::getArticles();
        var_dump($users);
        $users = self::getComments();
        var_dump($users);
        $users = self::getSources();
        var_dump($users);
        $users = self::getTags();
        var_dump($users);
        echo("Initializing\n");
        self::$model = "Kalle";
    }
    
    private static function getUsers()
    {
        $link = databaseConnection::getConnection();   
        $dbItems = array();
        $sql = 'SELECT * FROM `user`';
        $result = mysql_query($sql,$link);
        $i = 0;
        while ($row = mysql_fetch_array($result, MYSQL_BOTH)) 
        {
            $dbItem = new user;
            $dbItem->name = $row['name'];
            $dbItem->email = $row['email'];
            $dbItem->id = $row['id'];
            $dbItems[$i] = $dbItem;
            $i++;
        }
        return $dbItems;
        
    }
    
    private static function getComments()
    {
        $link = databaseConnection::getConnection();   
        $dbItems = array();
        $sql = 'SELECT * FROM `comment`';
        $result = mysql_query($sql,$link);
        $i = 0;
        while ($row = mysql_fetch_array($result, MYSQL_BOTH)) 
        {
            $dbItem = new comment;
            $dbItem->id = $row['id'];
            $dbItem->value = $row['value'];
            $dbItem->create_date = $row['create_date'];
            $dbItem->edit_date = $row['edit_date'];
            $dbItems[$i] = $dbItem;
            $i++;
        }
        return $dbItems;
        
    }
    
    private static function getArticles()
    {
        $link = databaseConnection::getConnection();   
        $dbItems = array();
        $sql = 'SELECT * FROM `article`';
        $result = mysql_query($sql,$link);
        $i = 0;
        while ($row = mysql_fetch_array($result, MYSQL_BOTH)) 
        {
            $dbItem = new article;
            $dbItem->id = $row['id'];
            $dbItem->create_date = $row['create_date'];
            $dbItems[$i] = $dbItem;
            $i++;
        }
        return $dbItems;
        
    }
    
    private static function getSources()
    {
        $link = databaseConnection::getConnection();   
        $dbItems = array();
        $sql = 'SELECT * FROM `source`';
        $result = mysql_query($sql,$link);
        $i = 0;
        while ($row = mysql_fetch_array($result, MYSQL_BOTH)) 
        {
            $dbItem = new source;
            $dbItem->id = $row['id'];
            $dbItem->create_date = $row['create_date'];
            $dbItem->name = $row['name'];
            $dbItems[$i] = $dbItem;
            $i++;
        }
        return $dbItems;
        
    }

    private static function getTags()
    {
        $link = databaseConnection::getConnection();   
        $dbItems = array();
        $sql = 'SELECT * FROM `tag`';
        $result = mysql_query($sql,$link);
        $i = 0;
        while ($row = mysql_fetch_array($result, MYSQL_BOTH)) 
        {
            $dbItem = new tag;
            $dbItem->id = $row['id'];
            $dbItem->create_date = $row['create_date'];
            $dbItem->name = $row['name'];
            $dbItems[$i] = $dbItem;
            $i++;
        }
        return $dbItems;
        
    }
    
    private static function getVotes()
    {
        $link = databaseConnection::getConnection();   
        $dbItems = array();
        $sql = 'SELECT * FROM `vote`';
        $result = mysql_query($sql,$link);
        $i = 0;
        while ($row = mysql_fetch_array($result, MYSQL_BOTH)) 
        {
            $dbItem = new vote;
            $dbItem->id = $row['id'];
            $dbItem->create_date = $row['create_date'];
            $dbItem->value = $row['value'];
            $dbItems[$i] = $dbItem;
            $i++;
        }
        return $dbItems;
        
    }
}
?>