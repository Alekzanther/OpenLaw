<?php
//session_start();
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
        if(self::$singleton_instance === null) {
            self::$singleton_instance = new dataAccess();
			ChromePhp::log("DATA ACCESS INIT");
        }
         
        return(self::$singleton_instance);
    }
    
	public function authenticateUser($username, $password)
	{
		
		$userExists = FALSE;
		foreach (model::global_instance()->items["user"] as $user) {
			if ($user->name == $username) {
				$_SESSION["username"] = $username;
				$userExists = TRUE; 
			}
		}
		
		if (!$userExists) {
			ChromePhp::log("Illegal login, terminating session! Cya around...");
			$_SESSION["username"] = "";
		}
		
		ChromePhp::log("SESSION : " . $_SESSION["username"]);
		
	}
	
    
    function getData($param)
    {
    	if ($_SESSION["username"] != "") {
    		return json_encode(model::global_instance()->items);		
    	}
		return "";
    }
    
    public function setData($type ,$json)
    {
        $jsonData = json_decode($json,true);
        $keys = array_keys($jsonData);
		 
		//ChromePhp::log($jsonData);
        foreach($keys as $key)
        {
        	$id = $jsonData[$key]["id"];
			//$name = $jsonData[$key]["name"];
			//$value = $jsonData[$key]["value"];
			//ChromePhp::log($id);
			//ChromePhp::log($name);
			//ChromePhp::log($value);
			$realItem = model::global_instance()->items[$key][$id];
			//ChromePhp::log($key . " in php-model: ");
			//ChromePhp::log($realItem);
			$this->mergeData($jsonData, $realItem);            
        }
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
        $objects = array_keys($jsonObj);
		//ChromePhp::log("objects " . $objects );
        foreach($objects as $object)
        {
        	//ChromePhp::log("object " . gettype($object) );
            $value = $jsonObj[$object];
			foreach(array_keys($value) as $key)
			{
				//ChromePhp::log("prop " . $key);
				//ChromePhp::log("value " . $value[$key] );
				
				if (property_exists($object, $key))
				{
					$prop = $instanceReflect->getProperty($key);
					
		            if($prop->getValue($modelObj) != $value[$key])
		            {
		                model::global_instance()->changeValue($prop, $modelObj, $value[$key]);
		            }
				}
				else {
					//ChromePhp::log("Could not find key " . $key );
				}
			}
        }
    }

    
    
    function changeReferences()
    {
        
    }
    
}
?>