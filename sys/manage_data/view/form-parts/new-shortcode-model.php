<?php
function new_shortcode_model()
{
?>
    <script>
        function new_shortcode_model(obj) {
            var myWindow = window.open(BaseUrl+obj.attr('plugin-name')+'?operation=add&display_menu=no', "myWindow", "width=500,height=500,top=200,left=300");
        }
    </script>
<?php
}
add_action("footer_scripts", "new_shortcode_model");
