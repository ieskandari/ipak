<?php
class manage_file
{
    var $img_option=0;
    function deleteFolders($path)
    {
        if (is_dir($path) === true) {
            if (file_exists($path)) {
                $files = array_diff(scandir($path), array('.', '..'));
                foreach ($files as $file)
                    deleteFolders(realpath($path) . '/' . $file);
                rmdir($path);
            }
            return true;
        } else if (is_file($path) === true) {
            if (file_exists($path)) {
                unlink($path);
            }

            return true;
        }


        return false;
    }
    function getGUID()
    {
        if (function_exists('com_create_guid')) {
            $uuid = com_create_guid();
            $uuid = str_replace('{', '', $uuid);
            $uuid = str_replace('}', '', $uuid);
            return $uuid;
        } else {
            mt_srand((float)microtime() * 10000); //optional for php 4.2.0 and up.
            $charid = strtoupper(md5(uniqid(rand(), true)));
            $hyphen = chr(45); // "-"
            $uuid = '' // "{"
                . substr($charid, 0, 8) . $hyphen
                . substr($charid, 8, 4) . $hyphen
                . substr($charid, 12, 4) . $hyphen
                . substr($charid, 16, 4) . $hyphen
                . substr($charid, 20, 12)
                . ''; // "}"
            $uuid = str_replace('{', '', $uuid);
            $uuid = str_replace('}', '', $uuid);
            return $uuid;
        }
    }
    function uplimage()
    {
        include "ImageResize.php";
        $data = array();
        $url = BasePath."upload/";
        $target_dir = $url;

        $target_file = $target_dir . basename($_FILES["fileInput"]["name"]);
        //   $target_file = str_ireplace(" ", "-", $target_file);
        $data['path'] = $target_file;
        $data['filename'] = basename($_FILES["fileInput"]["name"]);
        //  $data['filename'] = str_ireplace(" ", "-", $data['filename']);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $guid = $this->getGUID() . "." . $imageFileType;
        $data['filename'] = $guid;
        $target_file = str_ireplace($_FILES["fileInput"]["name"], $guid, $target_file);
        $target_file = $target_dir . $guid;
        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["fileInput"]["tmp_name"]);
    
        if ($check !== false) {
            // echo $target_file;
            $uploadOk = 1;
        } else {
            $data['message'] = "File_is_not_an_image";
            $uploadOk = 0;
        }
        if (file_exists($target_file)) {
            $data['message'] = "فایلی با همین نام موجود هست";
            $uploadOk = 0;
        }
        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            $data['message'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed";
            $uploadOk = 0;
        }
       
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            // $data['message']="Sorry, your file was not uploaded.";
            // if everything is ok, try to upload file
        } else {
            $rep = str_ireplace("upload/", "upload/upload-max/", $target_file);

            $restrainedQuality = 85; //0 = lowest, 100 = highest. ~75 = default
            $sizeLimit = 10000000;
            $upload = $_FILES['fileInput'];
            $result = false;
            if ($upload['size'] > $sizeLimit &&  $sizeLimit > 1) {
                //open a stream for the uploaded image
                $streamHandle = @fopen($upload['tmp_name'], 'r');
                //create a image resource from the contents of the uploaded image
                $resource = imagecreatefromstring(stream_get_contents($streamHandle));
                if (!$resource)
                    die('Something wrong with the upload!');

                //close our file stream
                @fclose($streamHandle);

                //move the uploaded file with a lesser quality
                imagejpeg($resource, $rep, $restrainedQuality);
                //delete the temporary upload
                @unlink($upload['tmp_name']);
                $result = true;
            } else {
                //the file size is less than the limit, just move the temp file into its appropriate directory
                $result =  move_uploaded_file($upload['tmp_name'], $rep);
            }
            //   $result=move_uploaded_file($upload["tmp_name"], $rep);
            if ($result == true) {
                //  $this->compress($rep, $rep, 50);

                $data['message'] = "فایل مورد نظر آپلود شد";
                //
                $image = new ImageResize($rep);
                $image->resizeToWidth(100);
                $image->save($target_file);

                if($this->img_option==1)
                {       
                    //
                    $image = new ImageResize($rep);
                    $rep1 = str_ireplace("upload/", "upload/upload-200/", $target_file);
                    $image->resizeToWidth(200);
                    $image->save($rep1);
                    //
                    $image = new ImageResize($rep);
                    $rep2 = str_ireplace("upload/", "upload/upload-300/", $target_file);
                    $image->resizeToWidth(300);
                    $image->save($rep2);
    
                    $image = new ImageResize($rep);
                    $rep4 = str_ireplace("upload/", "upload/upload-400/", $target_file);
                    $image->resizeToWidth(400);
                    $image->save($rep4);
    
                    $image = new ImageResize($rep);
                    $rep5 = str_ireplace("upload/", "upload/upload-500/", $target_file);
                    $image->resizeToWidth(500);
                    $image->save($rep5, null, 20);
                }
                //
            } else {
                $data['message'] = "Sorry, there was an error uploading your file.";
            }
        }
  
        $data['isok'] = $uploadOk;
        if ($data['isok'] == 1) {
            $arr = array("ok" => 1, "file" => $data['filename']);
            echo json_encode($arr);
        } else {
            $arr = array("ok" => 0);
            echo json_encode($arr);
        }
    }
    function uplFile()
    {

        $data = array();
        $url = BasePath."files/";
        $target_dir = $url;

        $target_file = $target_dir . basename($_FILES["fileInput"]["name"]);
        // $target_file = str_ireplace(" ", "_", $target_file);
        $data['path'] = $target_file;
        $data['filename'] = basename($_FILES["fileInput"]["name"]);
        //  $data['filename'] = str_ireplace(" ", "_", $data['filename']);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $guid = $this->getGUID() . "." . $imageFileType;
        $data['filename'] = $guid;
        $target_file = str_ireplace($_FILES["fileInput"]["name"], $guid, $target_file);
        $target_file = $target_dir . $guid;
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            // $data['message']="Sorry, your file was not uploaded.";
            // if everything is ok, try to upload file
        } else {
            $restrainedQuality = 85; //0 = lowest, 100 = highest. ~75 = default
            $sizeLimit = 100000000;
            $upload = $_FILES['fileInput'];
            $result = false;
            $result =  move_uploaded_file($upload['tmp_name'], $target_file);
            //   $result=move_uploaded_file($upload["tmp_name"], $rep);
            if ($result == true) {
                //  $this->compress($rep, $rep, 50);
                //
            } else {
                $data['message'] = "Sorry, there was an error uploading your file.";
            }
        }
        $data['isok'] = $uploadOk;
        $arr = array("ok" => 1, "file" => $data['filename']);
        echo json_encode($arr);
    }
}
$manage_file = new manage_file;
if (isset($_GET["del_file"])) {
    //$manage_file->deleteFolders(BasePath."files/".$_GET["del_file"]);
}
else
{
    if (isset($_GET["is_file"])) {
        //$manage_file->uplFile();
    } else {
        if(isset($_GET["img_option"]))
        {
            $this->img_option=$_GET["img_option"];
        }
        $manage_file->uplimage();
    }
}

