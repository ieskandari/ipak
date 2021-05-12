<?php
namespace sys;
include "functions.php";
include "role.php";
include "model.php";
include "actions.php";
class user
{
  function set_user($user = array(), $key_code = "", $def_key = "")
  {
    global $TR_db;
    $key = $user['username'] . "__________" . $user['user_id'] . '@' . rand();
    if (strlen($def_key) > 0) {
      $key = $def_key;
    }
    $TR_db->begin();
    $TR_db->pdo_exc("update admin_user set se_key='" . $key . "' where user_id=" . $user["user_id"]);
    $TR_db->commit();
    $code = $this->m_encode($key, $key_code);
    setcookie(coockie____user, $code, time() + (86400 * 365), "/"); // 86400 = 1 day
  }
  function m_encode($string, $key)
  {
    $key = sha1($key);
    $strLen = strlen($string);
    $keyLen = strlen($key);
    $j = 0;
    $hash = "";
    for ($i = 0; $i < $strLen; $i++) {
      $ordStr = ord(substr($string, $i, 1));
      if ($j == $keyLen) {
        $j = 0;
      }
      $ordKey = ord(substr($key, $j, 1));
      $j++;
      $hash .= strrev(base_convert(dechex($ordStr + $ordKey), 16, 36));
    }
    return $hash;
  }
  function m_decode($string, $key)
  {
    $key = sha1($key);
    $strLen = strlen($string);
    $keyLen = strlen($key);
    $j = 0;
    $hash = "";
    for ($i = 0; $i < $strLen; $i += 2) {
      $ordStr = hexdec(base_convert(strrev(substr($string, $i, 2)), 36, 16));
      if ($j == $keyLen) {
        $j = 0;
      }
      $ordKey = ord(substr($key, $j, 1));
      $j++;
      $hash .= chr($ordStr - $ordKey);
    }
    return $hash;
  }
  function get_user($key_code)
  {
     global $TR_db,$TR_tools;
     $code="";
     if(isset($_COOKIE[coockie____user]))
     {
      $code=$_COOKIE[coockie____user];
     }
     $username=$this->m_decode($code,$key_code);
      if(strlen($username)>5)
      {
          $query = "select u.*,r.permission as permission_role from admin_user u left join admin_role r on u.role_id=r.role_id where  u.se_key=:se_key   limit 1";
         
          $user = $TR_db->pdo_single($query, array(":se_key" => $username));
          if(isset($user["user_id"]))
          {
            Tr::$user_settings=$TR_tools->json_decode($user["setting"]);
            if(isset($user["permission_role"]))
            {
              $pers=explode(",",$user["permission_role"]);
              foreach($pers as $item)
              {
                Tr::$permission[$item]=$item;
              }
            }
        
            Tr::$user=array("user_id"=>$user["user_id"],"is_admin"=>$user["is_admin"],"username"=>$user["username"],"name"=>$user["name"],"lname"=>$user["lname"]);
          }
  
      }
  
  }
  public static  function set_settings()
  {
 
    if(is_login())
    {
      global $TR_db;
      $query="update admin_user set setting='".tools::json_encode(Tr::$user_settings)."' where user_id=".get_user()["user_id"];
      $TR_db->begin();
      $TR_db->pdo_exc($query);
      $TR_db->commit();
    }
  }
}
