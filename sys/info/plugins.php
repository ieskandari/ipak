<?php

use sys\manage_plugin;

$plugs = manage_plugin::get_all_plugins();
foreach ($plugs as $key => $item) {
    $url = BasePath . "plugins/" . $key . "/" . $key . ".php";
    if (file_exists(stream_resolve_include_path($url))) {
        $data = sys\get_plugin_info($url);
        $pl = array();
        $pl["plugin"] = $key;
        $pl["info"] = $data;
        $sub_plugs = manage_plugin::get_all_plugins(BasePath . "plugins/" . $key . "/sub_plugins" . "/");
        $childs = array();
        foreach ($sub_plugs as $key_sub => $item_sub) {
            $url1 = BasePath . "plugins/" . $key . "/sub_plugins" . "/" . $key_sub . "/" . $key_sub . ".php";
            $data1 = sys\get_plugin_info($url1);
            $pl1 = array();
            $pl1["plugin"] = $key_sub;
            $pl1["info"] = $data1;
            $childs[$key_sub] = $pl1;
        }
        $pl["sub_plugins"] = $childs;
        sys\register_plugin_info($pl);
    }
}
