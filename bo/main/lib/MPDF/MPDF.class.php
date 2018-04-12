<?php

/**
 * PT. Gamatechno Indonesia
 */
require_once 'MPDF57/mpdf.php';

class GT_MPDF extends mpdf 
{

    public function __construct($mode='',$format='A4',$default_font_size=0,$default_font='',$mgl=15,$mgr=15,$mgt=16,$mgb=16,$mgh=9,$mgf=9, $orientation='P') 
    {
        parent::__construct($mode,$format,$default_font_size,$default_font,$mgl,$mgr,$mgt,$mgb,$mgh,$mgf, $orientation);
    }

}

?>
