<?php
function tools_add_paragraph_to_div()
{
?>
    <script>

        function tools_add_paragraph_to_div(obj) {
          
            var h3 = document.createElement('p');              
           h3.innerHTML="پاراگراف";
            insertTextAtCursor(obj.attr('data-id'),h3);       
        }
    </script>
<?php
}
add_action("footer_scripts", "tools_add_paragraph_to_div");
