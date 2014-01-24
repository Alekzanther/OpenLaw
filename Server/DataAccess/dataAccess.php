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
        $a = self::getData();
        self::setData($a);
    }
    
    function getData()
    {
        $data = array();
        $i = 0;
        foreach (model::$users as $user) {
            $json = $user->toJSON();
            $data[$i] = $json;
            $i++;
        }
        return $data;
    }
    
    public function setData($jsons)
    {
        foreach ($jsons as $json)
        {
            $obj = json_decode($json);
            switch ($obj->type) {
                case 'user':
                    $this->JSONSetUser($obj);
                    break;
                case 'vote':
                    $this->JSONSetVote($obj);
                    break;
                case 'comment':
                    $this->JSONSetComment($obj);
                    break;
                case 'source':
                    $this->JSONSetSource($obj);
                    break;
                case 'article':
                    $this->JSONSetArticle($obj);
                    break;
                case 'tag':
                    $this->JSONSetTag($obj);
                    break;
                default:
                    throw new Exception("setData: Unknown JSON type");    
                    break;
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

        foreach(get_object_vars($jsonObj) as $propName => $newValue) 
        {
            if(self::endsWith($propName,"id"))
            {
                /*Do this somewhere else*/
                
                /*$trans = array("id" => "");
                $propName = strtr($propName, $trans);*/
            }
            else if(self::endsWith($propName,"ids"))
            {
                $transformationString = array("ids" => "");
                $propName = strtr($propName, $transformationString);
                
                foreach($newValue as $value)
                {
                    $prop = $instanceReflect->getProperty($propName);
                    $items = $prop->getValue($modelObj);
                    #$items[$value] = model::
                    var_dump($items);
                }
                
                $prop = $instanceReflect->getProperty($propName);
                $items = $prop->getValue($modelObj);
                foreach($items as $item)
                {
                    
                }
                //var_dump($temp);
                //$prop->setValue();
            }
            else if($propName == "type")
            {
                
            }
            else 
            {
                $prop = $instanceReflect->getProperty($propName);
                if($prop->getValue($modelObj) != $newValue)
                {
                    $this->changeValue($prop, $modelObj, $newValue);
                }
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
?>