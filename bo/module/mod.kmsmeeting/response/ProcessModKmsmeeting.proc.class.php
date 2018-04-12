<?php
/**
 * @author Prima Noor
 */
 
class ProcessModKmsmeeting
{
    var $Obj;
    var $user;
    var $cssDone = 'notebox-done';
    var $cssFail = 'notebox-warning';
    var $cssAlert = 'notebox-alert';

    function __construct()
    {
        $this->ObjModKmsmeeting = GtfwDispt()->load->business('ModKmsmeeting');
        $this->user = Security::Authentication()->GetCurrentUser()->GetUserId();
    }

    function input()
    {
        $post = $_POST->AsArray();
        $Val = GtfwDispt()->load->library('Validation');
        
        
        $Val->set_rules('topik', GtfwLangText('topik'), 'required');
        $Val->set_rules('pembicara', GtfwLangText('pembicara'), 'required');
        $Val->set_rules('agenda', GtfwLangText('agenda'), 'required');
        $Val->set_rules('jum_peserta', GtfwLangText('jum_peserta'), 'required');
        $Val->set_rules('tanggal', GtfwLangText('tanggal'), 'required');
        
        $result = $Val->run();
        $file_path = Configuration::Instance()->GetValue('application', 'aplikan_filedata');
        $config = array(
            "dest" => $file_path,
            "ext" => "txt,doc,DOC,docx,DOCX,pdf,PDF,jpg,jpeg,JPG,JPEG,png,PNG,xls,xlsx,ppt,pptx",
       
            "maxsize" => 12097152
        );
        $upload_file = $this->uploadFile('lam_filedata', $config);
      if ($upload_file != null) {
            if ($upload_file['lam_filedata']['error'] === false) {
                $post['lam_filedata_file']          = $upload_file['lam_filedata']['name_enc'];
                $post['lam_filedata_file_origin']   = $upload_file['lam_filedata']['name_ori'];
                $post['lam_filedata_file_txt']      = $upload_file['lam_filedata']['name_txt'];
                $post['lam_filedata_file_path']     = $upload_file['lam_filedata']['file_path'];
                $post['lam_filedata_file_type']     = $upload_file['lam_filedata']['file_ext'];
                $post['lam_filedata_file_size']     = $upload_file['lam_filedata']['file_size'];
            }
        }        
    
        if ($result) {
            if (!$post['id']) {
                $this->ObjModKmsmeeting->StartTrans();
                $params = array(
                    $this->user,
               
                    $post['topik'],
                    $post['pembicara'],
                    $post['agenda'],
                    $post['jum_peserta'],
                    $post['tanggal'],
                    (isset($post['lam_filedata_file']) ? $post['lam_filedata_file'] : null),
                    (isset($post['lam_filedata_file_origin']) ? $post['lam_filedata_file_origin'] : null),
                    (isset($post['lam_filedata_file_txt']) ? $post['lam_filedata_file_txt'] : null),
                    (isset($post['lam_filedata_file_path']) ? $post['lam_filedata_file_path'] : null),
                    (isset($post['lam_filedata_file_type']) ? $post['lam_filedata_file_type'] : null),
                    (isset($post['lam_filedata_file_size']) ? $post['lam_filedata_file_size'] : null)
                  
                );
                $result = $result && $this->ObjModKmsmeeting->insertModKmsmeeting($params);
                $this->ObjModKmsmeeting->EndTrans($result);
                if ($result) {
                    $msg = GtfwLangText('msg_add_success');
                    $css = $this->cssDone;
                } else {
                    $msg = GtfwLangText('msg_add_fail');
                    $css = $this->cssFail;
                }
            } else {
                $this->ObjModKmsmeeting->StartTrans();
                $params = array(
                    $post['topik'],
                    $post['pembicara'],
                    $post['agenda'],
                    $post['jum_peserta'],
                    $post['tanggal'],
                    (isset($post['lam_filedata_file_origin']) ? $post['lam_filedata_file_origin'] : null),
                       (isset($post['lam_filedata_file']) ? $post['lam_filedata_file'] : null),
                 
                    $post['id']
                );
                $result = $result && $this->ObjModKmsmeeting->updateModKmsmeeting($params);
                $this->ObjModKmsmeeting->EndTrans($result);   
                if ($result) {
                    $msg = GtfwLangText('msg_update_success');
                    $css = $this->cssDone;
                } else {
                    $msg = GtfwLangText('msg_update_fail');
                    $css = $this->cssFail;
                }             
            }
        } else {
            $msg = $Val->error_string('', '<br />');
            $css = $this->cssFail;
        }     
        if ($result) {
            Messenger::Instance()->Send('mod.kmsmeeting', 'ModKmsmeeting', 'view', 'html', array(NULL, $msg, $css), Messenger::NextRequest);
            //return Dispatcher::Instance()->GetUrl('mod.kmsmeeting', 'modkmsmeeting', 'view', 'html');
        } else {
            Messenger::Instance()->Send('mod.kmsmeeting', 'inputModKmsmeeting', 'view', 'html', array($post, $msg, $css), Messenger::NextRequest);
            //return Dispatcher::Instance()->GetUrl('mod.kmsmeeting', (empty($post['id'])?'add':'update').'ModKmsmeeting', 'view', 'html');
        }
        return $result;     
    }
    
    function delete($id)
    {
        $result = $this->ObjModKmsmeeting->deleteModKmsmeeting($id);
        if ($result) {
            $msg = GtfwLangText('msg_delete_success');
            $css = $this->cssDone;
        } else {
            $msg = GtfwLangText('msg_delete_fail');
            $css = $this->cssFail;            
        }
        Messenger::Instance()->Send('mod.kmsmeeting', 'ModKmsmeeting', 'view', 'html', array(NULL, $msg, $css), Messenger::NextRequest);
        
        return $result;
    }
    function uploadFile($name, $config) {
        if($_FILES[$name]['name'] != ''){
            $file_ext       = strtolower(end(explode('.',$_FILES[$name]['name'])));
              $randfilename = md5(uniqid(mt_rand())) . '.' . $file_ext;
            $errors         = array();
         $file_name      = $_FILES[$name]['name'];
         
          $hfile_name     =explode(".",$randfilename);
          $hfile_name =reset($hfile_name);
           if($file_ext=="xlsx"or$file_ext=="xls"){
            $file_txt      =$hfile_name.".csv";
           }
           else{
            $file_txt      =$hfile_name.".txt";
           }
            $file_size      = $_FILES[$name]['size'];
            $file_tmp       = $_FILES[$name]['tmp_name'];
            $file_type      = $_FILES[$name]['type'];
            $destination    = Configuration::Instance()->GetValue('application', 'docroot').$config['dest'];
            $listconfig     = explode(',', $config['ext']);

            $bad = array(
                "<!--",
                "-->",
                "'",
                "<",
                ">",
                '"',
                '&',
                '$',
                '=',
                ';',
                '?',
                '/',
                "%20",
                "%22",
                "%3c", // <
                "%253c", // <
                "%3e", // >
                "%0e", // >
                "%28", // (
                "%29", // )
                "%2528", // (
                "%26", // &
                "%24", // $
                "%3f", // ?
                "%3b", // ;
                "%3d"  // =
            );

            $randfilename = str_replace($bad, '', $randfilename);

            if(in_array($file_ext, $listconfig, true) === false){
                $errors[]="Upload File Error : Extension not allowed.";
            }
            
            if($file_size > $config['maxsize']){
                $errors[]='Upload File Error : Not Allowed Filesize';
            }
            
            if(empty($errors)==true){
                move_uploaded_file($file_tmp, $destination.$randfilename);
                // echo $destination;echo "<br>";
                // echo "Success";
            }else{
                $data[$name]['error'] = true;
                $data[$name]['msg']   = $errors;
                return $data;
            }
            $data[$name]['error'] = false;
            $data[$name]['name_enc'] = $randfilename;
            $data[$name]['name_ori'] = $file_name;
            $data[$name]['name_txt'] = $file_txt;
            $data[$name]['file_ext'] = $file_ext;
            $data[$name]['file_size'] = $file_size;
            $data[$name]['full_path'] = $destenc;
            $data[$name]['file_path'] = $destination;
            return $data;
        }

    }
}

?>