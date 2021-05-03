<?php
function tools_add_header_to_div()
{
?>
    <script>

        function tools_add_header_to_div(obj,size) {
          
            var h3 = document.createElement('h'+size);              
           h3.innerHTML="تیتر";
            insertTextAtCursor(obj.attr('data-id'),h3);       
        }
    </script>
<?php
}
add_action("footer_scripts", "tools_add_header_to_div");
