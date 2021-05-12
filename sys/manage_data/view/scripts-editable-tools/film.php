<?php
function tools_add_film_to_div()
{
?>
    <div class="modal fade modal-info" data-id="" id="tools-film-modal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">وارد کردن فیلم</h4>
                </div>
                <div class="modal-body">
                    <div>
                        <label class="label-control">لینک فیلم را وارد نمائید</label>
                        <input id="tools-editable-div-film-insert" class="form-control" placeholder="http://Example.com/film" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" onclick="tools_add_film_to_div_insert();" data-dismiss="modal">تایید</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">بستن</button>
                </div>
            </div>

        </div>
    </div>
    <script>
        function tools_add_film_to_div_insert() {
            var main_div = document.createElement('div');
            main_div.appendChild(document.createElement('div'));
                var node = document.createElement('video');
                node.autoplay = true;
                node.controls = true;
                var source='<source src="'+$("#tools-editable-div-film-insert").val()+'" >';
                node.innerHTML = source;
                main_div.appendChild(node);
                main_div.appendChild(document.createElement('div'));
                insertTextAtCursor($("#tools-film-modal").attr('data-id'), main_div);
        }

        function tools_add_film_to_div(obj) {
            $("#tools-film-modal").attr('data-id', obj.attr('data-id'));
            $('#tools-film-modal').modal('show');
        }
    </script>
<?php
}
add_action("footer_scripts", "tools_add_film_to_div");
