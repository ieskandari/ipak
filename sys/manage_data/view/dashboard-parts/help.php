<hr>
<div class="panel panel-warning help-panel">
    <div class="panel-heading">راهنما و توضیحات <i data-help="راهنمایی و توضیحات" class="fa fa-question-circle"></i></div>
    <div class="panel-body ">
        <p>توجه : برای دسترسی به سایر ماژول ها گزینه <a href="<?php echo BaseUrl . ThisPlugin . '/admin'; ?>">میز کار</a> را از منو انتخاب نمائید</p>
        <?php  do_action("dashboard_help_".$ViewData["PluginName"]); ?>
    </div>
</div>