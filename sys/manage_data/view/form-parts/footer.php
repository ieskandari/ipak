<?php
do_action("before-footer-form-view");

?>
<button class="btn btn-info"><?php echo  _T("submit"); ?><i class="fa fa-save"></i></button>
<?php
if (!isset($ViewData["DisplayMenuInvisible"])) {
?>
        <a href="?" title="<?php echo _T("back-to-list");  ?>" class="btn btn-warning"><?php echo  _T("cancel"); ?><i class="fa fa-reply"></i></a>
<?php } ?>

<?php
do_action("after-footer-form-view");
include "scripts.php";
?>