<?php
global $TR_tools;
$render_action=$TR_tools->render_php_action(PageAction);
include "header.php";
?>
 <?php  do_action("before_page_".$CurrentPlugin);  ?>
 <?php  
 echo $render_action;
 //do_action(PageAction); 
 ?>
 <?php  do_action("after_page_".$CurrentPlugin);  ?>
<?php
include "footer.php";
?>