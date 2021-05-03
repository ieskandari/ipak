<?php 
        $ViewData=array();
       $ViewData["AlertErrors"] = array();
       $ViewData["AlertSuccess"] = array();
       $ViewData["AlertWarnings"] = array();
       $ViewData["AlertMessages"] = array();
       $ViewData["ModelTitle"] = '';
       $ViewData["ModelName"] = '';
       $ViewData["PluginName"] = ThisPlugin;
       $ViewData["PageTitle"] = ''.' '.PluginTitle;
       $ViewData["JustModelName"]="admin/".$route->actions[2];
       if(isset($_GET["api"]))
       {
        do_action(PageAction); 
       }
       else
       {
        include "view/page.php"; 
       }
