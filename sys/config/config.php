<?php
namespace sys;
if (file_exists(stream_resolve_include_path(BasePath."sys/config/config_route.php")))
{
    include "config_route.php";
}
else
{
    $myfile = fopen(BasePath."sys/config/config_route.php", "w") or die("Unable to open file!");
    $txt="<?php ";
    $txt = $txt."\n";
    $txt =$txt.'define("BaseUrl","'.tools::full_url($_SERVER).'");'."\n";
    $txt=$txt." ?>";
    fwrite($myfile, $txt);
    fclose($myfile);
    include "config_route.php";
}
define("PluginPath",BasePath."plugins/");
define("PluginUrl",BaseUrl."plugins/");

