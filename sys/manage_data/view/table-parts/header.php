<?php
do_action("before_header_div_datatable");
do_action("before_header_div_datatable_".$ViewData["ModelName"]);
?>


<?php
do_action("after_header_div_datatable");
do_action("after_header_div_datatable_".$ViewData["ModelName"]);
?>