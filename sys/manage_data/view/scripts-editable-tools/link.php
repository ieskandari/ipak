<?php
function tools_add_link_to_div()
{
?>
    <div class="modal fade modal-info" data-id="" id="tools-link-modal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">وارد کردن لینک</h4>
                </div>
                <div class="modal-body">
                    <div>
                        <label class="label-control">عنوان را وارد نمائید</label>
                        <input id="tools-editable-div-link-insert-title" class="form-control" value="عنوان لینک" placeholder="عنوان لینک" />
                    </div>
                    <div>
                        <label class="label-control">لینک را وارد نمائید</label>
                        <input id="tools-editable-div-link-insert" class="form-control" placeholder="http://Example.com/link" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" onclick="tools_add_link_to_div_insert();" data-dismiss="modal">تایید</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">بستن</button>
                </div>
            </div>

        </div>
    </div>
    <script>
        function tools_add_link_to_div_insert() {
            if ($("#tools-editable-div-link-insert-title").val().length > 0) {
                var node = document.createElement('a');
                node.innerText=$("#tools-editable-div-link-insert-title").val();
                node.href = $("#tools-editable-div-link-insert").val();
                node.target="_blank";
                insertTextAtCursor($("#tools-link-modal").attr('data-id'), node);
            }
        }

        function tools_add_link_to_div(obj) {
            $("#tools-link-modal").attr('data-id', obj.attr('data-id'));
            $('#tools-link-modal').modal('show');
        }
    </script>
<?php
}
add_action("footer_scripts", "tools_add_link_to_div");
