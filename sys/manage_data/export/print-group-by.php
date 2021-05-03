<?php
$info = array("logo" => BaseUrl . "content/img/logo.png");
$data_info = get_option($ViewData["PluginName"] . "_" . $ViewData["JustModelName"] . "_print_1",$ViewData["PluginName"]);
$logo_value = "";
if (isset($data_info["title"])) {
    $info["title"] = $data_info["title"];
} else {
    $info["title"] = "<h3>عنوان شرکت</h3><div>توضیحات شرکت</div>";
}
if (isset($data_info["desc"])) {
    $info["desc"] = $data_info["desc"];
} else {
    $info["desc"] = "توضیحات فاکتور در اینجا نوشته شود مثلا جنس فروخته شده پس داده نشود و...";
}
if (isset($data_info["logo"])) {
    $info["logo"] = BaseUrl . "upload/upload-max/" . $data_info["logo"];
    $logo_value = $data_info["logo"];
}
if (isset($data_info["address"])) {
    $info["address"] = $data_info["address"];
} else {
    $info["address"] = "آدرس : آدرس اینجا نوشته شود<div>
    <div>تلفن&nbsp; :021000000000&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; فاکس : 0210000000000000</div>
    <div>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 021000000000</div>
    <div>ایمیل : test@test.com&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; سایت&nbsp; : www.test.com&nbsp;</div>
</div>";
}
?>
<html>

<head>
    <link rel="stylesheet" type="text/css" href="<?php echo BaseUrl; ?>content/css/print-group-by.css">
    <script src="<?php echo BaseUrl; ?>content/js/jquery-3.5.1.min.js"></script>
    <script>
        var BaseUrl = '<?php echo BaseUrl ?>';
    </script>
    <script src="<?php echo BaseUrl; ?>content/js/image-compressor.js"></script>
    <script src="<?php echo BaseUrl; ?>content/js/file.js"></script>
</head>

<body>
    <div class="book">
        <div class="page">
            <div class="subpage">
                <div class="header">
                    <div class="btns header-box">
                        <a href="?" class="btn btn-back"><?php echo _T("back"); ?></a>
                        <a onclick="window.print();" class="btn btn-print"><?php echo _T("print"); ?></a>
                        <a onclick="save_export();" class="btn btn-save"><?php echo _T("save_export"); ?></a>
                    </div>
                    <div class="header-box">
                        <label><?php echo _T("setting-print-font-size"); ?></label>
                        <input id="font-size" onchange="font_change();" min="7" max="20" type="number" value="<?php echo $ViewData["PrintFontSize"]; ?>" />
                    </div>

                </div>
                <div class="company-info">
                    <div id="title" class="company-name" contenteditable="true"><?php echo $info["title"]; ?></div>
                    <div class="logo">
                        <input id="choose-file" style="display: none;" onchange="upl_image($(this),'logo','img_logo');" type="file" accept="image/*" />
                        <input id="logo" name="logo" value="<?php echo $logo_value;  ?>" type="hidden" />
                        <img onclick="$('#choose-file').click();" id="img_logo" src="<?php echo $info["logo"]; ?>" />
                    </div>
                </div>
                <h3 class="header-title"><?php echo $ViewData["DetailJustPageTitle"]; ?></h3>
                <div class="group-by-header">
                    <?php
                    foreach ($ViewData["GroupByData"]["fields"] as $field) {
                        $value = "";
                        if (count($ViewData["TableData"]) > 0) {
                            $value = get_field_data($ViewData["TableData"][0], $field["field_model"], false, $ViewData["PluginName"], $ViewData["JustModelName"]);
                        }
                        echo '<div class="col"><label class="title">' . $field["field_model"]->title . '</label><span>:</span><label class="value">' . $value . '</label></div>';
                    }
                    ?>
                </div>
               <div class="content">
               <table id="table" class="font-<?php echo $ViewData["PrintFontSize"]; ?>">
                    <thead>
                        <?php
                        echo '<tr>';
                        echo '<th>ردیف</th>';
                        foreach ($ViewData["PrintHeader"] as $field) {
                            if (isset($ViewData["GroupByData"]["fields"][$field->name])) {
                                continue;
                            }
                            echo '<th>' . $field->title . '</th>';
                        }
                        echo '</tr>';
                        ?>
                    </thead>
                    <tbody>
                        <?php
                        $x = 0;
                        foreach ($ViewData["PrintData"] as $row) {
                            $x++;
                            echo '<tr>';
                            echo '<td>' . $x . '</td>';
                            foreach ($ViewData["PrintHeader"] as $field) {
                                if (isset($ViewData["GroupByData"]["fields"][$field->name])) {
                                    continue;
                                }
                                $data = get_field_data($row, $field, true, $ViewData["PluginName"], $ViewData["JustModelName"]);
                                echo '<td>' . $data . '</td>';
                            }
                            echo '</tr>';
                        }
                        ?>
                    </tbody>
                </table>
                <?php include BasePath."sys/manage_data/view/table-parts/table-footer.php";  ?>
               </div>
            </div>
            <div class="company-footer">
                <div id="description" contenteditable="true"><?php echo $info["desc"]; ?></div>
                <div id="address" contenteditable="true">
                    <?php echo $info["address"];  ?>
                </div>
            </div>
        </div>
    </div>
    <script>
        function font_change() {
            document.getElementById("table").style.fontSize = document.getElementById("font-size").value;
        }

        function save_export() {
            $.ajax({
                type: 'POST',
                url: '<?php echo BaseUrl . $ViewData["PluginName"] . "/" . $ViewData["JustModelName"] . "?file=print";  ?>',
                data: {
                    is_group: 1,
                    title: $('#title').html(),
                    logo: $('#logo').val(),
                    desc: $('#description').html(),
                    address: $('#address').html()
                },
                success: function(msg) {
                    var jss = msg;
                    alert("با موفقیت ذخیره شد");
                    console.log(jss);
                    //  var res=JSON.parse(jss.json);
                    //  console.log(res);

                },
                error: function(error) {
                    alert("خطا در ذخیره اطلاعات");
                    //Message
                    console.error(error.responseText);
                }
            });
        }
    </script>
</body>

</html>