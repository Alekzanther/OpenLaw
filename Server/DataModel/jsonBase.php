<?php
include_once 'model.php';
class jsonBase
{
    public function toJSON(){
        $reflect = new ReflectionClass($this);
        $props = $reflect->getProperties();
        
        $json = array();
        foreach($props as $prop)
        {
            $value = $prop->getValue($this);
            $name = $prop->getName();
            if($value == NULL)
            {
                //$json[$prop->getName()] = NULL;
            }
            else if(is_array($value) == FALSE && is_object($value) == FALSE)
            {
                $json[$name] = $value;
            }
            else if(is_array($value) == FALSE && is_object($value) == TRUE)
            {
                $json[$name . 'id'] = $value->id;
            }
            else    
            {
                $jsonIds = array();
                $i = 0;
                foreach($value as $obj)
                {
                    $jsonIds[$i] = $obj->id;
                    $i++;
                }
                $json[$name . 'ids'] = $jsonIds;
            }
        }
    
        return json_encode($json);
    }

    static function startsWith($haystack, $needle)
    {
        return $needle === "" || strpos($haystack, $needle) === 0;
    }
    
    static function endsWith($haystack, $needle)
    {
        return $needle === "" || substr($haystack, -strlen($needle)) === $needle;
    }
    
    public function fromJSON($json)
    {
        $obj = json_decode($json);
        $instanceReflect = new ReflectionClass($this);
        $instanceProps = $instanceReflect->getProperties();

        foreach(get_object_vars($obj) as $propName => $newValue) 
        {
            if(self::endsWith($propName,"id"))
            {
                /*Do this somewhere else*/
                
                /*$trans = array("id" => "");
                $propName = strtr($propName, $trans);*/
            }
            else if(self::endsWith($propName,"ids"))
            {
                /*Do this somewhere else*/
                
                /*$trans = array("ids" => "");
                $propName = strtr($propName, $trans);
            
                $prop = $instanceReflect->getProperty($propName);
                $prop->setValue();*/
            }
            else 
            {
                $prop = $instanceReflect->getProperty($propName);
                $prop->setValue($this,$newValue);
            }
        }
        //var_dump($data);
    }
}
?>