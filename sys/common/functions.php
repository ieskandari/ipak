<?php

namespace sys;

function register_model($model)
{
    global $ActivePlugins;
    if ($ActivePlugins[$model->plugin] == 0) {
        return;
    }
    if (!isset(TR::$models[$model->plugin])) {
        TR::$models[$model->plugin] = array($model->name => $model);
    }
    TR::$models[$model->plugin][$model->name] = $model;
}
function register_plugin_info($data)
{
    if (count($data) > 0) {
        $arr = array();
        $plugin = $data["plugin"];
        $arr["plugin"] = $data["plugin"];
        $arr["info"] = $data["info"];
        $arr["sub_plugins"] = $data["sub_plugins"];
        TR::$plugins[$plugin] = $arr;
    }
}
function get_plugin_info($url)
{
    $data = array();
    $myfile = fopen($url, "r") or die("Unable to open file!");
    while (!feof($myfile)) {
        $str = fgets($myfile);
        $pattern = '/\*\s*[^\:]+\s*\:/';
        $matches = array();
        //echo preg_replace($pattern, "", $str);
        preg_match($pattern, $str, $matches, PREG_OFFSET_CAPTURE);
        if (count($matches) > 0) {
            $gets = str_replace($matches[0][0], '', $str);
            $key = str_replace(' ', '', $matches[0][0]);
            $key = str_replace('*', '', $key);
            $key = str_replace('\n', '', $key);
            $key = str_replace('<br>','', $key);
           
            $key = str_replace(':', '', $key);
            $key = strtolower($key);
      
            $data[$key] = $gets;
        }
    }
    fclose($myfile);
    return $data;
}
function un_register_model($plugin)
{
    global $ActivePlugins;
    $ActivePlugins[$plugin] = 0;
    unset(TR::$models[$plugin]);
}
function get_models()
{
    return TR::$models;
}
function check_active_plugin($plugin)
{
    global $ActivePlugins;
    if ($ActivePlugins[$plugin] == 1) {
        return true;
    }
    return false;
}
