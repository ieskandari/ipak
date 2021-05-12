<?php
function editable_div_events()
{
?>
    <script>
        var lastCaretPos = 0;
        var parentNode;
        var range;
        var selection;

        function check_content_div_editable() {

        }

        function insertTextAtCursor(id, node) {
            if ($(parentNode).parents().is('#' + id) || $(parentNode).is('#' + id)) {
             
                range.deleteContents();
                range.insertNode(node);
                
                //cursor at the last with this
                range.collapse(false);
                selection.removeAllRanges();
                selection.addRange(range);

            } else {
              
                $("#" + id).append(node).focus()
            }
            $("#" + $("#" + id).attr('data-id')).val($("#" + id).html());
        }
        function div_editable_key_up(obj) {
            selection = window.getSelection();
            range = selection.getRangeAt(0);
            parentNode = range.commonAncestorContainer.parentNode;
            $("#" + obj.attr('data-id')).val(obj.html());
        }
        function div_editable_click() {

            selection = window.getSelection();
            range = selection.getRangeAt(0);
        
            parentNode = range.commonAncestorContainer.parentNode;
  
      

        }
    </script>
<?php
}
add_action("footer_scripts", "editable_div_events");
