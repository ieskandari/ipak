<?php
namespace sys;
$ActivePlugins=array();
include "status_plugins.php";
include "default_plugin.php";
class manage_plugin
{
    public static function get_active_plugins()
    {
        global $ActivePlugins;
        return $ActivePlugins;
    }
    public static function get_active_sub_plugins($plugin)
    {
        $url="sub_plugins/".$plugin.'_plugins.php';
    
        if (file_exists(stream_resolve_include_path($url)))
        {
           include $url;
           return $ActiveSubPlugins;
        }
        return array();
    }
    public static function get_default_plugin()
    {
        global $DefaultPlugin;
        return $DefaultPlugin;
    }
    public static function get_all_plugins($path="")
    {
        if(strlen($path)==0)
        {
            $path=PluginPath;
        }
       return tools::get_dirs($path);
    }
}