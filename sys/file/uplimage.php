<?php
if($data['isok']==1)
{
    $str='<div  onmouseover="showFileTick($(this));" onmouseout="showFileTick($(this));"  id="into-content" title="'. $data['filename'] .'" class="ic-file ic-file-img ic-file-created">
    <input path="'. str_replace(BasePath,'',$data['path']) .'" class="file-tick" type="checkbox">  
    <img src="'. str_replace(BasePath,BaseUrl,$data['path']).'" />
        <label>'.$data['filename'].'</label>
    </div>';
    $message='<div class="alert alert-success" role="alert">
    '.$data['message'].'
   </div>';
    $arr=array("ok"=>1,"data"=>$str,"message"=>$message);
    echo json_encode($arr);
?>
<?php
}
else {
    $str='<div class="alert alert-danger" role="alert">
    '.$data['message'].'
   </div>';
    $arr=array("ok"=>0,"message"=>$str,"data"=>'');
    echo json_encode($arr);
    }
?>