<?php

namespace Packages\System;


trait Libs 
{
    function UploadFile($target_dir, $file_upload_name)
    {   
        
        $result = array();
        $file_name_in_db = basename( strtotime(date('Y-m-d H:i:s')).'_'.mt_rand().'.'.pathinfo($file_upload_name["name"],PATHINFO_EXTENSION) );
        $target_file = $target_dir . $file_name_in_db;
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        $check = getimagesize($file_upload_name["tmp_name"]);
        if($check !== false) {
            $msg = "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            $msg = "File is not an image.";
            $uploadOk = 0;
        }

        // Check if file already exists
        if (file_exists($target_file)) {
            $msg = "Sorry, file already exists.";
            $uploadOk = 0;
        }

        // Check file size
        if ($file_upload_name["size"] > 10000000) {
            $msg = "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" ) {
            $msg = "Sorry, only JPG, JPEG, PNG files are allowed.";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            $msg = "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($file_upload_name["tmp_name"], $target_file)) {
                $msg = "The file has been uploaded."; 
            } else {
                $msg = "Sorry, there was an error uploading your file.";
            }
        }
        return array(
            "msg"=>$msg,
            "origin_name"=>$file_upload_name['name'],
            "file_size"=>$file_upload_name['size'],
            "file_name_in_db"=>$file_name_in_db
        );
    }

    function SysMsg($msg)
    {
        if(DEBUG_MODE == 1)
        {
            return $msg;
        }
    }


    function PostCURL( $url, $params = array() )
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $url,
            CURLOPT_POST => 1,
            CURLOPT_SSL_VERIFYPEER => false, //Bỏ kiểm SSL
            CURLOPT_POSTFIELDS => http_build_query($params)
        ));
        $resp = curl_exec($curl);
        return $resp;
        curl_close($curl);
    }


}