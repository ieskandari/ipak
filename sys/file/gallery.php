<?php
$data=array();
class file
{
    var $root;
    function __construct($input="")
    {
        $input=str_replace(BaseUrl,'', $input);
      $this->root=BasePath.$input;
    }
    function index()
    {  
      global $data;
      global $TR_tools;
      $input='np-content/uploads/';
      $path=$this->root.$input;
    
      if(isset($_GET['input']))
      {
      $inputed=  $_GET['input'];
      $inputed=str_replace(BaseUrl,'', $inputed);
      $inputed=str_replace('__________',' ', $inputed);
          if(strlen($inputed)>0&&$inputed!='np-content')
          {
            $path=$this->root.$inputed.'/';
          }
          if(strlen($_GET['input'])==0)
          {
            if(isset($_GET['select']))
            {
              set_user_setting('file-select','is');
            }
            else
            {
                set_user_setting('file-select','');
            }
            $current1=get_user_setting('current-folder');
      
            if(strlen($current1)>0)
            {
                $current1=str_replace('///','/',$current1);
                $current1=str_replace('//','/',$current1);
                $current1=str_replace(BaseUrl,'', $current1);
                $path=BasePath.$current1;
            }
          }
      }
     // $path=str_replace('//','/',$path);
   
      $data['current']=$path;
     
      set_user_setting('current-folder',str_replace(BasePath,'', $path));


      $prev="";
      $exp=explode("/",$path);
     for($x=0;$x<count($exp)-2;$x++)
      {
          if($x==count($exp)-3)
          {
            $prev=$prev.$exp[$x];
          }
          else
          {
            $prev=$prev.$exp[$x].'/';
          }
      }
     
      $prev=str_replace(BasePath,'', $prev);
      $data['prev']=$prev;
    
      $prev='';
      for($x=0;$x<count($exp)-1;$x++)
      {
          if($x==count($exp)-2)
          {
            $prev=$prev.$exp[$x];
          }
          else
          {
            $prev=$prev.$exp[$x].'/';
          }
      }

      $data['current1']=str_replace(BasePath,'', $prev);
      $mapstr1=$path;
     
      $mapstr1=str_replace('np-content/uploads/','', $mapstr1);
      $exp1=explode("/",str_replace(BasePath,'/', $mapstr1));
      $arr_map=array();
      $home=BasePath.'np-content/uploads/';
      $arr_map[0]=array("name"=>'home',"path"=>str_replace(BasePath,'', $home));
      for($x=1;$x<count($exp1);$x++)
       {
           if(strlen($exp1[$x])>0)
           {
            $home=$home.''.$exp1[$x];
            $arr_map[$x]=array("name"=>$exp1[$x],"path"=> str_replace(BasePath,'', $home));
           }
       }
       $data['map']=$arr_map;
      $dirs=array();
      $files=array();
      $arr=glob($path.'*');
    
      $indexDir=-1;
      $indexFile=-1;
      foreach($arr as $file)
      {
      
        $fileBase=str_replace(BasePath,BaseUrl, $file);
        $fileBaseMax=str_replace("/"."uploads/","/"."uploads-max/", $fileBase);
        if(is_dir($file))
        {
            $indexDir++;
            $exp=explode("/",$file);
           

            $dirs[$indexDir] =array('filename'=>$exp[count($exp)-1],'path'=>$fileBase);
        }
        else
        {
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
           $type = finfo_file($finfo, $file);

           if (isset($type) && in_array($type, array("image/png", "image/jpeg", "image/gif"))) 
           {
               $indexFile++;
               $exp=explode("/",$file);
               $files[$indexFile] =array('filename'=>$exp[count($exp)-1],'path'=>$fileBase,'path-max'=>$fileBaseMax);
           } 
           else 
           {
 
           }
        }
      }
      $created=get_user_setting('register-folder');
      if(strlen($created)>0)
      {
        $data['created']=$created;
      }
      else{
        $data['created']='';
      }
      set_user_setting('register-folder','');
      $data['dirs']=$dirs;
    
      $data['files']=$files;
      $data["select"]='';
      if(strlen(get_user_setting('file-select'))>0)
      {
        $data["select"]='data-dismiss="modal"';
      }
      $data["select"]='data-dismiss="modal"';
    include "list.php";
    }
    function registerfolder()
    {
        global $data;
        global $TR_tools;
        if(isset($_GET['folder']))
        {
            if (!file_exists($_GET['path'].$_GET['folder'])) {
                $path=$_GET['path'].$_GET['folder'];
                $rep1=str_ireplace("np-content/uploads/","np-content/uploads-max/", $path);
                mkdir($rep1, 0777, true);
                $rep2=str_ireplace("np-content/uploads/","np-content/uploads-200/", $path);
                mkdir($rep2, 0777, true);
                $rep3=str_ireplace("np-content/uploads/","np-content/uploads-300/", $path);
                mkdir($rep3, 0777, true);
                mkdir($path, 0777, true);
                $data['message']=str_replace(BasePath,'',$_GET['path']);
                set_user_setting('register-folder',$_GET['folder']);
            }
            else
            {
                $data['message']='exist';
            }
        }
        else{
         $data['message']='error';
        }
      include "registerfolder.php";
    }
    function deletefolder()
    {
        global $data;
        global $TR_tools;
       
        if(isset($_GET['folder']))
        {
            $folder=BasePath.$_GET['folder'];
            if (file_exists($folder)) {
                    $this->deleteFolders($folder);
                    $data['message']=str_replace(BasePath,'',$_GET['path']);
            }
            else
            {
                $data['message']='not exist';
            }
        }
        else{
         $data['message']='error';
        }
     include "registerfolder.php";
    }
    function deleteFolders($path){
        if (is_dir($path) === true) {

            $rep1=str_ireplace("np-content/uploads/","np-content/uploads-max/", $path);
            if (file_exists($rep1))
            {
                $files = array_diff(scandir($rep1), array('.', '..'));
                foreach ($files as $file)
                $this->deleteFolders(realpath($rep1) . '/' . $file);
                rmdir($rep1);
            }
            $rep2=str_ireplace("np-content/uploads/","np-content/uploads-200/", $path);
            if (file_exists($rep2))
            {
                $files = array_diff(scandir($rep2), array('.', '..'));
                foreach ($files as $file)
                $this->deleteFolders(realpath($rep2) . '/' . $file);
                rmdir($rep2);
            }
            $rep3=str_ireplace("np-content/uploads/","np-content/uploads-300/", $path);
            if (file_exists($rep3))
            {
                $files = array_diff(scandir($rep3), array('.', '..'));
                foreach ($files as $file)
                $this->deleteFolders(realpath($rep3) . '/' . $file);
                rmdir($rep3);
            }
            if (file_exists($path))
            {
                $files = array_diff(scandir($path), array('.', '..'));
                foreach ($files as $file)
                $this->deleteFolders(realpath($path) . '/' . $file);
                rmdir($path);
            }
            return true; 
        } else if (is_file($path) === true)
        {
            $rep1=str_ireplace("np-content/uploads/","np-content/uploads-max/", $path);
            if (file_exists($rep1))
            {
                unlink($rep1);
            }
            $rep2=str_ireplace("np-content/uploads/","np-content/uploads-200/", $path);
            if (file_exists($rep2))
            {
                unlink($rep2);
            }
            $rep3=str_ireplace("np-content/uploads/","np-content/uploads-300/", $path);
            if (file_exists($rep3))
            {
                unlink($rep3);
            }
            if (file_exists($path))
            {
                unlink($path);
            }
          
            return true;
        }
           
     
        return false;
    }
    function uplimage()
    {
        global $data;
        $url=$_GET['url'];
        $url=BasePath.$url;
        $target_dir = $url;
        $target_file = $target_dir . basename($_FILES["fileInput"]["name"]);
        $data['path']=$target_file;
        $data['filename']= basename($_FILES["fileInput"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        // Check if image file is a actual image or fake image
            $check = getimagesize($_FILES["fileInput"]["tmp_name"]);
            if($check !== false) {
               // echo $target_file;
                $uploadOk = 1;
            } else {
                $data['message']="File_is_not_an_image";
                $uploadOk = 0;
            }
            if (file_exists($target_file)) {
                $data['message']="فایلی با همین فایل در اینجا موجود است";
                $uploadOk = 0;
            }
             // Allow certain file formats
                  if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) 
                  {
                    $data['message']="Sorry, only JPG, JPEG, PNG & GIF files are allowed";
                           $uploadOk = 0;
                  }
                  // Check if $uploadOk is set to 0 by an error
       if ($uploadOk == 0) 
       {
       // $data['message']="Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
        } else 
        {
               $rep=str_ireplace("np-content/uploads/","np-content/uploads-max/", $target_file);
         
           if (move_uploaded_file($_FILES["fileInput"]["tmp_name"], $rep))
                {
                    $this->compress($rep, $rep, 50);
                  
                    $data['message']="فایل مورد نظر آپلود گردید";
                    //
                    $image = new ImageResize($rep);
                    $image->resizeToWidth(100);
                    $image->save($target_file);
                    //
                    $image = new ImageResize($rep);
                    $rep1=str_ireplace("np-content/uploads/","np-content/uploads-200/", $target_file);
                   // $wi=$image->getSourceWidth();
                  //  $image->resizeToWidth($wi);
                  //  $image->save($rep1,null,5);
                   $image->resizeToWidth(200);
                    $image->save($rep1);    
                    //
                    $image = new ImageResize($rep);
                    $rep2=str_ireplace("np-content/uploads/","np-content/uploads-300/", $target_file);
                    $image->resizeToWidth(300);
                    $image->save($rep2); 
                    //
                } else 
                {
                    $data['message']="خطا در آپلود فایل";
                }
        }
        $data['isok']=$uploadOk;
        include "uplimage.php";
    }
    function compress($source, $destination, $quality) {

		$info = getimagesize($source);

        if ($info['mime'] == 'image/jpeg'||$info['mime'] == 'image/jpg') 
        {
            $image = imagecreatefromjpeg($source);
           imagejpeg($image, $destination, $quality);
        }
			

        elseif ($info['mime'] == 'image/gif') 
        {
            $image = imagecreatefromgif($source);
           // imagegif($image, $destination, $quality);
        }
		

        elseif ($info['mime'] == 'image/png') 
        {
            $image = imagecreatefrompng($source);
         
         //  imagepng($image, $destination, $quality);
        }
			

	   // imagejpeg($image, $destination, $quality);

		return $destination;
	}
    function crop()
    {
        global $data;
        global $TR_tools;
        $file=BasePath.$_GET["path"];
        $exp=explode("/",$file);
        $prev='';
        for($x=0;$x<count($exp)-1;$x++)
        {
           $prev=$prev.$exp[$x].'/';
        }
        $data['path']=$file;
        $rep2=str_ireplace("np-content/uploads/","np-content/uploads-max/", $file);
        $data['path-max']=$rep2;
        $data['filename']=$exp[count($exp)-1];
        $last=explode(".",$data['filename']);
        $data['newfilename']=$TR_tools->getGUID().'.'.$last[count($last)-1];
        echo $data['newfilename'];
        $data['prev']=$prev;
       include "crop.php";
    }
    function postcrop()
    {
        
        if(is_numeric($_POST['towidth']))
        {
            $new_width=$_POST['towidth'];
            $file=$_POST['filename'];
            $newfile=$_POST['newfilename'];
            //
            $image = new ImageResize($file);
            $image->resizeToWidth(100);
            $image->save($newfile);
            //
            $file1=str_ireplace("np-content/uploads/","np-content/uploads-max/", $file);
            $image = new ImageResize($file1);
            $rep3=str_ireplace("np-content/uploads/","np-content/uploads-max/", $newfile);
            $image->resizeToWidth($new_width);
            $image->save($rep3);
            //
            $image = new ImageResize($file1);
            $rep1=str_ireplace("np-content/uploads/","np-content/uploads-200/", $newfile);
            $image->resizeToWidth(200);
            $image->save($rep1);    
            //
            $image = new ImageResize($file1);
            $rep2=str_ireplace("np-content/uploads/","np-content/uploads-300/", $newfile);
            $image->resizeToWidth(300);
            $image->save($rep2); 
        }
    }
}
$file =new file;
$action=$_GET["action"];

$file->$action();
