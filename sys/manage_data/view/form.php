<?php
include "header.php";
$display_menu="";
if (isset($ViewData["DisplayMenuInvisible"]))
{
    $display_menu="&display_menu=no";
}
?>
<form method="post" action="?<?php echo operation."=".$ViewData["Operation"].$display_menu; ?>">
<div class="panel panel-info">
    <div class="panel-heading">
    <?php include "form-parts/header.php"; ?>    
    </div>
    <div class="panel-body">
    <?php include "form-parts/body.php"; ?>   
    </div>
    <div class="panel-footer">
    <?php  include "form-parts/footer.php"; ?>
    </div>
</div>
</form>
<?php include "form-parts/group_by.php"; ?>
<?php
include "footer.php";
?>