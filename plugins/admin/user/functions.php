<?php
function get_user()
{
    return sys\TR::$user;
}

function is_admin()
{
    $user = get_user();
    if (isset($user["is_admin"])&&$user["is_admin"]==1) {
        return true;
    }
    return false;
}
function is_login()
{
    $user = get_user();
    if (isset($user["user_id"])) {
        return true;
    }
    return false;
}
function set_user_setting($key = "", $value = "")
{
    sys\Tr::$user_settings[$key] = $value;
}
function reset_user_setting($key = "")
{
     unset(sys\Tr::$user_settings[$key]);
}
function get_user_setting($key = "")
{
    if (isset(sys\Tr::$user_settings[$key])) {
        return sys\Tr::$user_settings[$key];
    }
    return "";
}
