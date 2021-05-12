<?php
include "header.php";
?>
<?php do_action("before_dashboard_" . $CurrentPlugin);  ?>
<?php include "dashboard-parts/tile.php"; ?>
<hr>
<div class="dashboard-menu"><?php include "menu.php";  ?></div>
<hr>
<div class="row">
<?php do_action("after_dashboard_" . $CurrentPlugin);  ?>
</div>

<?php include "dashboard-parts/help.php"; ?>
<?php
include "footer.php";
?>