<?php
do_action("before_footer_div_datatable");
do_action("before_footer_div_datatable_" . $ViewData["ModelName"]);
?>
<?php include "footer-parts/paging.php"; ?>
<?php include "footer-parts/print-modal.php"; ?>
<?php if ($ViewData["ShowBtns"]&&!$ViewData["NoAction"]) {
    include "footer-parts/delete-modal.php";
    include "footer-parts/group-works.php";
} 
include "footer-parts/detail-modal.php";
?>


<div class="<?php echo apply_filters("filter_class_page_size_footer_datatable", "page-size"); ?> table-footer-part">
    <form action="?page=1" method="post">
        <label><?php echo _T("table-page-size"); ?></label>
        <select id="pagesize" name="pagesize">
            <option <?php if ($ViewData["TableDataPageSize"] == 5) echo "selected";  ?> value="5">5</option>
            <option <?php if ($ViewData["TableDataPageSize"] == 10) echo "selected";  ?> value="10">10</option>
            <option <?php if ($ViewData["TableDataPageSize"] == 15) echo "selected";  ?> value="15">15</option>
            <option <?php if ($ViewData["TableDataPageSize"] == 20) echo "selected";  ?> value="20">20</option>
            <option <?php if ($ViewData["TableDataPageSize"] == 25) echo "selected";  ?> value="25">25</option>
            <option <?php if ($ViewData["TableDataPageSize"] == 30) echo "selected";  ?> value="30">30</option>
            <option <?php if ($ViewData["TableDataPageSize"] == 40) echo "selected";  ?> value="40">40</option>
            <option <?php if ($ViewData["TableDataPageSize"] == 50) echo "selected";  ?> value="50">50</option>
            <option <?php if ($ViewData["TableDataPageSize"] == 100) echo "selected";  ?> value="100">100</option>
            <option <?php if ($ViewData["TableDataPageSize"] == 200) echo "selected";  ?> value="200">200</option>
            <option <?php if ($ViewData["TableDataPageSize"] == 500) echo "selected";  ?> value="500">500</option>
        </select>
        <button><?php echo _T("table-submit"); ?></button>
    </form>
</div>
<?php  if($ViewData["ShowBtns"]&&!$ViewData["NoAction"]){ ?>
<div class="table-footer-part">
<a class="btn btn-default" href="<?php echo BaseUrl.$ViewData["PluginName"]."/".$ViewData["JustModelName"]."_log"; ?>"><?php  echo _T("history-log"); ?></a>
</div>
<?php } ?>
<?php
do_action("after_footer_div_datatable");
do_action("after_footer_div_datatable_" . $ViewData["ModelName"]);
?>