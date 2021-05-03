<?php
function tools_add_table_to_div()
{
?>
    <div class="modal fade modal-info" data-id="" id="tools-table-modal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">اندازه های جدول</h4>
                </div>
                <div class="modal-body">
                    <div>
                        <label class="label-control">تعداد سطر</label>
                        <input id="tools-editable-div-table-insert-row" type="number" min="1" class="form-control" value="3" />
                    </div>
                    <div>
                        <label class="label-control">تعداد ستون</label>
                        <input id="tools-editable-div-table-insert-col" type="number" min="1" class="form-control" value="3" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" onclick="tools_add_table_to_div_insert();" data-dismiss="modal">تایید</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">بستن</button>
                </div>
            </div>

        </div>
    </div>
    <script>
        function tableCreate(row, col) {
            tbl = document.createElement('table');
            tbl.style.width = '100px';
            tbl.style.border = '1px solid black';
            for (var i = 0; i < row; i++) {
                var tr = tbl.insertRow();

                for (var j = 0; j < col; j++) {
                    var td = tr.insertCell();
                    td.style.border = '1px solid black';
                    td.style.padding = '5px';
                    td.appendChild(document.createTextNode('Cell'));
                }
            }
            return tbl;
        }

        function tools_add_table_to_div_insert() {
            var tbl = tableCreate($('#tools-editable-div-table-insert-row').val(), $('#tools-editable-div-table-insert-col').val());
            insertTextAtCursor($('#tools-table-modal').attr('data-id'), tbl);
        }

        function tools_add_table_to_div(obj) {
            $("#tools-table-modal").attr('data-id', obj.attr('data-id'));
            $('#tools-table-modal').modal('show');
        }
    </script>
<?php
}
add_action("footer_scripts", "tools_add_table_to_div");
