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
    public static $items = NULL;
    
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
        
        $size = memory_get_usage();
        
        self::getItems();
        
        self::linkUserVotes();
        self::linkUserComments();
        self::linkSourceTag();
        self::linkCommentVote();
        self::linkArticleVote();
        self::linkArticleTag();
        self::linkArticleComment();
        self::linkArticleSource();
        #var_dump(self::$items);
        
        ##Error checking the model
        #foreach(self::$items as $item)
        #{
        #    foreach($item as $realItem)
        #    {
        #        #var_dump($realItem);
        #        if($realItem->id == null)
        #        {
                     #error
        #            #var_dump($realItem);
        #        }
        #    }
        #}
        $size2 = memory_get_usage();
        $sizeKb = ($size2 - $size) / 1024;
        var_dump("model size = ".$sizeKb . "kB");
        
        
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
            
            self::$items["user"][$userId]->voteIds[] = $voteId;
            self::$items["vote"][$voteId]->userId = $userId;
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
            
            self::$items["user"][$userId]->commentIds[] = $commentId;
            self::$items["comment"][$commentId]->userId = $userId;
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
            
            self::$items["user"][$userId]->$sourceId = $sourceId;
            self::$items["source"][$sourceId]->userId = $userId;
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
            
            self::$items["tag"][$tagId]->sourceIds[] = $sourceId;
            self::$items["source"][$sourceId]->tagIds[] = $tagId;
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
            
            self::$items["comment"][$commentId]->voteIds[] = $voteId;
            self::$items["vote"][$voteId]->commentId = $commentId;
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
            
            self::$items["article"][$articleId]->voteIds[] = $voteId;
            self::$items["vote"][$voteId]->articleId = $articleId;
            
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
            
            self::$items["article"][$articleId]->tagIds[] = $tagId;
            self::$items["tag"][$tagId]->articleIds[] = $articleId;
            
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
            
            self::$items["article"][$articleId]->commentIds[] = $commentId;
            self::$items["comment"][$commentId]->articleId = $articleId;
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
            
            self::$items["article"][$articleId]->sourceIds[] = $sourceId;
            self::$items["source"][$sourceId]->articleIds[] = $articleId;
        }
    }
    
    private static function getItems()
    {
        self::$items["user"] = self::getUsers();
        self::$items["comment"] = self::getComments();
        self::$items["vote"] = self::getVotes();
        self::$items["tag"] = self::getTags();
        self::$items["article"] = self::getArticles();
        self::$items["source"] = self::getSources();
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
            $dbItems[$dbItem->id] = $dbItem;
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
            $dbItems[$dbItem->id] = $dbItem;
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
            $dbItems[$dbItem->id] = $dbItem;
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
            $dbItems[$dbItem->id] = $dbItem;
            $i++;
        }
        return $dbItems;
        
    }
}
?>