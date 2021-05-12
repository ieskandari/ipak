<?php
class  update_system
{
    function index()
    {
        global $TR_tools;
        $data = array();
        // set post fields
        $post = array();
        $data_this = array("version" => Version);
        $post["this"] = $TR_tools->json_encode($data_this);
        $plugins = get_plugin_info();
      //  var_dump(get_plugin_info(array("plugin"=>"web")));
        foreach ($plugins as $key => $plugin) {
            $data1 = array();
            if (isset($plugin["info"]["version"])) {
                $data1["version"] = $plugin["info"]["version"];
            }
            $subs = array();
            foreach ($plugin["sub_plugins"] as $sub_key => $sub) {
                if (isset($sub["info"]["version"])) {
                    $subs[$sub_key] = $sub["info"]["version"];
                }
            }
            if (count($subs) > 0) {
                $data1["sub_plugins"] = $subs;
            }
            $post[$key] = $TR_tools->json_encode($data1);
        }
        $ch = curl_init('http://update.mbmti.ir/updates.php');
        //   $ch = curl_init('http://update.mbmti.ir/updates.php');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        // execute!
        $response = curl_exec($ch);

        // close the connection, release resources used
        curl_close($ch);

        $json = json_decode($response, JSON_UNESCAPED_UNICODE);
        // var_dump($json);
       //   return;
   
        if (Version == $json["this"]["ver"]) {
            $json["this"]["new"] = 0;
        } else {
            $json["this"]["new"] = 1;
        }
        foreach ($plugins as $key => $plugin) {
            if (isset($json[$key])) {
              $version =get_plugin_info(array("plugin"=>$key,"tag"=>"version"));      
            
                if (trim($version) == trim($json[$key]["ver"])) {
                    $json[$key]["new"] = 0;
                } else {
                    $json[$key]["new"] = 1;
                }
            }
            foreach ($plugin["sub_plugins"] as $sub_key => $sub) {
              
                if (isset($json[$key]["sub_plugins"][$sub_key])) {
                    $version_sub = get_plugin_info(array("plugin"=>$key,"sub_plugin"=>$sub_key,"tag"=>"version","debug"=>0));
                    if (trim($version_sub) == trim($json[$key]["sub_plugins"][$sub_key]["ver"])) {
                        $json[$key]["sub_plugins"][$sub_key]["new"] = 0;
                    } else {
                        $json[$key]["sub_plugins"][$sub_key]["new"] = 1;
                    }
                }
            }
        }
        $ret = array();
        $data["json"] = $json;
        include "view/index.php";
    }
    function update()
    {
        global $TR_tools;
        $data = array();
        $plugin = "this";
        $folder = "";
        $version = "";
        $sub_plugin="";
        if (isset($_GET["plugin"])) {
            $plugin = $_GET["plugin"];
        }
        if (isset($_GET["sub_plugin"])) {
            $sub_plugin ="&sub_plugin=". $_GET["sub_plugin"];
        }
        if (isset($_GET["version"])) {
            $version = $_GET["version"];
        } else {
            $data["error"] = 'کد خطا 1' . ' : ' . "خطا در عملیات لطفا دوباره امتحان فرمایید";
            include "view/update.php";
        }
        $url = "http://update.mbmti.ir/update.php?plugin=" . $plugin .$sub_plugin. '&file=' . $version . "";
        //   $ch = curl_init('http://update.mbmti.ir/updates.php?plugin=" . $plugin . '&file=' . $version . "";
        //  echo $url;
        // return;
        $rootFolder = BasePath;
        $rootFolder = $rootFolder . '/';
        if (isset($_GET["plugin"])&&$_GET["plugin"]!="this")
        {
            $rootFolder=$rootFolder."plugins/".$_GET["plugin"]."/";
        }
        if (isset($_GET["sub_plugin"])) {
            $rootFolder=$rootFolder."sub_plugins/".$_GET["sub_plugin"]."/";
        }
        $updateFolder = $rootFolder . "temp";

        if (file_exists($updateFolder)) {
            //deletefolder($updateFolder);
            // return;
        }
        if (strlen($folder) > 0 && !file_exists($rootFolder)) {
            $TR_tools->Createfolder($rootFolder);
        }

        $TR_tools->Createfolder($updateFolder);
        $zipFile = $updateFolder . "/update.zip";

        $zip_resource = fopen($zipFile, "w");

        $ch_start = curl_init();
        curl_setopt($ch_start, CURLOPT_URL, $url);
        curl_setopt($ch_start, CURLOPT_FAILONERROR, true);
        curl_setopt($ch_start, CURLOPT_HEADER, 0);
        curl_setopt($ch_start, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch_start, CURLOPT_AUTOREFERER, true);
        curl_setopt($ch_start, CURLOPT_BINARYTRANSFER, true);
        curl_setopt($ch_start, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch_start, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch_start, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch_start, CURLOPT_FILE, $zip_resource);
        $page = curl_exec($ch_start);
        if (!$page) {
            $data["error"] = 'کد خطا 2' . ' : ' . "خطا در عملیات لطفا دوباره امتحان فرمایید ";
        }
        curl_close($ch_start);

        $zip = new ZipArchive;
        $extractPath = $rootFolder;
        if ($zip->open($zipFile) != "true") {
            $data["error"] = 'کد خطا 3' . ' : ' . "خطا در عملیات لطفا دوباره امتحان فرمایید";
        }
        $zip->extractTo($extractPath);
        $zip->close();
        // if (file_exists(stream_resolve_include_path($rootFolder . 'update.php'))) {
        //     require_once($rootFolder . 'update.php');
        //     $data["success"] = "با موفقیت آپدیت گردید";
        // }

        Redirect(BaseUrl . "admin/admin/update");
    }
}
$update_system = new update_system;
add_menu("update", "بروزرسانی سیستم", BaseUrl . "admin/admin/update", "admin", true);
add_action("admin_update", array($update_system, "index"));

add_menu("post_update", "اعمال بروزرسانی", BaseUrl . "admin/admin/post_update", "admin", false);
add_action("admin_post_update", array($update_system, "update"));
