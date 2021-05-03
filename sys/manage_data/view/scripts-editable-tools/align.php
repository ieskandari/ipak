<?php
function tools_add_align_to_div()
{
?>
    <script>
        function tools_add_align_to_div(align) {
            if ($(parentNode)) 
            {
                $(parentNode).css('text-align',align);
                if(align=='left')
                {
                    $(parentNode).css('direction','ltr');
                }
                if(align=='right')
                {
                    $(parentNode).css('direction','rtl');
                }
            }
        }
    </script>
<?php
}
add_action("footer_scripts", "tools_add_align_to_div");
