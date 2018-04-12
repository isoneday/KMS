<?php
/**
 * @author Prima Noor
 */
 
class ProcessPackager
{
    var $Obj;
    var $user;
    var $cssDone = 'notebox-done';
    var $cssFail = 'notebox-warning';
    var $cssAlert = 'notebox-alert';
    var $installed_modules = array();
    var $required_folders = array();
    var $required_tables = array();
    var $excluded_files = array();
    var $query = '';

    function __construct()
    {
        $this->Obj = Dispatcher::Instance()->load->business('Packager');
        $this->user = Security::Authentication()->GetCurrentUser()->GetUserId();
    }

    function packageApplication()
    {
        $post = $_POST->AsArray();
        
        $Val = Dispatcher::Instance()->load->library('Validation');
        
        $Val->set_rules('access', 'Modules', 'required');
        
        $result = $Val->run();
        
        if ($result === true) {
            
       	    Configuration::Instance()->Load('packager.conf.php');
            // add folder
            $must_have_files = Configuration::Instance()->GetValue('packager', 'must_have_files');
            if (!empty($must_have_files))
            foreach ($must_have_files as $val) {
                $this->addFile($val);
            }
            // add table
            $must_have_tables = Configuration::Instance()->GetValue('packager', 'must_have_tables');
            if (!empty($must_have_tables))
            foreach ($must_have_tables as $val) {
                $this->addTable($val);
            }
            // add module + folder + table
            $must_have_modules = Configuration::Instance()->GetValue('packager', 'must_have_modules');
            if (!empty($must_have_modules))
            foreach ($must_have_modules as $val) {
                $this->addModule($val);
            }
            // exclude files
            $excluded_files = Configuration::Instance()->GetValue('packager', 'excluded_files');
            if (!empty($excluded_files))
            foreach ($excluded_files as $val) {
                $this->excludeFile($val);
            }
                        
            foreach (explode(',', $post['access']) as $val) {
                $module_name = $this->Obj->getModuleName($val);
                if (!empty($module_name))
                    $this->addModule($module_name); 
            }            
            
            echo '<pre>'; print_r($this->excluded_files); echo '</pre>';
            
            $this->createQuery();

            $file = date('Ymd');
            $zip_file = GTFW_APP_DIR.Configuration::Instance()->GetValue('packager', 'export_folder').'/'.$file.'.zip';
            $this->createZipFile($zip_file);         
            
            echo '<pre>'; print_r($this->required_tables); echo '</pre>';
            echo '<pre>'; print_r($this->required_folders); echo '</pre>';
            echo '<pre>'; print_r($this->installed_modules); echo '</pre>';
            exit;
        } else {
            $msg = $Val->error_string('', '<br />');
            $css = $this->cssFail;
        }
        
        Messenger::Instance()->Send('core.packager', 'applicationPackager', 'view', 'html', array(NULL, $msg, $css), Messenger::NextRequest);
        return $result;
    }
    
    /**
     * create file zip
     * @param string path full
     */
    private function createZipFile($zip_file)
    {
        $zip = new ZipArchive;
        if ($zip->open($zip_file, ZIPARCHIVE::CREATE)===TRUE) 
        {
            foreach ($this->required_folders as $source) {
                if (is_dir($source) === true) {
                    $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source), RecursiveIteratorIterator::SELF_FIRST);
                
                    foreach ($files as $file) {
                        //$file = realpath($file);
                        
                        if (!$this->isExcluded($file->getPathname())){
                            echo '<pre>Included : '; print_r($file); echo '</pre>';                             
                            if (is_dir($file) === true) {                                 
                                $zip->addEmptyDir(str_replace($source . '/', '', $file . '/'));
                            } elseif (is_file($file) === true) {
                                $zip->addFromString(str_replace($source . '/', '', $file), file_get_contents($file));
                            }
                        } else {
                            echo '<pre>Excluded : '; print_r($file); echo '</pre>';
                            continue;   
                        }    
                    }
                }  elseif (is_file($source) === true){
                    $zip->addFromString(basename($source), file_get_contents($source));
                }
            }
            if (!empty($this->query)) {
                $zip->addFromString('database.sql', $this->query);
            }
            $zip->close();
        }        
    }
    
    private function createQuery()
    {   
        if (!empty($this->required_tables)) {
            $now = date('Y-m-d H:i:s');
            $query[] = "
/*
Generated by GTFW Application Packager
@ $now
*********************************************************************
*/


/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;            
            ";
            $pattern = '/ AUTO_INCREMENT=\d+/';
            $replacement = '';
            foreach ($this->required_tables as $table) {
                $query[] = "DROP TABLE IF EXISTS `$table`;";
                $result = $this->Obj->getQueryCreateTable($table);                
                $query[] = preg_replace($pattern, $replacement, $result['Create Table']).';';
                
                $insert_query = '';
                $post = $_POST->AsArray();
                switch ($table) {
                    case 'gtfw_group':
                        $insert_query .= "INSERT INTO gtfw_group VALUES (1,'Administrator','',1,NULL,'0000-00-00 00:00:00',NULL,'0000-00-00 00:00:00');";
                        break;
                    case 'gtfw_user':
                        $insert_query .= "INSERT INTO gtfw_user VALUES (0,'No Body','nobody','nobody@mail.com','',NULL,1,1,0,'id','0000-00-00 00:00:00',NULL,NULL,'0000-00-00 00:00:00',NULL,'0000-00-00 00:00:00'),(1,'Admin','admin','admin@mail.com','21232f297a57a5a743894a0e4a801fc3','',0,1,0,'en','0000-00-00 00:00:00',NULL,NULL,'0000-00-00 00:00:00',NULL,'0000-00-00 00:00:00');";
                        break;
                    case 'gtfw_menu':
                        if (!empty($post['access'])) {
                            $post['access'] = '0,'.$post['access'];
                            $rows = $this->Obj->getMenus(array('ids'=>$post['access']));
                            if (!empty($rows)) {
                                $insert_query .= "INSERT INTO gtfw_menu VALUES ";
                                foreach ($rows as $row) {
                                    $insert_query .= "(";
                                    foreach ($row as $val) {                            
                                        $insert_query .= ($val == ''?"NULL":("'".mysql_real_escape_string($val)."'")).", ";
                                    }
                                    $insert_query = substr($insert_query, 0, -2);
                                    $insert_query .= "), ";
                                }
                                $insert_query = substr($insert_query, 0, -2);
                                $insert_query .= ";";
                            }  
                        }
                        break;
                    case 'gtfw_menu_text':
                        if (!empty($post['access'])) {
                            $post['access'] = '0,'.$post['access'];
                            $rows = $this->Obj->getMenuTexts(array('ids'=>$post['access']));
                            if (!empty($rows)) {
                                $insert_query .= "INSERT INTO gtfw_menu_text VALUES ";
                                foreach ($rows as $row) {
                                    $insert_query .= "(";
                                    foreach ($row as $val) {                            
                                        $insert_query .= "'".mysql_real_escape_string($val)."', ";
                                    }
                                    $insert_query = substr($insert_query, 0, -2);
                                    $insert_query .= "), ";
                                }
                                $insert_query = substr($insert_query, 0, -2);
                                $insert_query .= ";";
                            }  
                        }
                        break;
                    case 'gtfw_module':
                        if (!empty($post['access'])) {
                            $post['access'] = '0,'.$post['access'];
                            $rows = $this->Obj->getModules(array('access'=>'all','menu_ids'=>$post['access']));
                            if (!empty($rows)) {
                                $insert_query .= "INSERT INTO gtfw_module VALUES ";
                                foreach ($rows as $row) {
                                    $insert_query .= "(";
                                    foreach ($row as $val) {                            
                                        $insert_query .= "'".mysql_real_escape_string($val)."', ";
                                    }
                                    $insert_query = substr($insert_query, 0, -2);
                                    $insert_query .= "), ";
                                }
                                $insert_query = substr($insert_query, 0, -2);
                                $insert_query .= ";";
                            }  
                        }
                        break;
                    case 'gtfw_group_menu':
                        if (!empty($post['access'])) {
                            $post['access'] = '0,'.$post['access'];
                            $menu_ids = explode(',', $post['access']);
                            if (!empty($menu_ids)) {
                                $insert_query .= "INSERT INTO gtfw_group_menu VALUES ";
                                foreach ($menu_ids as $menu_id) {
                                    $insert_query .= "($menu_id, 1), ";
                                }
                                $insert_query = substr($insert_query, 0, -2);
                                $insert_query .= ";";
                            }  
                        }
                        break;
                    case 'gtfw_group_module':
                        if (!empty($post['access'])) {
                            $post['access'] = '0,'.$post['access'];
                            $rows = $this->Obj->getModules(array('menu_ids'=>$post['access']));
                            if (!empty($rows)) {
                                $insert_query .= "INSERT INTO gtfw_group_module VALUES ";
                                foreach ($rows as $row) {
                                    $insert_query .= "(1, $row[module_id]), ";
                                }
                                $insert_query = substr($insert_query, 0, -2);
                                $insert_query .= ";";
                            }  
                        }
                        break;
                    default:
                        $rows = $this->Obj->getAllTableData($table);
                        if (!empty($rows)) {
                            $insert_query .= "INSERT INTO $table VALUES ";
                            foreach ($rows as $row) {
                                $insert_query .= "(";
                                foreach ($row as $val) {                            
                                    $insert_query .= "'".mysql_real_escape_string($val)."', ";
                                }
                                $insert_query = substr($insert_query, 0, -2);
                                $insert_query .= "), ";
                            }
                            $insert_query = substr($insert_query, 0, -2);
                            $insert_query .= ";";
                        }                     
                }
                
                
                $query[] = $insert_query;
                
            }
            $query[] = "
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;            
            ";
            $this->query = implode("\n\n", $query);
        }
    }
    
    private function addModule($module)
    {
        if (!in_array($module, $this->installed_modules)) {
            $this->installed_modules[] = $module;
            $this->addFile('module'.DIRECTORY_SEPARATOR.$module);
        }
            
        $filename = GTFW_APP_DIR."module/$module/package.json";
        //$filename = 'E:\\www\\base_app\\modules\\core.group\\package.json';        
        if ($handle = @fopen($filename, "r")) {
            $contents = fread($handle, filesize($filename));
            
            $package = json_decode($contents);
            
            if (!empty($package->require->modules)) {
                foreach ($package->require->modules as $req) {
                    $this->addModule($req);
                }
            }            
            
            if (!empty($package->require->libraries)) {
                foreach ($package->require->libraries as $req) {
                    $this->addFile('main/lib/'.$req);
                }
            }
            
            if (!empty($package->table)) {
                foreach ($package->table as $val) {
                    $this->addTable($val);
                }
            
            }
            
            fclose($handle);
        }
    }
    
    private function addTable($table)
    {
        if (!in_array($table, $this->required_tables))
            $this->required_tables[] = $table;
    }
    
    private function addFile($file)
    {
        $file = str_replace('\\', DIRECTORY_SEPARATOR, $file);
        $file = str_replace('/', DIRECTORY_SEPARATOR, $file);
        
        if (!in_array($file, $this->required_folders))
            $this->required_folders[] = $file;
    }
    
    private function excludeFile($file)
    {
        $file = str_replace('\\', DIRECTORY_SEPARATOR, $file);
        $file = str_replace('/', DIRECTORY_SEPARATOR, $file);
        
        if ((is_dir(GTFW_APP_DIR.$file) OR is_file(GTFW_APP_DIR.$file)) AND !in_array($file, $this->excluded_files))
            $this->excluded_files[] = $file;
        
    }
    
    private function isExcluded($file)
    {
        $return = false;
        foreach ($this->excluded_files as $val) {
            $pos = strpos($file, $val);
            if ($pos !== false AND $pos === 0) {
                $return = true;
                break;
            } 
        }
        return $return;
    }
    
    private function myFlush()
    {
        ob_end_flush();
	    if( ob_get_flush() )
	    	ob_flush();
	    flush();
	    ob_start(); 
	}
}

?>