<?php
include_once 'jsonBase.php';
class user extends jsonBase
{
    public $name;
    public $email;
    public $votes = array();
    public $comments = array();
    public $source;
    public $id;
}
?>