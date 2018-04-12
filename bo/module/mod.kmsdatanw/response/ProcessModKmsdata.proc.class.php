<?php
/** 
* @copyright Copyright (c) 2014, PT Gamatechno Indonesia
* @license http://gtfw.gamatechno.com/#license
*/
 
class ProcessModKmsdata
{
    var $Obj;
    var $user;
    var $cssDone = 'notebox-done';
    var $cssFail = 'notebox-warning';
    var $cssAlert = 'notebox-alert';


    function __construct()
    {
        $this->ObjModKmsdata = GtfwDispt()->load->business('ModKmsdata');
        $this->user = Security::Authentication()->GetCurrentUser()->GetUserId();
    }
// function pptx_to_text($input_file){
//     $zip_handle = new ZipArchive;
//     $output_text = "";
//     if(true === $zip_handle->open($input_file)){
//         $slide_number = 1; //loop through slide files
//         while(($xml_index = $zip_handle->locateName("C:\\xampp\\htdocs\\gtfw36cop\\files\\applicant\\registulang\\fileupload\\filetxt".$slide_number.".xml")) !== false){
//             $xml_datas = $zip_handle->getFromIndex($xml_index);
//             $xml_handle = DOMDocument::loadXML($xml_datas, LIBXML_NOENT | LIBXML_XINCLUDE | LIBXML_NOERROR | LIBXML_NOWARNING);
//             $output_text .= strip_tags($xml_handle->saveXML());
//             $slide_number++;
//         }
//         if($slide_number == 1){
//             $output_text .="";
//         }
//         $zip_handle->close();
//     }else{
//     $output_text .="";
//     }
//     return $output_text;
// }

//echo pptx_to_text("C:\Users\Iswandi_Saputra\Downloads\pptx to txt\pptx2txt\pptx2txt-0.1\aha.pptx");

    function input()
    {
        $post = $_POST->AsArray();
        $Val = GtfwDispt()->load->library('Validation');
      //   $dataFoto = $ObjModKmsdata->GetListFoto($id);
       
        $result = $Val->run();
        $file_path = Configuration::Instance()->GetValue('application', 'aplikan_filedata');
      //  $file_txt = Configuration::Instance()->GetValue('application', 'aplikan_filetxt');
        //return compact('dataFoto');
   
        $config = array(
            "dest" => $file_path,
            "ext" => "iso,txt,doc,DOC,docx,DOCX,pdf,PDF,jpg,jpeg,JPG,JPEG,png,PNG,xls,xlsx,ppt,pptx",
            "maxsize" => 1200
        );
     
        //if(ext=='doc,DOC,docx,DOCX,pdf,PDF'){

//       move_uploaded_file($_FILES['lam_filedata']['tmp_name'], 'C:/xampp/htdocs/gtfw36cop/files/applicant/registulang/fileupload/'.$_FILES['lam_filedata']['name']);

    //}filedata_enc
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
        echo $post['lam_filedata_file_size'];       
        if ($result) {
            if (!$post['id']) {
                $this->ObjModKmsdata->StartTrans();
                $params = array(              
                    $this->user,
                    $post['idmasdok'],
                    $post['kmsdata_keyword'],
                    $post['jenis'],
                    $post['pembicara'],
                    $post['lokasi'],
                    $post['tanggal'],
                    $post['topik'],
                    $post['agenda'],
                    $post['nama_produk'],
                    $post['jenis_produk'],
                    $post['bidang_produk'],
                    $post['keterangan'],
                    $post['status'],
                    (isset($post['lam_filedata_file']) ? $post['lam_filedata_file'] : null),
                    (isset($post['lam_filedata_file_origin']) ? $post['lam_filedata_file_origin'] : null),
                    (isset($post['lam_filedata_file_txt']) ? $post['lam_filedata_file_txt'] : null),
                    (isset($post['lam_filedata_file_path']) ? $post['lam_filedata_file_path'] : null),
                    (isset($post['lam_filedata_file_type']) ? $post['lam_filedata_file_type'] : null),
                    (isset($post['lam_filedata_file_size']) ? $post['lam_filedata_file_size'] : null)
   
                );
              
                $result = $result && $this->ObjModKmsdata->insertModKmsdata($params);
                
                //echo $result;
                //echo "test";
                //die();
                // $paramsDokumen = array(
                //     $this->user,
                //     (isset($post['lam_filedata_file']) ? $post['lam_filedata_file: null),                   
                //     (isset($post['lam_filedata_file_origin']) ? $post['lam_filedata_file_origin'] : null),
                //     (isset($post['lam_filedata_file_path']) ? $post['lam_filedata_file_path'] : null),
                //     (isset($post['lam_filedata_file_type']) ? $post['lam_filedata_file_type'] : null),
                //     (isset($post['lam_filedata_file_size']) ? $post['lam_filedata_file_size'] : null)
               
                // );
 
                // $rsDokumen = $result && $this->ObjModKmsdata->insertModKmsDokumen($paramsDokumen);
                $eksfile=$post['lam_filedata_file_type'];
                $this->ObjModKmsdata->EndTrans($result);
                if ($result) {
    if (!empty($eksfile)) {
          if($eksfile=="docx"){
                $gab=$post['lam_filedata_file_path'].$post['lam_filedata_file'];
                $cmd=shell_exec('C:\\xampp\\htdocs\\gtkms\\files\\applicant\\registulang\\fileupload\\docx2txt\\docx2txt.sh "'.$gab.'" ');
              //  echo $cmd; 
            } else if($eksfile=="pdf"){
              $gabb=$post['lam_filedata_file_path'].$post['lam_filedata_file']; 
              $cmd=shell_exec('C:\\xampp\\htdocs\\gtkms\\files\\applicant\\registulang\\fileupload\\pdf2txt\\pdftotext.exe "'.$gabb.'"'); 
              // echo $cmd; 
             }
        else if($eksfile=="doc"){
            //  $minname=substr($post['lam_filedata_file'],0,-4).".txt";
            $gab=$post['lam_filedata_file_path'].$post['lam_filedata_file'];
            $gab2=$post['lam_filedata_file_path'].substr($post['lam_filedata_file'],0,-4).".txt";
               // $dsd =`>`;
            $cmd= shell_exec('C:\\xampp\\htdocs\\gtkms\\files\\applicant\\registulang\\fileupload\\antiword1\\antiword.exe -f "'.$gab.'" > "'.$gab2.'"');   
  }        else if($eksfile=="xlsx"or$eksfile=="xls"){
           $gab3=$post['lam_filedata_file_path'].$post['lam_filedata_file'];
           $cmd=shell_exec('C:\\xampp\\htdocs\\gtkms\\files\\applicant\\registulang\\fileupload\\xlstocsv\\XlsToCsv.vbs "'.$gab3.'" ');
           
           }
           else if($eksfile=="pptx"){
           $gabu=$post['lam_filedata_file_path'].$post['lam_filedata_file'];
           $gal=$post['lam_filedata_file'];
           $cmd=shell_exec('C:\\xampp\\htdocs\\gtkms\\files\\applicant\\registulang\\fileupload\\pptx2txtt\\pptx2txt.sh "'.$gabu.'" ');
           
         }
   else {

   }
        }

                    $msg = GtfwLangText('msg_add_success');
                    $css = $this->cssDone;
                } else {
                    $msg = GtfwLangText('msg_add_fail');
                    $css = $this->cssFail;           }
     
//       echo $cmd2; 

            } 

            else {
                $this->ObjModKmsdata->StartTrans();
                $params = array(
                    $post['kmsdata_keyword'],
                    $post['jenis'],
                    $post['pembicara'],
                    $post['lokasi'],
                    $post['tanggal'],
                    $post['topik'],
                    $post['agenda'],
                    $post['nama_produk'],
                    $post['jenis_produk'],
                    $post['bidang_produk'],
                    $post['keterangan'],
                    $post['status'],
                    (isset($post['lam_filedata_file']) ? $post['lam_filedata_file'] : null),
                    (isset($post['lam_filedata_file_origin']) ? $post['lam_filedata_file_origin'] : null),
                    (isset($post['lam_filedata_file_txt']) ? $post['lam_filedata_file_txt'] : null),
                    (isset($post['lam_filedata_file_path']) ? $post['lam_filedata_file_path'] : null),
                    (isset($post['lam_filedata_file_type']) ? $post['lam_filedata_file_type'] : null),
                    (isset($post['lam_filedata_file_size']) ? $post['lam_filedata_file_size'] : null),
                    $post['id']
                );
                $result = $result && $this->ObjModKmsdata->updateModKmsdata($params);
                $this->ObjModKmsdata->EndTrans($result);   
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
         
          
            Messenger::Instance()->Send('mod.kmsdata', 'ModKmsdata', 'view', 'html', array(NULL, $msg, $css), Messenger::NextRequest);
            //return Dispatcher::Instance()->GetUrl('mod.kmsdata', 'modkmsdata', 'view', 'html');
        } else {
//echo "<pre>".$this->GetLastError();
      
            Messenger::Instance()->Send('mod.kmsdata', 'inputModKmsdata', 'view', 'html', array($post, $msg, $css), Messenger::NextRequest);

            //return Dispatcher::Instance()->GetUrl('mod.kmsdata', (empty($post['id'])?'add':'update').'ModKmsdata', 'view', 'html');
        }


        return $result;     


    }
    
    function delete($id)
    {
       // echo "a";

        $file_path = Configuration::Instance()->GetValue('application', 'aplikan_filedata');
        $getNameFile = $this->ObjModKmsdata->getNameFileById($id);
        $file = $file_path.$getNameFile;
        //echo $file; die();
        @unlink('./'.$file);
       

        $result = $this->ObjModKmsdata->deleteModKmsdata($id);
        if ($result) {
            $msg = GtfwLangText('msg_delete_success');
            $css = $this->cssDone;
        } else {
            $msg = GtfwLangText('msg_delete_fail');
            $css = $this->cssFail;            
        }
        Messenger::Instance()->Send('mod.kmsdata', 'ModKmsdata', 'view', 'html', array(NULL, $msg, $css), Messenger::NextRequest);
        
        return $result;
    }   
 function uploadFile($name, $config) {
        if($_FILES[$name]['name'] != ''){
            $ambil      =    $_POST['idmasdok'];
            $file_ext       = strtolower(end(explode('.',$_FILES[$name]['name'])));
            $randfilename = md5(uniqid(mt_rand())) . '-'.$ambil.'.' . $file_ext;
          
            $errors         = array();
         $file_name      = $_FILES[$name]['name'];
          $hfile_name     =explode(".",$randfilename);
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

    }}

?>