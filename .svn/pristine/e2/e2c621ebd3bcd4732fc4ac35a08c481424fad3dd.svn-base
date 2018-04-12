<?php

function generateImgTag($file, $attributes = array())
{
    $tag = '';
    if ($fp = fopen($file, "rb", 0)) {
        $picture = fread($fp, filesize($file));
        fclose($fp);
        // base64 encode the binary data, then break it
        // into chunks according to RFC 2045 semantics
        $base64 = chunk_split(base64_encode($picture));
        $x = explode('.', $file);
        $extension = end($x);
        $attr = '';
        if (!empty($attributes)) {
            foreach ($attributes as $key => $val) {
                $attr .= $key . '="' . $val . '" ';
            }
        }
        $tag = '<img ' . 'src="data:image/' . $extension . ';base64,' . $base64 . '"'.$attr.' />';
    }
    //    if (file_exists($file)) {
    //        $data = file_get_contents($file);
    //        $image_data = base64_encode($data);
    //
    //        $tag = "<img ";
    //        $x = explode('.', $file);
    //		$extension = end($x);
    //        $tag .= 'src="image/'.$extension.';base64,'.$image_data.'" ';
    //        if(!empty($attributes)){
    //            foreach ($attributes as $key => $val) {
    //                $tag .= $key.'="'.$val.'" ';
    //            }
    //        }
    //        $tag .= ' />';
    //    }
    return $tag;
}

// End of file image.php
