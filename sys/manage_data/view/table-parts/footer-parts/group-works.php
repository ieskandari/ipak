<div id="group-works-table" class="table-footer-part <?php echo apply_filters("filter_class_group_works_footer_datatable", "group-works"); ?>">
    <form method="post" action="?<?php echo operation; ?>=group_works">
        <label><?php echo _T("table-group-works"); ?></label>
        <select id="action" name="action">
            <?php
            $works = array();
            $works[] = array("action" => "", "title" => _T("anything"));
            $works[] = array("action" => "action_group_delete_".$ViewData["ModelName"], "title" => _T("delete"));
            $works = apply_filters("table_group_works_" . $ViewData["ModelName"], $works);
            foreach ($works as $item) {
                echo '<option value="' . $item["action"] . '">' . $item["title"] . '</option>';
            }
            ?>
        </select>
        <input type="hidden" id="items" name="items" value="" />
        <button><?php echo  _T("submit"); ?></button>
    </form>

</div>