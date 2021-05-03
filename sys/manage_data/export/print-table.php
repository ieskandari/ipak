<html>

<head>
    <link rel="stylesheet" type="text/css" href="<?php echo BaseUrl; ?>content/css/print.css">
</head>

<body>
    <div class="book">
        <div class="page">
            <div class="subpage">
                <div class="header">
                    <div class="btns header-box">
                        <a href="?" class="btn btn-back"><?php echo _T("back"); ?></a>
                        <a onclick="window.print();" class="btn btn-print"><?php echo _T("print"); ?></a>
                    </div>
                    <div class="header-box">
                        <label><?php echo _T("setting-print-font-size"); ?></label>
                        <input id="font-size" onchange="font_change();" min="7" max="20" type="number" value="<?php echo $ViewData["PrintFontSize"]; ?>" />
                    </div>

                </div>
                <h5><?php echo $ViewData["JustPageTitle"];  ?></h5>
                <table id="table" class="font-<?php echo $ViewData["PrintFontSize"]; ?>">
                    <thead>
                        <?php
                        echo '<tr>';
                        echo '<th>ردیف</th>';
                        foreach ($ViewData["PrintHeader"] as $field) {
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
                                $data = get_field_data($row, $field,true,$ViewData["PluginName"],$ViewData["JustModelName"]);
                                echo '<td>' . $data . '</td>';
                            }
                            echo '</tr>';
                        }
                         include BasePath."sys/manage_data/view/table-parts/tbody-results.php"; 
                        ?>
                    </tbody>
                </table>
               
                <?php include BasePath."sys/manage_data/view/table-parts/table-footer.php";  ?>
            </div>
        </div>
    </div>
    <script>
function font_change()
{
     document.getElementById("table").style.fontSize =document.getElementById("font-size").value;
}
        </script>
</body>

</html>