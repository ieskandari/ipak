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
class plugin_dashboard
{
        function home()
        {
            global $ViewData, $TR_db, $CurrentPlugin;
                include "view/dashboard.php";
        }
}

$plugin_dashboard = new plugin_dashboard;
$plugin_dashboard->home();
