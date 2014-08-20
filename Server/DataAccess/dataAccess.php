<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/OpenLaw/Server/DataModel/model.php';

class dataAccess
{
    private static $singleton_instance = null;
     
    private function construct__() {
        // Declaring the constructor as private ensures
        // that this object is not created as a new intance
        // outside of this class.  Therefore you must use the
        // global_instance function to create this object.
    }
     
    public static function global_instance() {
        static $singleton_instance = null;
        if($singleton_instance === null) {
            $singleton_instance = new dataAccess();
        }
         
        return($singleton_instance);
    }
    
    
    function getData($param)
    {
		return json_encode(model::global_instance()->items);
    }
    
    public function setData($type ,$json)
    {
        $jsonData = json_decode($json,true);
        $keys = array_keys($jsonData);
		 
		ChromePhp::log($jsonData);
        foreach($keys as $key)
        {
        	$id = $jsonData[$key]["id"];
			$name = $jsonData[$key]["name"];
			ChromePhp::log($id);
			ChromePhp::log($name);
			$realItem = model::global_instance()->items[$key][$id];
			//ChromePhp::log($key . " in php-model: ");
			ChromePhp::log($realItem);
			$this->mergeData($jsonData, $realItem);
			continue;
            foreach ($jsonData[$key] as $jsonValue)
            {
            	//ChromePhp::log($jsonData[$key]);
                $id = $jsonType["id"];
				ChromePhp::log($jsonValue . " Key=" . $key);    
                $realItem = model::global_instance()->items[$key][$id];
                ChromePhp::log($realItem);      
                $this->mergeData($jsonValue, $realItem);
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
        
        if(array_key_exists($obj->id, model::global_instance()->$users))
        {
            
            $existingItem = model::global_instance()->$users[$obj->id ];
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
		ChromePhp::log("keys " . $keys );
        foreach($keys as $key)
        {
        	ChromePhp::log("key " . $key );
            $value = $jsonObj[$key];
			ChromePhp::log("value " . $value );
            $prop = $instanceReflect->getProperty($key);
			ChromePhp::log("prop " . $prop );
            if($prop->getValue($modelObj) != $value)
            {
                $this->changeValue($prop, $modelObj, $value);
            }
        }
    }

    function changeValue($prop, $modelObj, $newValue)
    {
        $prop->setValue($modelObj ,$newValue);
		ChromePhp::log("changed value to " . $newValue);
    }
    
    function changeReferences()
    {
        
    }
    
}
?>