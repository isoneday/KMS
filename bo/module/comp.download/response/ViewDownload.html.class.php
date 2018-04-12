<?php
/**
 * @author Prima Noor 
 */
   
class ViewDownload extends HtmlResponse
{
   
   	function ProcessRequest()
   	{	
   	    if (!empty($_GET['file'])) {
   	        $path = $_GET['file']->SqlString()->Raw();
   	        $filename = !empty($_GET['name'])?$_GET['name']->SqlString()->Raw():$path;
            foreach(array($path, Dispatcher::Instance()->Decrypt($path)) as $val) {
                if (file_exists($val)) {                        
                    $mime = 'application/octet-stream';
                    header("Content-type: application/octet-stream");
                    header('Content-Disposition: attachment; filename="' . basename($filename) . '"');
                    if (strpos($_SERVER['HTTP_USER_AGENT'], "MSIE") !== FALSE){
                        header('Expires: 0');
            			header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            			header("Content-Transfer-Encoding: binary");
                        header('Pragma: public');
                    } else {
                        header("Content-Transfer-Encoding: binary");
            			header('Expires: 0');
            			header('Pragma: no-cache');
                    }
                    header("Content-Length: " . filesize($val));
                    readfile($val);
                }   
            }
        } else {
            echo GtfwLangText('please_specify_file_to_download');
            exit;
        }
   	}
}
?>