<?php
/**
 * @author Prima Noor 
 */

class DoModule extends HtmlResponse
{
    function ProcessRequest()
    {
        $proses = GtfwDispt()->load->process('Process');

        $urlRedirect = $proses->input();
        
        $this->RedirectTo($urlRedirect.'&display');
        return null;
    }
}

?>