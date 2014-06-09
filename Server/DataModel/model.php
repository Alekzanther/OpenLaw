<?php 

include_once  'config.php';
include_once  'user.php';
include_once  'article.php';
include_once  'comment.php';
include_once  'source.php';
include_once  'tag.php';
include_once  'vote.php';
include 'ChromePhp.php';


class model
{
    public $items = array();
    
    private static $singleton_instance = null;
     
    private function construct__() {
    }
     
    public static function global_instance() {
        static $singleton_instance = null;
        if($singleton_instance === null) {
            $singleton_instance = new model();
            $singleton_instance->initializeModel();
        }
        return($singleton_instance);
    }
    
    
    public function initializeModel()
    {
        $size = memory_get_usage();
        
        $this->getItems();

        $size2 = memory_get_usage();
        $sizeKb = ($size2 - $size) / 1024;
        //var_dump("model size = ".$sizeKb . "kB");
        
        //echo("Initializing\n");
        
    }
    
    
    private function getItems()
    {
        $this->items["user"] = $this->getUsers();
        $this->items["comment"] = $this->getComments();
        $this->items["vote"] = $this->getVotes();
        $this->items["tag"] = $this->getTags();
        $this->items["article"] = $this->getArticles();
        $this->items["source"] = $this->getSources();
        ChromePhp::log($this->items["source"]);
        
        $this->linkUserVotes();
        $this->linkUserComments();
		$this->linkUserSource();
        $this->linkSourceTag();
        $this->linkCommentVote();
        $this->linkArticleVote();
        $this->linkArticleTag();
        $this->linkArticleComment();
        $this->linkArticleSource();
		
		ChromePhp::log($this->items["source"]);
     }
 
    private function linkUserVotes()
    {
        $link = databaseConnection::getConnection();   
        $sql = 'SELECT * FROM `user_vote`';
        $result = $link->query($sql);
        while ($row = $result->fetch_array()) 
        {
            $userId = $row['user_id'];
            $voteId = $row['vote_id'];
            
            $this->items["user"][$userId]->voteIds[] = $voteId;
            $this->items["vote"][$voteId]->userId = $userId;
        }
    }
    
    private function linkUserComments()
    {
        $link = databaseConnection::getConnection();   
        $sql = 'SELECT * FROM `user_comment`';
        $result = $link->query($sql);
        while ($row = $result->fetch_array()) 
        {
            $userId = $row['user_id'];
            $commentId = $row['comment_id'];
            
            $this->items["user"][$userId]->commentIds[] = $commentId;
            $this->items["comment"][$commentId]->userId = $userId;
        }
    }
    
    private function linkUserSource()
    {
        $link = databaseConnection::getConnection();   
        $sql = 'SELECT * FROM `user_source`';
        $result = $link->query($sql);
        while ($row = $result->fetch_array()) 
        {
            $userId = $row['user_id'];
            $sourceId = $row['source_id'];
            
            $this->items["user"][$userId]->sourceId = $sourceId;
            $this->items["source"][$sourceId]->userId = $userId;
        }
    }
    
    private function linkSourceTag()
    {
        $link = databaseConnection::getConnection();
        $sql = 'SELECT * FROM `source_tag`';
        $result = $link->query($sql);
        while ($row = $result->fetch_array()) 
        {
            $tagId = $row['tag_id'];
            $sourceId = $row['source_id'];
            
            $this->items["tag"][$tagId]->sourceIds[] = $sourceId;
            $this->items["source"][$sourceId]->tagIds[] = $tagId;
        }
    }
    
    private function linkCommentVote()
    {
        $link = databaseConnection::getConnection();
        $sql = 'SELECT * FROM `comment_vote`';
        $result = $link->query($sql);
        while ($row = $result->fetch_array())  
        {
            $commentId = $row['comment_id'];
            $voteId = $row['vote_id'];
            
            $this->items["comment"][$commentId]->voteIds[] = $voteId;
            $this->items["vote"][$voteId]->commentId = $commentId;
        }
    }
    
    private function linkArticleVote()
    {
        $link = databaseConnection::getConnection();
        $sql = 'SELECT * FROM `article_vote`';
        $result = $link->query($sql);
        while ($row = $result->fetch_array()) 
        {
            $articleId = $row['article_id'];
            $voteId = $row['vote_id'];
            
            $this->items["article"][$articleId]->voteIds[] = $voteId;
            $this->items["vote"][$voteId]->articleId = $articleId;
            
        }
    }
    
    private function linkArticleTag()
    {
        $link = databaseConnection::getConnection();
        $sql = 'SELECT * FROM `article_tag`';
        $result = $link->query($sql);
        while ($row = $result->fetch_array()) 
        {
            $articleId = $row['article_id'];
            $tagId = $row['tag_id'];
            
            $this->items["article"][$articleId]->tagIds[] = $tagId;
            $this->items["tag"][$tagId]->articleIds[] = $articleId;
            
        }
    }
    
    private function linkArticleComment()
    {
        $link = databaseConnection::getConnection();
        $sql = 'SELECT * FROM `article_comment`';
        $result = $link->query($sql);
        while ($row = $result->fetch_array()) 
        {
            $articleId = $row['article_id'];
            $commentId = $row['comment_id'];
            
            $this->items["article"][$articleId]->commentIds[] = $commentId;
            $this->items["comment"][$commentId]->articleId = $articleId;
        }
    }

    private function linkArticleSource()
    {
        $link = databaseConnection::getConnection();
        $sql = 'SELECT * FROM `article_source`';
        $result = $link->query($sql);
        while ($row = $result->fetch_array()) 
        {
            $articleId = $row['article_id'];
            $sourceId = $row['source_id'];
            
            $this->items["article"][$articleId]->sourceIds[] = $sourceId;
            $this->items["source"][$sourceId]->articleIds[] = $articleId;
			
			ChromePhp::log($articleId);
        }
    }

    private function getUsers()
    {
        $link = databaseConnection::getConnection();   
        $dbItems = array();
        $sql = 'SELECT * FROM `user`';
        $result = $link->query($sql);
        $i = 0;
        while ($row = $result->fetch_array()) 
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
    
    private function getComments()
    {
        $link = databaseConnection::getConnection();   
        $dbItems = array();
        $sql = 'SELECT * FROM `comment`';
        $result = $link->query($sql);
        $i = 0;
        while ($row = $result->fetch_array()) 
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
    
    private function getArticles()
    {
        $link = databaseConnection::getConnection();   
        $dbItems = array();
        $sql = 'SELECT * FROM `article`';
        $result = $link->query($sql);
        while ($row = $result->fetch_array()) 
        {
            $dbItem = new article;
            $dbItem->id = $row['id'];
            $dbItem->create_date = $row['create_date'];
            $dbItems[$dbItem->id] = $dbItem;
        }
        return $dbItems;
        
    }
    
    private function getSources()
    {
        $link = databaseConnection::getConnection();   
        $dbItems = array();
        $sql = 'SELECT * FROM `source`';
        $result = $link->query($sql);
        
        while ($row = $result->fetch_array())  
        {
            $dbItem = new source;
            $dbItem->id = $row['id'];
            $dbItem->create_date = $row['create_date'];
            $dbItem->name = $row['name'];
            $dbItems[$dbItem->id] = $dbItem;
			
        }
		
        return $dbItems;
        
    }

    private function getTags()
    {
        $link = databaseConnection::getConnection();   
        $dbItems = array();
        $sql = 'SELECT * FROM `tag`';
        $result = $link->query($sql);
        $i = 0;
        while ($row = $result->fetch_array()) 
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
    
    private function getVotes()
    {
        $link = databaseConnection::getConnection();   
        $dbItems = array();
        $sql = 'SELECT * FROM `vote`';
        $result = $link->query($sql);
        $i = 0;
        while ($row = $result->fetch_array()) 
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