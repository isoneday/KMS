<?php
/**
 * File to enable reading text or HTML from a file 
 * 
 *
 */
class FiletoText
{
    private $path, $extension; 

    function __construct($filepath, $fileextension) {
        $this->path = $filepath; // absolute path to the file do whatever conversions you need to do here 
        $this->extension = $fileextension; 
    }
    
    /**
     * Return the text or HTML from the file 
     * 
     * @return String 
     */
    function getText() {
        switch ($this->extension) {
            case "doc"; 
            case "docx";
            case "rtf"; 
                $mailMerge = new Zend_Service_LiveDocx_MailMerge();
                $mailMerge->setUsername('username')->setPassword('password'); // credetnials 
                $mailMerge->setLocalTemplate($this->path);
                $mailMerge->assign(null);  // must be called as of phpLiveDocx 1.2
                $mailMerge->createDocument();
                return $mailMerge->retrieveDocument('html');
                break;
                
           case "pdf";
               $a = new PDF2Text(); 
               $a->setFilename($this->path); //grab the test file at http://www.newyorklivearts.org/Videographer_RFP.pdf
               $a->decodePDF();
               return $a->output();
               break;
               
           case "xls"; 
           case "xlsx"; 
               $html_writer = new PHPExcel_Writer_HTML(PHPExcel_IOFactory::load($this->path)); 
               
               $tmp_file_name = time().".htm"; 
               $html_writer->save($tmp_file_name); 
               return file_get_contents($tmp_file_name); 
               
            default: 
                return ""; 
        }
    }
}