<?php

class Sample
{
    private $curl;
    
    public function __construct()
    {
        $this->curl = Dispatcher::Instance()->load->library('CURL');
    }
    
    public function getUser()
    {
        $result = $this->curl->simple_get('http://localhost/base_app/api.php?mod=core.sample&sub=user&act=get&typ=json');
        //eval('$result = '.$result.';');
        return $result;            
    }

}
