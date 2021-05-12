<?php
class action_user
{
    function filter_insert($values)
    {
        $values["pass"]=password_hash($values["pass"], PASSWORD_DEFAULT);
        return $values;
    }
    function filter_update($values)
    {
        if(strlen($values["pass"])<20)
        {
            $values["pass"]=password_hash($values["pass"], PASSWORD_DEFAULT);
        }
        return $values;
    }
    function add_btn($data,$id,$row)
    {
    return '<div class="item-menu add-item"><a href="'.BaseUrl.'admin/admin/set_permission?role_id='.$id.'">مدیریت دسترسی</a></div>';
    }
}
$action_user=new action_user;
add_filter("filter_insert_admin_user",array($action_user,"filter_insert"));
add_filter("filter_update_admin_user",array($action_user,"filter_update"));
add_filter("btn_option_admin_role",array($action_user,"add_btn"));
