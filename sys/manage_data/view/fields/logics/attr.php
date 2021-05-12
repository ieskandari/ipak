<?php
$str = '';
foreach ($field->attr as $key => $item) {
    if ($key != "class" && $key != "col-class" && $key != "label-class" && $key != "id" && $key != "name") {
        $str =$str. ' ' . $key . '="' . $item . '"';
    }
}
$ViewData["Attr"] = $str;
