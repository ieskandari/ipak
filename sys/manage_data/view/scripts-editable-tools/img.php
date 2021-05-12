<?php
function tools_add_img_to_div()
{
?>
    <div class="modal fade modal-info" data-id="" id="tools-img-modal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">وارد کردن تصویر</h4>
                </div>
                <div class="modal-body">
                    <div>
                        <label class="label-control">لینک تصویر را وارد نمائید</label>
                        <input id="tools-editable-div-img-insert" class="form-control" placeholder="http://Example.com/img.jpg" />
                    </div>
                    <div>
                        <label class="label-control">طول تصویر</label>
                        <input id="tools-editable-div-img-insert-width" class="form-control" value="400" type="number" min="10" />
                    </div>
                    <div>
                        <label class="label-control">عرض تصویر</label>
                        <input id="tools-editable-div-img-insert-height" class="form-control" value="300" type="number" min="10" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" onclick="tools_add_img_to_div_insert();" data-dismiss="modal">تایید</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">بستن</button>
                </div>
            </div>

        </div>
    </div>
    <script>
        function tools_add_img_to_div_insert() {
            if ($("#tools-editable-div-img-insert").val().length > 0) {
                var node = document.createElement('img');
                node.src = $("#tools-editable-div-img-insert").val();
                node.style.width=$("#tools-editable-div-img-insert-width").val()+"px";
                node.style.height=$("#tools-editable-div-img-insert-height").val()+"px";
               insertTextAtCursor($("#tools-img-modal").attr('data-id'), node);
            }
        }

        function tools_add_img_to_div(obj) {
            $("#tools-img-modal").attr('data-id', obj.attr('data-id'));
            $('#tools-img-modal').modal('show');
        }
    </script>
<?php
}
add_action("footer_scripts", "tools_add_img_to_div");
