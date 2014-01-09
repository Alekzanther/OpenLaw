<?php 

include 'config.php';
include 'user.php';
include 'article.php';
include 'comment.php';
include 'source.php';
include 'tag.php';
include 'vote.php';

class model
{   
    static $model = NULL;
    static $articles = NULL;
    static $comments = NULL;
    static $sources = NULL;
    static $tags = NULL;
    static $users = NULL;
    static $votes = NULL;

    
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
        self::$users = self::getUsers();
        self::$votes = self::getVotes();
        self::$articles = self::getArticles();
        self::$comments = self::getComments();
        self::$sources = self::getSources();
        self::$tags = self::getTags();
        
        self::linkUserVotes();
        self::linkUserComments();
        //var_dump(self::$tags);
        var_dump(self::$users);
        //var_dump(self::$sources);
        //var_dump(self::$comments);
        //var_dump(self::$articles);
        //var_dump(self::$votes);
        echo("Initializing\n");
        self::$model = "KalleNOTNULLCHECK";
    }
    
    private static function linkUserVotes()
    {
        $link = databaseConnection::getConnection();   
        $sql = 'SELECT * FROM `user_vote`';
        $result = mysql_query($sql,$link);
        while ($row = mysql_fetch_array($result, MYSQL_BOTH)) 
        {
            $userId = $row['user_id'];
            $voteId = $row['vote_id'];
            
            self::$users[$userId]->votes[$voteId] = self::$votes[$voteId];
            self::$votes[$voteId]->user = self::$users[$userId];
        }
    }
    
    private static function linkUserComments()
    {
        $link = databaseConnection::getConnection();   
        $sql = 'SELECT * FROM `user_comment`';
        $result = mysql_query($sql,$link);
        while ($row = mysql_fetch_array($result, MYSQL_BOTH)) 
        {
            $userId = $row['user_id'];
            $commentId = $row['comment_id'];
            
            self::$users[$userId]->comments[$commentId] = self::$comments[$commentId];
            self::$comments[$commentId]->user = self::$users[$userId];
        }
    }
    
    private static function linkUserSource()
    {
        $link = databaseConnection::getConnection();   
        $sql = 'SELECT * FROM `user_comment`';
        $result = mysql_query($sql,$link);
        while ($row = mysql_fetch_array($result, MYSQL_BOTH)) 
        {
            $userId = $row['user_id'];
            $sourceId = $row['source_id'];
            
            self::$users[$userId]->source = self::$sources[$sourceId];
            self::$sources[$sourceId]->user = self::$users[$userId];
        }
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
            $dbItems[$dbItem->id] = $dbItem;
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
            $dbItems[$dbItem->id] = $dbItem;
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
            $dbItems[$dbItem->id ] = $dbItem;
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
            $dbItems[$dbItem->id ] = $dbItem;
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
            $dbItems[$dbItem->id ] = $dbItem;
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
            $dbItems[$dbItem->id ] = $dbItem;
            $i++;
        }
        return $dbItems;
        
    }
}
?>