<?php
$PluginTitle = "پنل مدیریت";
include "user/user.php";
$user=new sys\user;
//$user->set_user(array("user_id"=>1,"username"=>"admin"),user_key);
$user->get_user(user_key);
include "init_admin.php";
include "permission/permission.php";
include BasePath."plugins/admin/update/update.php";
include "user/authorize.php";
include "log/log.php";
include "filters/filters.php";
include "logics/logics.php";
include "model/model.php";
include "report/report.php";


