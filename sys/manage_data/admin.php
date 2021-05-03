<?php
$ViewData = array();
$ViewData["AlertErrors"] = array();
$ViewData["AlertSuccess"] = array();
$ViewData["AlertWarnings"] = array();
$ViewData["AlertMessages"] = array();
$ViewData["ModelTitle"] = '';
$ViewData["ModelName"] = '';
$ViewData["PluginName"] = ThisPlugin;
$ViewData["PageTitle"] = 'داشبورد' . ' ' . PluginTitle;
class plugin_admin
{
        function home()
        {
                global $ViewData, $TR_db, $CurrentPlugin;
                $plugins = array();
                if (is_admin()) {
                        foreach (sys\TR::$models as $key => $plugin) {
                                $plugin = $key;
                                if (!isset($plugins[$plugin])) {
                                        $plugins[$plugin] = _T("tag_plugin_" . $plugin);
                                }
                        }
                } else {
                        foreach (sys\TR::$permission as $key => $item) {
                                $ex = explode("_", $key);
                                $plugin = $ex[0];
                                if (!isset($plugins[$plugin])) {
                                        $plugins[$plugin] = _T("tag_plugin_" . $plugin);
                                }
                        }
                }
                $ViewData["Plugins"] = $plugins;
                include "view/home.php";
        }
}

$plugin_admin = new plugin_admin;
$plugin_admin->home();