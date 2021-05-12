<?php
class authorize
{
  function index()
  {
    Redirect(BaseUrl."admin/admin");
  }
    function login()
    {
        global $TR_db;
        $time = $_SERVER['REQUEST_TIME'];
        $top_step=0;
        $str_top_step = get_session("top_step_login");
        if (strlen($str_top_step) > 0) {
          $top_step = $str_top_step;
        }
        $top_step=$top_step+1;
        if($top_step>10)
        {
         $top_step=10;
        }
         $timeout_duration = 15*$top_step;
           $hash = password_hash('123456', PASSWORD_DEFAULT);
          // echo $hash;
         //password_verify($password, $user['password']);
         if (isset($_POST["username"])) {
       
           $step = 0;
           $limit=3;
           $flag=1;
           $str_step = get_session("step_login");
           if (strlen($str_step) > 0) {
             $step = $str_step;
           }
           if($step==0)
           {
             $timeout_duration = 216000;
             $_SESSION['LAST_ACTIVITY'] = $time;
           }
           $step = $step + 1;
           set_session("step_login", $step);
             if ( isset($_SESSION['LAST_ACTIVITY']) && 
             ($time - $_SESSION['LAST_ACTIVITY']) > $timeout_duration) {
               set_session("step_login", "0");  
           }
           else if ($step > $limit) {
             $data["error"] = "شما بیش از حد مجاز برای ورود تلاش کرده اید لطفا بعد از "." ".$timeout_duration .' ثانیه '.'امتحان فرمائید';
             $_SESSION['LAST_ACTIVITY'] = $time;
             $data["timer"]=$timeout_duration;
             $flag=0;
             set_session("top_step_login",$top_step);
           } 
           if($flag==1) {
       
             $username = $_POST["username"];
             $password = $_POST["password"];
     
             $query = "select * from admin_user where username=:username limit 1";
             $user = $TR_db->pdo_json($query, array(":username" => $username));
   
             $data["error"] = "نام کاربری یا رمز عبور اشتباه است";
           
             if (count($user)>0&&isset($user[0]["pass"])) {
        // echo '<div>'.$user[0]['pass'].'</div>'."<br>";
        // echo '<div>'.password_hash($password, PASSWORD_DEFAULT).'</div>'."<br>";
               if (password_verify($password, $user[0]['pass'])) {
                
                $user1=new sys\user;
                $user1->set_user(array("user_id"=>$user[0]["user_id"],"username"=>$user[0]["username"]),user_key);
                 set_session("step_login", "0");
                 set_session("top_step_login","0");
                 Redirect(BaseUrl."admin/index");
               }
             }
           }
         }
            include "view/login.php";
    }
    function logout()
    {
        setcookie(coockie____user, "", time() + (86400 * 365), "/"); // 86400 = 1 day
        Redirect(BaseUrl."admin/login");
    }
    function change_password()
    {
      global $TR_db;
      if (isset($_POST["old_pass"])) {
        $old_pass = "";
        $new_pass = "";
        $verify_pass = "";
        $old_pass = $_POST["old_pass"];
        $new_pass = $_POST["new_pass"];
        $verify_pass = $_POST["verify_pass"];
        if (strlen(trim($new_pass)) == 0) {
          $data["error"] = "رمز خالی است";
        } else {
          if ($new_pass == $verify_pass) {
            $query = "select * from admin_user where user_id=:user_id";
            $login_user=get_user();
            $user = $TR_db->pdo_single($query, array(":user_id" => $login_user["user_id"]));
            if (isset($user["user_id"])) {
              if (password_verify($old_pass, $user['pass'])) {
                $query = "update admin_user set pass='" . password_hash($new_pass, PASSWORD_DEFAULT) . "' where user_id=:user_id";
                $TR_db->begin();
                $user = $TR_db->pdo_exc($query,array(":user_id"=>$user["user_id"]));
                $TR_db->commit();
                $data["success"] = "رمز عبور با موفقیت تغییر داده شد";
              } else {
                $data["error"] = "رمز فعلی اشتباه است";
              }
            }
          } else {
            $data["error"] = "تکرار رمز عبور اشتباه است";
          }
        }
      }
        include "view/change_pass.php";
    }
}
$authorize=new authorize;
add_action("admin_login", array($authorize, "login"));
add_action("admin_logout", array($authorize, "logout"));
add_action("admin_index", array($authorize, "index"));
add_action("admin_change_password", array($authorize, "change_password"));