<?php

?>
<div class="filter">
    <form action="?page=1" method="post">
        <div class="panel panel-info">
            <div class="panel-heading"><?php echo _T("table-filter-title"); ?>
                <i class="fa fa-filter" data-toggle="collapse" data-target=".body-filter"></i>
            </div>
            <div class="panel-body body-filter collapse in">
                <div class="row">
                    <?php do_action("form_filter_" . $ViewData["ModelName"]);  ?>
                </div>
            </div>
            <div class="panel-footer">
                <?php  if ($ViewData["ShowBtns"]){ ?>
                <a href="?<?php echo operation . "=add"; ?>" class="btn btn-success"><?php echo  $ViewData["ModelTitle"] . ' ' . _T("table-filter-btn-plus"); ?><i class="fa fa-plus"></i></a>
                <?php  } ?>
                <button class="btn btn-info"><?php echo  _T("table-filter-btn-submit"); ?><i class="fa fa-search"></i></button>
                <a href="?clear=1" class="btn btn-warning"><?php echo  _T("table-filter-btn-clear"); ?><i class="fa fa-refresh"></i></a>
                <a title="<?php  echo _T("report-excel"); ?>" class="report" href="?file=excel"><img class="report-icon" src="<?php echo BaseUrl; ?>content/img/excel.png" /></a>
                <a  title="<?php  echo _T("report-csv"); ?>" class="report" href="?file=csv"><img class="report-icon" src="<?php echo BaseUrl; ?>content/img/csv.png" /></a>
                <a  title="<?php  echo _T("report-print"); ?>" class="report"  href="#" data-toggle="modal" data-target="#print-modal"><img class="report-icon" src="<?php echo BaseUrl; ?>content/img/print.png" /></a>
                <?php do_action("panel_filter_" . $ViewData["ModelName"]);
                do_action("panel_filter");
                ?>
            </div>
        </div>
    </form>
</div>