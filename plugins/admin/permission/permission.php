<?php
class role_permission
{
    function set_permission()
    {
        
        global $ViewData, $TR_tools,$TR_db;
        $ViewData["role_id"]=0;
        $ViewData["PermissonValue"] = "";
        if(isset($_GET["role_id"]))
        {
            $ViewData["role_id"]=$_GET["role_id"];         
        }
        $query="select * from admin_role where role_id=:role_id";
        $rows=$TR_db->pdo_json($query,array(":role_id"=>$ViewData["role_id"]));
        if(count($rows)>0)
        {
                $ViewData["RoleTitle"]=$rows[0]["name"];
        }
        else
        {
            $ViewData["RoleTitle"]="خالی";  
        }
        if(isset($_POST["tree"]))
        {
            $query="update admin_role set permission=:tree where role_id=:role_id";
         //   echo $query." , role_id:".$ViewData["role_id"]." , tree:".$_POST["tree"];
            $TR_db->begin();
            $TR_db->pdo_exc($query,array(":tree"=>$_POST["tree"],":role_id"=>$ViewData["role_id"]));
            $TR_db->commit();
        }
        $query="select * from admin_role where role_id=:role_id";
        $data=$TR_db->pdo_json($query,array(":role_id"=>$ViewData["role_id"]));
        if(count($data)>0)
        {
            $ViewData["PermissonValue"] = $data[0]["permission"];
        }
        $tree = array();
        foreach (sys\TR::$models as $key_plugin => $plugin) {
            $children = array();
            if (count($plugin) > 0) {

                foreach ($plugin as $model) {
                    if(!$model->is_log)
                    {
                        $children[]=array("id" => $key_plugin."_".$model->name, "text" => $model->get_title(), "children" =>array());
                    }                }
                foreach(sys\TR::$menu as $key_menu=>$menu)
                {
                     if($menu["plugin"]==$key_plugin)
                     {
                        $children[]=array("id" => $key_menu, "text" => $menu["title"], "children" =>array());
                     }
                }
            }
            $main_node = array("id" => $key_plugin, "text" => _T("tag_plugin_" . $key_plugin), "children" => $children);

            $tree[] = $main_node;
        }
     
        $ViewData["PermissonTree"] = $TR_tools->json_encode($tree);
        include "view/set_permission.php";
    }
}
$role_permission = new role_permission;
add_menu("set_permission", "مدیریت دسترسی نقش ها", BaseUrl . "admin/admin/set_permission", "admin",false);
add_action("admin_set_permission", array($role_permission, "set_permission"));
