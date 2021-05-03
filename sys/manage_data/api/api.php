<?php
 header('Content-Type: application/json');
 global $TR_db;
 include $ApiFile;
 $strJson = sys\tools::json_encode($data);
echo $strJson;