<?php
date_default_timezone_set("Iran");
// header('Cache-Control: public, max-age=31536000');
define("BasePath", dirname(__FILE__) . '/');
define("Today", date('Y-m-d'));
include "sys/info/info.php";
include "sys/sys.php";
$MainPluginTitle = "مدیریت";
$TR_db = new sys\DatabaseMysql;
$TR_tools = new sys\tools;

$route = new \sys\route;
$route->forward();

$plugins = $route->get_plugins();
T("tag_plugin_admin", "پنل مدیریت");
$CurrentPlugin = "";
include "sys/info/plugins.php";
/// admin plugin
$admin = "admin";
$CurrentPlugin = "admin";
$url = PluginPath . $admin . '/' . $admin . ".php";
$sub_plugins_all = $route->load_sub_plugins($admin);
$plugin_one = $route->run_plugin($url);

foreach ($sub_plugins_all as $plug) {
    include $plug;
}
if (strlen($plugin_one) > 0) {
    include $plugin_one;
}

///

foreach ($plugins as $key => $item) {
    add_menu("dashboard", "داشبورد", BaseUrl .$key. "/admin/dashboard", $key,false);
    if ($key == "admin") {
        continue;
    }
    if ($key != $route->plugin) {
        $CurrentPlugin = $key;
        $url = PluginPath . $key . '/' . $key . ".php";
        $sub_plugins_all = $route->load_sub_plugins($key);
        $plugin_one = $route->run_plugin($url);
        $PluginTitle = get_plugin_info(array("plugin"=>$key,"tag"=>"plugintitle"));
        if (check_active_plugin($key)) {
            foreach ($sub_plugins_all as $plug) {
                include $plug;
            }
            if (strlen($plugin_one) > 0) {
                include $plugin_one;
            }
        }

        $title = $key;
        if (!is_array($PluginTitle)&&strlen($PluginTitle)>0) {
            $title = $PluginTitle;
        }
        T("tag_plugin_" . $CurrentPlugin, $title);
    }
}
$CurrentPlugin = $route->plugin;
define("ThisPlugin", $CurrentPlugin);
define("ThisPluginUrl", BaseUrl . "plugins/" . ThisPlugin . "/");
$sub_plugins = $route->load_sub_plugins($route->plugin);
$plugin = $route->run_plugin($route->plugin_url);
if ($route->plugin != "admin") {
    foreach ($sub_plugins as $plug) {
        include $plug;
    }
    if (strlen($plugin) > 0) {
        include $plugin;
        if (isset($PluginTitle)) {
           // $MainPluginTitle = $PluginTitle;
        }
    }
    $PluginTitle = get_plugin_info(array("plugin"=>$route->plugin,"tag"=>"plugintitle"));
    $title = $route->plugin;
    if (!is_array($PluginTitle)&&strlen($PluginTitle)>0) {
        $title = $PluginTitle;
        $MainPluginTitle = $PluginTitle;
    }
    T("tag_plugin_" . $CurrentPlugin, $title);
}
do_action("init",$route->actions);
$models = sys\TR::$models;
foreach ($models as $model) {
    foreach ($model as $item) {
        $item->re_init();
    }
}
if (count($route->actions) > 2) {
    define("Action", $route->actions[1] . '/' . $route->actions[2]);
} else if (count($route->actions) > 1) {
    define("Action", $route->actions[1]);
}
define("PluginTitle", $MainPluginTitle);
$model = $route->is_model();
sys\TR::$params=$route->actions;
$code_found = 0;
if ($model != "") {
    if (!is_login()) {
        $code_found = 1;
        Redirect(BaseUrl . "admin/login");
    } else {
        if (isset($_GET["file_upload"])) {
            $code_found = 2;
            include BasePath."sys/file/file.php";
        } else {
            $model_name = $model->name;
            if (strlen($model_name) > 4) {
                if (substr($model_name, -4) == "_log") {
                    $model_name = str_replace("_log", "", $model->name);
                }
            }
            if (get_permission($model->plugin . "_" . $model_name) && check_active_plugin($model->plugin)) {
                $code_found = 3;
                $model->get_view_table();
            }
        }
    }
} else {

    if (count($route->actions) > 1) {
        if ($route->actions[1] == "admin") {
            if (!is_login()) {
                $code_found = 4;
                Redirect(BaseUrl . "admin/login");
            } else {
                if (check_active_plugin(ThisPlugin)) {
                    if (count($route->actions) > 2) {
                        if (get_permission(ThisPlugin . "_" . $route->actions[2])) {
                            if($route->actions[2]=="dashboard")
                            {
                                $code_found = 51;
                                include BasePath.'sys/manage_data/dashboard.php';
                            }
                           else if (isset($_GET["file_upload"])) {
                                $code_found = 5;
                                include BasePath."sys/file/file.php";
                            } else {
                                $code_found = 6;
                                define("PageAction", ThisPlugin . "_" . $route->actions[2]);
                                include BasePath.'sys/manage_data/page.php';
                            }
                        } else {
                            $code_found = -1;
                        }
                    } else {
                        $code_found = 7;
                        include BasePath.'sys/manage_data/admin.php';
                    }
                }
            }
        } else {
            if (!isset(sys\TR::$menu[ThisPlugin . "_" . $route->actions[1]])) {
                if (check_active_plugin(ThisPlugin)) {
                    $code_found = 8;
                
                    if(strlen( $route->actions[1])>0)
                    {
                        $code_found = 81;
                        do_action(ThisPlugin . "_" . $route->actions[1]);
                    }
                    else
                    {
                        $code_found = 82;
                        do_action(ThisPlugin);  
                    }                
                }
            }
        }
    }
}
if ($code_found <= 1) {
    include "notfound.php";
}
$user = new sys\user;
$user->set_settings();
