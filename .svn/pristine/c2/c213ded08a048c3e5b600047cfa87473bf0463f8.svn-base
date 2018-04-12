<?php

/**
 * @author Prima Noor 
 */

class GetUser extends RestResponse
{

    function ProcessRequest()
    {
        $users = array(
            array(
                'id' => 1,
                'name' => 'Some Guy',
                'email' => 'example1@example.com'),
            array(
                'id' => 2,
                'name' => 'Person Face',
                'email' => 'example2@example.com'),
            3 => array(
                'id' => 3,
                'name' => 'Scotty',
                'email' => 'example3@example.com',
                'fact' => array('hobbies' => array('fartings', 'bikes'))),
            );
        $return['data'] = $users;
        $return['code'] = NULL;
        return $return;
    }
}

?>