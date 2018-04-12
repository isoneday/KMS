<?php
/**
 * @author Prima Noor
 */
 
class ProcessModKmsproblem
{
    var $Obj;
    var $user;
    var $cssDone = 'notebox-done';
    var $cssFail = 'notebox-warning';
    var $cssAlert = 'notebox-alert';

    function __construct()
    {
        $this->ObjModKmsproblem = GtfwDispt()->load->business('ModKmsproblem');
        $this->user = Security::Authentication()->GetCurrentUser()->GetUserId();
    }

    function input()
    {
        $post = $_POST->AsArray();
        $Val = GtfwDispt()->load->library('Validation');
        
        
        $Val->set_rules('problemm', GtfwLangText('problemm'), 'required');
        $Val->set_rules('person_request', GtfwLangText('person_request'), 'required');
        $Val->set_rules('person_solving', GtfwLangText('person_solving'), 'required');
        $Val->set_rules('pic', GtfwLangText('PIC'), 'required');
        $Val->set_rules('status', GtfwLangText('status'), 'required');
        $Val->set_rules('catatan', GtfwLangText('catatan'), 'required');
        
        $result = $Val->run();
        $file_path = Configuration::Instance()->GetValue('application', 'aplikan_filedata');
        $config = array(
            "dest" => $file_path,
            "ext" => "txt,doc,DOC,docx,DOCX,pdf,PDF,jpg,jpeg,JPG,JPEG,png,PNG",
       
            "maxsize" => 12097152
        );
        $upload_file = $this->uploadFile('lam_filedata', $config);
        if ($upload_file != null) {
            if ($upload_file['lam_filedata']['error'] === false) {
                $post['lam_filedata_file']          = $upload_file['lam_filedata']['name_enc'];
                $post['lam_filedata_file_origin']   = $upload_file['lam_filedata']['name_ori'];
                $post['lam_filedata_file_path']     = $upload_file['lam_filedata']['file_path'];
                $post['lam_filedata_file_type']     = $upload_file['lam_filedata']['file_ext'];
                $post['lam_filedata_file_size']     = $upload_file['lam_filedata']['file_size'];
            }
        }        
     $upload_file2 = $this->uploadFile2('lam_filedata2', $config);
       if ($upload_file2 != null) {
            if ($upload_file2['lam_filedata2']['error'] === false) {
                $post['lam_filedata_file2']          = $upload_file2['lam_filedata2']['name_enc2'];
                $post['lam_filedata_file_origin2']   = $upload_file2['lam_filedata2']['name_ori2'];
                $post['lam_filedata_file_path2']     = $upload_file2['lam_filedata2']['file_path2'];
                $post['lam_filedata_file_type2']     = $upload_file2['lam_filedata2']['file_ext2'];
                $post['lam_filedata_file_size2']     = $upload_file2['lam_filedata2']['file_size2'];
            }
        }        
     $upload_file3 = $this->uploadFile3('lam_filedata3', $config);
       if ($upload_file3 != null) {
            if ($upload_file3['lam_filedata3']['error'] === false) {
                $post['lam_filedata_file3']          = $upload_file3['lam_filedata3']['name_enc3'];
                $post['lam_filedata_file_origin3']   = $upload_file3['lam_filedata3']['name_ori3'];
                $post['lam_filedata_file_path3']     = $upload_file3['lam_filedata3']['file_path3'];
                $post['lam_filedata_file_type3']     = $upload_file3['lam_filedata3']['file_ext3'];
                $post['lam_filedata_file_size3']     = $upload_file3['lam_filedata3']['file_size3'];
            }
        }        
      
        if ($result) {
            if (!$post['id']) {
                $this->ObjModKmsproblem->StartTrans();
                $params = array(
                  $this->user,
                    $post['problemm'],
                    $post['person_request'],
                    $post['person_solving'],
                    $post['pic'],
                    $post['status'],
                    $post['catatan'],
                    (isset($post['lam_filedata_file']) ? $post['lam_filedata_file'] : null),
                    (isset($post['lam_filedata_file_origin']) ? $post['lam_filedata_file_origin'] : null),
                    (isset($post['lam_filedata_file_path']) ? $post['lam_filedata_file_path'] : null),
                    (isset($post['lam_filedata_file_type']) ? $post['lam_filedata_file_type'] : null),
                    (isset($post['lam_filedata_file_size']) ? $post['lam_filedata_file_size'] : null),
                    (isset($post['lam_filedata_file2']) ? $post['lam_filedata_file2'] : null),
                    (isset($post['lam_filedata_file_origin2']) ? $post['lam_filedata_file_origin2'] : null),
                    (isset($post['lam_filedata_file_path2']) ? $post['lam_filedata_file_path2'] : null),
                    (isset($post['lam_filedata_file_type2']) ? $post['lam_filedata_file_type2'] : null),
                    (isset($post['lam_filedata_file_size2']) ? $post['lam_filedata_file_size2'] : null),
                    (isset($post['lam_filedata_file3']) ? $post['lam_filedata_file3'] : null),
                    (isset($post['lam_filedata_file_origin3']) ? $post['lam_filedata_file_origin3'] : null),
                    (isset($post['lam_filedata_file_path3']) ? $post['lam_filedata_file_path3'] : null),
                    (isset($post['lam_filedata_file_type3']) ? $post['lam_filedata_file_type3'] : null),
                    (isset($post['lam_filedata_file_size3']) ? $post['lam_filedata_file_size3'] : null)
                   
                   );
                $result = $result && $this->ObjModKmsproblem->insertModKmsproblem($params);
                $this->ObjModKmsproblem->EndTrans($result);
                if ($result) {
                    $msg = GtfwLangText('msg_add_success');
                    $css = $this->cssDone;
                } else {
                    $msg = GtfwLangText('msg_add_fail');
                    $css = $this->cssFail;
                }
            } else {
                $this->ObjModKmsproblem->StartTrans();
                $params = array(
                    $post['problemm'],
                    $post['person_request'],
                    $post['person_solving'],
                    $post['pic'],
                    $post['status'],
                    $post['catatan'],
                    (isset($post['lam_filedata_file']) ? $post['lam_filedata_file']),
                    (isset($post['lam_filedata_file_origin']) ? $post['lam_filedata_file_origin']),
                    (isset($post['lam_filedata_file_path']) ? $post['lam_filedata_file_path']),
                    (isset($post['lam_filedata_file_type']) ? $post['lam_filedata_file_type']),
                    (isset($post['lam_filedata_file_size']) ? $post['lam_filedata_file_size']),
                    (isset($post['lam_filedata_file2']) ? $post['lam_filedata_file2']),
                    (isset($post['lam_filedata_file_origin2']) ? $post['lam_filedata_file_origin2']),
                    (isset($post['lam_filedata_file_path2']) ? $post['lam_filedata_file_path2']),
                    (isset($post['lam_filedata_file_type2']) ? $post['lam_filedata_file_type2']),
                    (isset($post['lam_filedata_file_size2']) ? $post['lam_filedata_file_size2']),
                    (isset($post['lam_filedata_file3']) ? $post['lam_filedata_file3']),
                    (isset($post['lam_filedata_file_origin3']) ? $post['lam_filedata_file_origin3']),
                    (isset($post['lam_filedata_file_path3']) ? $post['lam_filedata_file_path3']),
                    (isset($post['lam_filedata_file_type3']) ? $post['lam_filedata_file_type3']),
                    (isset($post['lam_filedata_file_size3']) ? $post['lam_filedata_file_size3']),
                   
                    $post['id']
                );
                $result = $result && $this->ObjModKmsproblem->updateModKmsproblem($params);
                $this->ObjModKmsproblem->EndTrans($result);   
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

           Messenger::Instance()->Send('mod.kmsproblem', 'ModKmsproblem', 'view', 'html', array(NULL, $msg, $css), Messenger::NextRequest);
//           return Dispatcher::Instance()->GetUrl('mod.kmsproblem', 'modkmsproblem', 'view', 'html');

        } else {
            Messenger::Instance()->Send('mod.kmsproblem', 'inputModKmsproblem', 'view', 'html', array($post, $msg, $css), Messenger::NextRequest);
          //  return Dispatcher::Instance()->GetUrl('mod.kmsproblem', (empty($post['id'])?'add':'update').'ModKmsproblem', 'view', 'html');
        }
        return $result;     
    }
    
    function delete($id)
    {
        $result = $this->ObjModKmsproblem->deleteModKmsproblem($id);
        if ($result) {
            $msg = GtfwLangText('msg_delete_success');
            $css = $this->cssDone;
        } else {
            $msg = GtfwLangText('msg_delete_fail');
            $css = $this->cssFail;            
        }
        Messenger::Instance()->Send('mod.kmsproblem', 'ModKmsproblem', 'view', 'html', array(NULL, $msg, $css), Messenger::NextRequest);
        
        return $result;
    }
    function uploadFile($name, $config) {
        if($_FILES[$name]['name'] != ''){
            $errors         = array();
            $file_name      = $_FILES[$name]['name'];
            $file_size      = $_FILES[$name]['size'];
            $file_tmp       = $_FILES[$name]['tmp_name'];
            $file_type      = $_FILES[$name]['type'];
            $file_ext       = strtolower(end(explode('.',$_FILES[$name]['name'])));
            $destination    = Configuration::Instance()->GetValue('application', 'docroot').$config['dest'];
            $listconfig     = explode(',', $config['ext']);

            $randfilename = md5(uniqid(mt_rand())) . '.' . $file_ext;
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
            $data[$name]['file_ext'] = $file_ext;
            $data[$name]['file_size'] = $file_size;
            $data[$name]['full_path'] = $destenc;
            $data[$name]['file_path'] = $destination;
            return $data;
        }

    }
    function uploadFile2($name, $config) {
        if($_FILES[$name]['name'] != ''){
            $errors         = array();
            $file_name      = $_FILES[$name]['name'];
            $file_size      = $_FILES[$name]['size'];
            $file_tmp       = $_FILES[$name]['tmp_name'];
            $file_type      = $_FILES[$name]['type'];
            $file_ext       = strtolower(end(explode('.',$_FILES[$name]['name'])));
            $destination    = Configuration::Instance()->GetValue('application', 'docroot').$config['dest'];
            $listconfig     = explode(',', $config['ext']);

            $randfilename = md5(uniqid(mt_rand())) . '.' . $file_ext;
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
            
            if($file_size2e > $config['maxsize']){
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
            $data[$name]['name_enc2'] = $randfilename;
            $data[$name]['name_ori2'] = $file_name;
            $data[$name]['file_ext2'] = $file_ext;
            $data[$name]['file_size2'] = $file_size;
            $data[$name]['full_path'] = $destenc;
            $data[$name]['file_path2'] = $destination;
            return $data;
        }

    }
    function uploadFile3($name, $config) {
        if($_FILES[$name]['name'] != ''){
            $errors         = array();
            $file_name      = $_FILES[$name]['name'];
            $file_size      = $_FILES[$name]['size'];
            $file_tmp       = $_FILES[$name]['tmp_name'];
            $file_type      = $_FILES[$name]['type'];
            $file_ext       = strtolower(end(explode('.',$_FILES[$name]['name'])));
            $destination    = Configuration::Instance()->GetValue('application', 'docroot').$config['dest'];
            $listconfig     = explode(',', $config['ext']);

            $randfilename = md5(uniqid(mt_rand())) . '.' . $file_ext;
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
            $data[$name]['name_enc3'] = $randfilename;
            $data[$name]['name_ori3'] = $file_name;
            $data[$name]['file_ext3'] = $file_ext;
            $data[$name]['file_size3'] = $file_size;
            $data[$name]['full_path'] = $destenc;
            $data[$name]['file_path3'] = $destination;
            return $data;
        }

    }

}

?>