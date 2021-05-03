<?php
do_action("before_body_div_datatable");
do_action("before_body_div_datatable_" . $ViewData["ModelName"]);
?>
<table class="table">
    <?php include "thead.php";  ?>
    <?php include "tbody.php";  ?>
</table>

<?php
include "table-footer.php";
do_action("after_body_div_datatable");
do_action("after_body_div_datatable_" . $ViewData["ModelName"]);
?>