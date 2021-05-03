<?php
include "header.php";
include "table-parts/filter.php";
?>
<?php do_action("before_datatable_" . $ViewData["ModelName"]);  ?>
<div class="<?php echo apply_filters("class_div_header_datatable", "table-header"); ?>">
    <?php include "table-parts/header.php"; ?>
</div>
<div class="<?php echo apply_filters("class_div_body_datatable", "table-body"); ?>">
    <?php include "table-parts/table.php"; ?>
</div>
<div class="<?php echo apply_filters("class_div_footer_datatable", "table-footer"); ?>">
    <?php include "table-parts/footer.php"; ?>
</div>
<?php if ($ViewData["ShowBtns"]&&!$ViewData["NoAction"]){ include "table-parts/help.php";} ?>
<?php
do_action("script_datatable");
function footer_scripts_table()
{
?>
    <script>
        $(document).ready(function() {
      
            $(".table tbody tr td").on("click", ".operation", function(event) {
                event.stopPropagation();
                $('#table-menu-1').attr('data-id', $(this).attr('data-id'));
                $('#table-menu-1 .add-item').remove();
                for(var i=0;i<$(this).parent().children('.add-item').length;i++)
                {
                    $('#table-menu-1').append($(this).parent().children('.add-item').eq(i));
                }
                $('#table-menu-1').children('.item-edit').children('a').attr('href','?<?php echo operation; ?>=edit&edit_id='+$(this).attr('data-id'));
                $(this).parent().append($('#table-menu-1'));
                if ($('#table-menu-1').attr('fade') == 1 && $('#table-menu-1').attr('data-id') == $('#table-menu-1').attr('data-fade')) {
                    $('#table-menu-1').fadeOut(500);
                    $('#table-menu-1').attr('fade', '0');
                } else {
                    $('#table-menu-1').fadeIn(500);
                    $('#table-menu-1').attr('fade', '1');
                }
                $('#table-menu-1').attr('data-fade', $('#table-menu-1').attr('data-id'));

            });
        });
    </script>
<?php  }
add_action("footer_scripts", "footer_scripts_table");
?>
<?php
include "footer.php";
?>