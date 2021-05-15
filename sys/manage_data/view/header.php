<!DOCTYPE html>
<html>

<head>
    <title><?php echo $ViewData["PageTitle"]; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="<?php echo BaseUrl; ?>content/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo BaseUrl; ?>content/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo BaseUrl; ?>content/css/bootstrap-select.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo BaseUrl; ?>content/css/bootstrap-rtl.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="<?php echo BaseUrl; ?>content/css/my-bootstrap.css">
    <link rel="stylesheet" type="text/css" href="<?php echo BaseUrl; ?>content/css/Mh1PersianDatePicker.css">
    <link rel="stylesheet" type="text/css" href="<?php echo BaseUrl; ?>content/css/datatable.css">
    <link rel="stylesheet" type="text/css" href="<?php echo BaseUrl; ?>content/css/form.css">
    <link rel="stylesheet" type="text/css" href="<?php echo BaseUrl; ?>content/css/modal.css">
    <link rel="stylesheet" type="text/css" href="<?php echo BaseUrl; ?>content/css/file-manager.css">
    <link rel="stylesheet" type="text/css" href="<?php echo BaseUrl; ?>content/css/dashboard.css">
    <link rel="stylesheet" type="text/css" href="<?php echo BaseUrl; ?>content/css/style.css">
    <?php  do_action('header_styles'); ?>
    <script>
        var BaseUrl = '<?php echo BaseUrl ?>';
        <?php
        if (!isset($ViewData["PluginName"])) {
            $ViewData["PluginName"] = "";
        }
        if (!isset($ViewData["JustModelName"])) {
            $ViewData["JustModelName"] = "";
        }
        ?>
        var BaseUrlModel = '<?php echo BaseUrl . "" . $ViewData["PluginName"] . "/" . $ViewData["JustModelName"]; ?>';
        var BasePath = '<?php echo BasePath ?>';
    </script>
</head>

<body>
    <header id="">
        <?php
        if (!isset($ViewData["DisplayMenuInvisible"])) {
        ?>
            <button onclick="openNav();" class="btn btn-info" id="close-btn"><i class="fa fa-bars"></i></button>

        <?php
        }
        ?>
        <h4 id="page-title"><?php echo $ViewData["PageTitle"]; ?></h4>
        <div class="header-options">
        <a title="تغییر رمز عبور به برنامه"  href="<?php echo BaseUrl . 'admin/change_password'; ?>"><i class="fa fa-key"></i></a>

        <a  title="خروج از سیستم" href="<?php echo BaseUrl . 'admin/logout'; ?>"><i class="fa fa-power-off"></i></a>

        </div>
   
    </header>

    <?php
    if (!isset($ViewData["DisplayMenuInvisible"])) {
        include "nav.php";
    }
    ?>
    <div style="margin-top: 65px;" id="main">
        <div class="container" style="padding-top: 10px;">
            <?php do_action("header_scripts");  ?>
            <?php include "header-parts/header-alert.php";  ?>