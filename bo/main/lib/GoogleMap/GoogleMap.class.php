<?php

require_once 'GoogleMap.php';
require_once 'JSMin.php';

class GT_GoogleMap extends GoogleMapAPI {

    /**
     * class constructor
     *
     * @param array or param 
     */
    public function __construct($params = NULL)
    {
        $map_id = 'map';
        $app_id = 'MyMapApp';
        // override from params
        if (is_array($params)) {
            extract($params);
        }
        parent::GoogleMapAPI($map_id, $app_id);
    }

}