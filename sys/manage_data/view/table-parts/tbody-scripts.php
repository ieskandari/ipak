<?php
function set_item_delete_modal()
{
?>
    <script>
        function set_item_delete_modal(obj) {
            $.ajax({
                type: 'POST',
                url: '?<?php echo operation;  ?>=detail&id=' + obj.parents('.table-menu').attr('data-id'),
                data: {},
                contentType: 'application/json; charset=utf-8',
                success: function(msg) {
                    console.log(msg);
                    $('#delete-modal .modal-body').html(msg);
                },
                error: function(error) {
                    //Message
                    console.error(error.responseText);
                }
            });
            $('#delete-modal .ok-btn').attr('href', '?<?php echo operation;  ?>=delete&delete_id=' + obj.parents('.table-menu').attr('data-id'));
        }

        function set_item_detail_modal(obj) {
            $.ajax({
                type: 'POST',
                url: '?<?php echo operation;  ?>=detail&id=' + obj.parents('.table-menu').attr('data-id'),
                data: {},
                contentType: 'application/json; charset=utf-8',
                success: function(msg) {
                    console.log(msg);
                    $('#detail-modal .modal-body').html(msg);
                },
                error: function(error) {
                    //Message
                    console.error(error.responseText);
                }
            });
        }

        function set_data_group_works() {
            var tds = $("td.first-td input[type='checkbox']").prop("checked");
            var str = "";
            var vir = "";
            $("td.first-td input[type='checkbox']").each(function(i, item) {
                if ($(this).is(":checked")) {
                    str = str + vir + $(this).parents("tr").attr("data-id");
                    vir = ",";
                }
            });
            $('#group-works-table #items').val(str);
        }
        $(document).ready(function() {
            $("th.first-th input[type='checkbox']").change(function() {
                if ($(this).is(":checked")) {
                    $("td.first-td input[type='checkbox']").prop("checked", true);
                } else {
                    $("td.first-td input[type='checkbox']").prop("checked", false);
                }
                set_data_group_works();
            });
            $("td.first-td input[type='checkbox']").change(function() {
                set_data_group_works();
            });
        });
    </script>
<?php
}
add_action("footer_scripts", "set_item_delete_modal");
?>