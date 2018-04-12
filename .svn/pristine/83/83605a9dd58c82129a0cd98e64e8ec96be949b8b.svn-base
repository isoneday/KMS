<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DoUpload.html.class.php
 *
 * @author apriskiswandi
 * 
 */
class DoUpload extends HtmlResponse {

    function TemplateModule() {
        $this->SetTemplateBasedir(Configuration::Instance()->GetValue('application', 'docroot') . 'module/comp.upload/template');
        $this->SetTemplateFile('upload.html');
    }

    function ProcessRequest() {

        $maxsizeupload = $this->return_bytes(ini_get("upload_max_filesize"));
        $maxsizepost = $this->return_bytes(ini_get("post_max_size"));
        $maxmemorylimit = $this->return_bytes(ini_get('memory_limit'));
        $alowsize = min($maxmemorylimit, $maxsizepost, $maxsizeupload);

        $url = GtfwDispt()->GetUrl('comp.upload', 'upload', 'do', 'html') . '&mode=upload&ascomponent=1&targetmod=' . GtfwDispt()->mModule;
        $urlimage = GtfwDispt()->GetUrl('comp.upload', 'upload', 'do', 'html') . '&mode=getimage&ascomponent=1&targetmod=' . GtfwDispt()->mModule;        
        $multi = "false";
        $auto = "true";
        $waitupload = "false";
        $wlext = "jpg,png,jpeg,gif,pdf";
        $maxsize = $alowsize;
        $preview = "false";

        $return = array();

        if (!isset($_GET['mode'])) {
            unset($_SESSION['gtupload']);
            $msg = Messenger::Instance()->Receive(__FILE__);
            if (!empty($msg[0])) {
                if (isset($msg[0]['url'])) {
                    $url = $msg[0]['url'];
                }
                if (isset($msg[0]['multi'])) {
                    if ($msg[0]['multi']) {
                        $multi = "true";
                    } else {
                        $multi = "false";
                    }
                }
                if (isset($msg[0]['auto'])) {
                    if ($msg[0]['auto']) {
                        $auto = "true";
                    } else {
                        $auto = "false";
                    }
                }
                if (isset($msg[0]['waitupload'])) {
                    if ($msg[0]['waitupload']) {
                        $waitupload = "true";
                    } else {
                        $waitupload = "false";
                    }
                }
                if (isset($msg[0]['wlext'])) {
                    $wlext = $msg[0]['wlext'];
                }
                if (isset($msg[0]['maxsize'])) {
                    if ($msg[0]['maxsize'] < $maxsize) {
                        $maxsize = $msg[0]['maxsize'];
                    }
                }
                if (isset($msg[0]['preview'])) {
                    if ($msg[0]['preview']) {
                        $preview = "true";
                    } else {
                        $preview = "false";
                    }
                }
            }
            $options = '{url:"' . $url . '",multi:' . $multi . ',wlext:"' . $wlext . '",auto:' . $auto . ',waitupload:' . $waitupload . ',maxsize:' . $maxsize . ',preview:' . $preview . ',urlimage:"'.$urlimage.'"}';
            if (isset($msg[0]['form'])) {
                $return['js'] = '<script type="text/javascript"> $("' . $msg[0]['form'] . '").gtupload(' . $options . '); </script>';
            }
        } else {

            if ($_GET['mode'] == "upload") {
                if (!empty($_FILES)) {
                    $key = array_keys($_FILES);
                    $nameinput = $key[0];
                    if (isset($_SESSION['gtupload'])) {
                        $upload = $_SESSION['gtupload'];
                    } else {
                        $upload = array();
                    }
                    if (!is_array($_FILES[$nameinput]['name'])) {
                        $dirtemp = dirname($_FILES[$nameinput]['tmp_name']);
                        $basenametemp = basename($_FILES[$nameinput]['tmp_name']);
                        $newname="gt" . @date("Ymdhis");
                        $newtmpfile = $dirtemp .'/'. $newname;
                        if (@move_uploaded_file($_FILES[$nameinput]['tmp_name'], $newtmpfile)) {
                            $upload[$nameinput]['name'] = $_FILES[$nameinput]['name'];
                            $upload[$nameinput]['type'] = $_FILES[$nameinput]['type'];
                            $upload[$nameinput]['tmp_name'] = $newtmpfile;
                            $upload[$nameinput]['error'] = $_FILES[$nameinput]['error'];
                            $upload[$nameinput]['size'] = $_FILES[$nameinput]['size'];
							if($preview){
								if (file_exists($newtmpfile)) {
									$size = $this->is_image($newtmpfile);
									if ($size !== false && isset($size['mime'])) {
										$imagedata = @file_get_contents($newtmpfile);
										$base64 = @base64_encode($imagedata);
										if ($base64 !== false) {
											$result=array("w"=>$size[0],"h"=>$size[1],"data"=>"data:" . $size['mime'] . ";base64," . $base64 . "");

										}
									}
								}
							}
							$result['status']="ok";
							$result['msg']="";
                            echo json_encode($result);
                        } else {
                            echo json_encode(array("status" => "no", "msg" => 'internal server error, try again.',"data"=>'err'));
                        }
                    } else {
                        $dirtemp = dirname($_FILES[$nameinput]['tmp_name'][0]);
                        $basenametemp = basename($_FILES[$nameinput]['tmp_name'][0]);
                        $newname="gt" . @date("Ymdhis");
                        $newtmpfile = $dirtemp .'/'. $newname;
                        if (@move_uploaded_file($_FILES[$nameinput]['tmp_name'][0], $newtmpfile)) {
                            $upload[$nameinput]['name'][] = $_FILES[$nameinput]['name'][0];
                            $upload[$nameinput]['type'][] = $_FILES[$nameinput]['type'][0];
                            $upload[$nameinput]['tmp_name'][] = $newtmpfile;
                            $upload[$nameinput]['error'][] = $_FILES[$nameinput]['error'][0];
                            $upload[$nameinput]['size'][] = $_FILES[$nameinput]['size'][0];
							if($preview){
								if (file_exists($newtmpfile)) {
									$size = $this->is_image($newtmpfile);
									if ($size !== false && isset($size['mime'])) {
										$imagedata = @file_get_contents($newtmpfile);
										$base64 = @base64_encode($imagedata);
										if ($base64 !== false) {
											$result=array("w"=>$size[0],"h"=>$size[1],"data"=>"data:" . $size['mime'] . ";base64," . $base64 . "");

										}
									}
								}
							}
							$result['status']="ok";
							$result['msg']="";
                            echo json_encode($result);
                        } else {
                            echo json_encode(array("status" => "no", "msg" => 'internal server error, try again.',"data"=>'err'));
                        }
                    }
                    $_SESSION['gtupload'] = $upload;
                    exit;
                }
            } elseif ($_GET['mode'] == "getimage") {
                $filenamet = $_GET['t'];
 
                $filename=base64_decode($filenamet);
                if (file_exists($filename)) {
                    $size = $this->is_image($filename);
                    if ($size !== false && isset($size['mime'])) {
                        $imagedata = @file_get_contents($filename);
                        $base64 = @base64_encode($imagedata);
                        if ($base64 !== false) {
                            $resimg=array("w"=>$size[0],"h"=>$size[1],"data"=>"data:" . $size['mime'] . ";base64," . $base64 . "");
                            echo json_encode($resimg);
                            exit;
                        }
                    }
                }
                echo json_encode(array("data"=>"err"));
                exit;
            }
        }

        return $return;
    }

    function is_image($path) {
        $size = @getimagesize($path);
        $image_type = $size[2];

        if (in_array($image_type, array(IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_BMP))) {
            return $size;
        }
        return false;
    }

    function return_bytes($val) {
        $val = trim($val);
        $last = strtolower($val[strlen($val) - 1]);
        switch ($last) {
            case 'g':
                $val *= 1024;
            case 'm':
                $val *= 1024;
            case 'k':
                $val *= 1024;
        }

        return $val;
    }

    function ParseTemplate($data = NULL) {
        if (!empty($data)) {
            if (isset($data['js'])) {
                $this->mrTemplate->addVar('content', 'UPLOAD_JS', $data['js']);
            }
        }
    }

}

?>
