<?php
include_once 'model.php';
class jsonBase
{   
    public function toJSON(){
        $reflect = new ReflectionClass($this);
        $props = $reflect->getProperties();
        
        $json = array();
        $json["type"] = $reflect->getShortName();
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


    
    
}
?>