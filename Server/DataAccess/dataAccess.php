<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/OpenLaw/Server/DataModel/model.php';

class dataAccess
{
    static $model;
    function __construct() {
        if (self::$model == NULL)
        {
            $model = new model;
        }
        $a = self::getData();
        #var_dump($a);
        self::setData($a);
    }
    
    
    
    function getData()
    {
        return json_encode(model::$items);
    }
    
    public function setData($jsons)
    {
        $jsonData = json_decode($jsons,true);
        #var_dump($jsonData);
        $keys = array_keys($jsonData);
        foreach($keys as $key)
        {
            foreach ($jsonData[$key] as $jsonType)
            {
                $id = $jsonType["id"];
                
                $realItem = model::$items[$key][$id];
                $this->mergeData($jsonType, $realItem);
            }
        }
        //$user->fromJSON($json);
    }
    
    function JSONSetVote($obj)
    {
        
    }
    
    function JSONSetComment($obj)
    {
        
    }
    
    function JSONSetUser($obj)
    {
        
        if(array_key_exists($obj->id, model::$users))
        {
            
            $existingItem = model::$users[$obj->id ];
            $this->mergeData($obj, $existingItem);
        }
        else {
            //add new
        }
    }
    
    function JSONSetTag($obj)
    {
        
    }
    
    function JSONSetArticle($obj)
    {
        
    }
    
    function JSONSetSource($obj)
    {
        
    }
    
    static function startsWith($haystack, $needle)
    {
        return $needle === "" || strpos($haystack, $needle) === 0;
    }
    
    static function endsWith($haystack, $needle)
    {
        return $needle === "" || substr($haystack, -strlen($needle)) === $needle;
    }
    
    public function mergeData($jsonObj, $modelObj)
    {
        
        $instanceReflect = new ReflectionClass($modelObj);
        $instanceProps = $instanceReflect->getProperties();
        
        $keys = array_keys($jsonObj);
        foreach($keys as $key)
        {
            $value = $jsonObj[$key];
            $prop = $instanceReflect->getProperty($key);
            if($prop->getValue($modelObj) != $value)
            {
                $this->changeValue($prop, $modelObj, $value);
            }
        }
    }

    function changeValue($prop, $modelObj, $newValue)
    {
        $prop->setValue($modelObj ,$newValue);
    }
    
    function changeReferences()
    {
        
    }
    
}

if (isset($_GET['url']) && method_exists('dataAccess',$_GET['url'])){
  $view = new dataAccess();
  echo($view->$_GET['url']());
} 
else {
  echo 'nice try';
}

?>