<?php
include_once ('Server/DataModel/model.php');

class dataAccess
{
    static $model;
    function __construct() {
        if (self::$model == NULL)
        {
            $model = new model;
        }
        self::getData();
    }
    
    function getData()
    {
        foreach (model::$users as $vote) {
            $json = $vote->toJSON();
            //echo $json;
            $vote->fromJSON($json);
        }
        
        //echo json_encode(model::$votes);
    }
    
    function JSONSetVotes()
    {
        
    }
    
    function JSONSetComments()
    {
        
    }
    
    function JSONSetUsers()
    {
        
    }
    
    function JSONSetTags()
    {
        
    }
    
    function JSONSetArticles()
    {
        
    }
    
    function JSONSetSources()
    {
        
    }
    
}
?>