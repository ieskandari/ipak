<?php
function print_modal()
{
    global $ViewData;
?>
    <!-- Modal -->
    <div class="modal fade" id="print-modal" role="dialog">
        <form method="POST" action="?file=print">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title"><?php echo _T("print-title"); ?></h4>
                    </div>
                    <div class="modal-body">
                        <h4><?php echo _T("setting-print-col"); ?></h4>
                        <?php
                        foreach ($ViewData["HeaderData"] as $field) {
                            echo '<input checked name="' . $field->name . '_check" type="checkbox"><label class="label-checkbox">' . $field->get_title($ViewData["ModelName"]) . '</label>';
                        }
                        ?>
                        <hr />
                        <h4><?php echo _T("setting-print-font"); ?></h4>
                        <label><?php echo _T("setting-print-font-size"); ?></label><input value="12" name="font-size" type="number" min="9" max="16" />
                    </div>
                    <div class="modal-footer">
                    <input id="is_group_by" name="is_group_by" value="0" type="hidden" />
                        <button class="btn btn-success"><?php echo _T("print"); ?></button>
                        <a class="btn btn-danger" data-dismiss="modal"><?php echo _T("cancel"); ?></a>
                    </div>
                </div>

            </div>
        </form>
    </div>
    <script>
        function check_group_by_print() {
               $('#is_group_by').val(1);
        }
    </script>
<?php }
add_action("footer_scripts", "print_modal");
?>