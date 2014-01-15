<?php 

include_once  'config.php';
include_once  'user.php';
include_once  'article.php';
include_once  'comment.php';
include_once  'source.php';
include_once  'tag.php';
include_once  'vote.php';

class model
{   
    static $model = NULL;
    public static $articles = NULL;
    public static $comments = NULL;
    public static $sources = NULL;
    public static $tags = NULL;
    public static $users = NULL;
    public static $votes = NULL;
    
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
        self::linkSourceTag();
        self::linkCommentVote();
        self::linkArticleVote();
        self::linkArticleTag();
        self::linkArticleComment();
        self::linkArticleSource();
        
        //var_dump(self::$articles);
        
        echo("Initializing\n");
        self::$model = "KalleNOT_NULL_CHECK";
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
    
    private static function linkSourceTag()
    {
        $link = databaseConnection::getConnection();
        $sql = 'SELECT * FROM `source_tag`';
        $result = mysql_query($sql,$link);
        while ($row = mysql_fetch_array($result, MYSQL_BOTH)) 
        {
            $tagId = $row['tag_id'];
            $sourceId = $row['source_id'];
            self::$tags[$tagId]->sources[$sourceId] = self::$sources[$sourceId];
            self::$sources[$sourceId]->tags[$tagId] = self::$tags[$tagId];
        }
    }
    
    private static function linkCommentVote()
    {
        $link = databaseConnection::getConnection();
        $sql = 'SELECT * FROM `comment_vote`';
        $result = mysql_query($sql,$link);
        while ($row = mysql_fetch_array($result, MYSQL_BOTH)) 
        {
            $commentId = $row['comment_id'];
            $voteId = $row['vote_id'];
            self::$comments[$commentId]->votes[$voteId] = self::$votes[$voteId];
            self::$votes[$voteId]->comment = self::$comments[$commentId];
        }
    }
    
    private static function linkArticleVote()
    {
        $link = databaseConnection::getConnection();
        $sql = 'SELECT * FROM `article_vote`';
        $result = mysql_query($sql,$link);
        while ($row = mysql_fetch_array($result, MYSQL_BOTH)) 
        {
            $articleId = $row['article_id'];
            $voteId = $row['vote_id'];
            self::$articles[$articleId]->votes[$voteId] = self::$votes[$voteId];
            self::$votes[$voteId]->article = self::$articles[$articleId];
        }
    }
    
    private static function linkArticleTag()
    {
        $link = databaseConnection::getConnection();
        $sql = 'SELECT * FROM `article_tag`';
        $result = mysql_query($sql,$link);
        while ($row = mysql_fetch_array($result, MYSQL_BOTH)) 
        {
            $articleId = $row['article_id'];
            $tagId = $row['tag_id'];
            self::$articles[$articleId]->tags[$tagId] = self::$tags[$tagId];
            self::$tags[$tagId]->articles[$articleId] = self::$articles[$articleId];
        }
    }
    
    private static function linkArticleComment()
    {
        $link = databaseConnection::getConnection();
        $sql = 'SELECT * FROM `article_comment`';
        $result = mysql_query($sql,$link);
        while ($row = mysql_fetch_array($result, MYSQL_BOTH)) 
        {
            $articleId = $row['article_id'];
            $commentId = $row['comment_id'];
            self::$articles[$articleId]->comments[$commentId] = self::$comments[$commentId];
            self::$comments[$commentId]->article = self::$articles[$articleId];
        }
    }

    private static function linkArticleSource()
    {
        $link = databaseConnection::getConnection();
        $sql = 'SELECT * FROM `article_source`';
        $result = mysql_query($sql,$link);
        while ($row = mysql_fetch_array($result, MYSQL_BOTH)) 
        {
            $articleId = $row['article_id'];
            $sourceId = $row['source_id'];
            self::$articles[$articleId]->sources[$sourceId] = self::$sources[$sourceId];
            self::$sources[$sourceId]->articles[$articleId] = self::$articles[$articleId];
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