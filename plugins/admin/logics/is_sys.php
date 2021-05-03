<?php
function logic_update(  $values, $plugin, $name, $fields, $key, $key_id)
{
    global $TR_db,$ViewData;
    $query = "select * from ".$plugin."_".$name." where ".$key."=" . $key_id;
    $rows = $TR_db->pdo_json($query);
    if (isset($rows[0]["is_sys"])&& $rows[0]["is_sys"] == 1) {
       send_admin_alert(" این اطلاعات سیستمی هست و قابل ویرایش نیست");
       return 0;
    } 
    return 1;
}
add_logic("logic_update","logic_update");

function logic_delete( $id,$plugin,$name,$fields,$key)
{
    global $TR_db,$ViewData;
    $query = "select * from ".$plugin."_".$name." where ".$key."=" . $id;
    $rows = $TR_db->pdo_json($query);
    if (isset($rows[0]["is_sys"])&& $rows[0]["is_sys"] == 1) {
       send_admin_alert(" این اطلاعات سیستمی هست و قابل حذف نیست");
       return 0;
    } 
    return 1;
}
add_logic("logic_delete","logic_delete");