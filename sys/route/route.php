<?php

namespace sys;
class route
{
    var $plugin = "";
    var $plugin_url = "";
    var $actions=array();
    function forward()
    {
        $actions = $this->get_params();
        $plugins = $this->get_plugins();
        $plugin = $this->logic_params($actions, $plugins);
        define("CurrentPlugin",$plugin);
        $plugin_url = PluginPath . $plugin . '/' . $plugin . ".php";
        $this->plugin = $plugin;
        $this->plugin_url = $plugin_url;
        $this->actions=$actions;
    }
    function run_plugin($plugin_url)
    {
        global $TR_db;
        global $TR_tools;
        if (file_exists(stream_resolve_include_path($plugin_url))) {
            return $plugin_url;
        }
        return "";
    }
    function load_sub_plugins($plugin)
    {
        global $TR_db;
        global $TR_tools;
        $urls = array();
        $plugins = manage_plugin::get_active_sub_plugins($plugin);
        foreach ($plugins as $key => $item) {
            $url = PluginPath . $plugin . "/sub_plugins" . "/" . $key . "/" . $key . ".php";
            if (file_exists(stream_resolve_include_path($url))) {
                $urls[] = $url;
            }
        }
        return $urls;
    }
    function is_model()
    {
      if(isset($this->actions[1]))
      {
         if(isset(TR::$models[$this->actions[0]][$this->actions[1]]))
         {
            return TR::$models[$this->actions[0]][$this->actions[1]];
         }
         else
         {
            $model=get_model_type($this->actions[1]);
            if($model)
            {
                return $model;
            }
         }
      }
      return false;
    }
    function logic_params(&$actions, $plugins)
    {
        $plugin = manage_plugin::get_default_plugin();
        $flag=true;
        if (count($actions) > 0) {
            if (isset($plugins[$actions[0]])) {
                $plugin = $actions[0];
                $flag=false;
            }
        }
        if($flag)
        {
            $tempactions=array();
            $tempactions[]=$plugin;
            foreach($actions as $action)
            {
                $tempactions[]=$action;
            }
            $actions=$tempactions;
        }
         
        return $plugin;
    }
    function get_params()
    {
        $QueryUrl = str_replace(BaseUrl, "", tools::full_url($_SERVER));
      //  $QueryUrl = str_replace(BaseUrl.'/', "", tools::full_url($_SERVER));
        $acts = tools::multiexplode(array("&", "?", "/"), $QueryUrl);
        $actions = array();
        foreach ($acts as $act) {
            $actions[] = urldecode($act);
        }
        return $actions;
    }
    function get_plugins()
    {
        return manage_plugin::get_active_plugins();
    }
}
