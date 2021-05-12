<?php
if (isset($ViewData["TableBtns"]) && count($ViewData["TableBtns"]) > 0) {
    foreach ($ViewData["TableBtns"] as $links) {
        $link = "";
        if (isset($links["link"])) {
            $link = $links["link"] . "?1=1";
        }
        if (isset($links["params"])) {
            foreach ($links["params"] as $param) {
                $idd=$item["primary__key__id"];
                if(isset($item[$param]))
                {
                    $idd=$item[$param];
                }
                $link =  $link.'&' . $param . "=" . $idd;
            }
        }
        $class = "";
        if (isset($links["class"])) {
            $class = $links["class"];
        }
        echo '<td><a class="'. $class .'" href="'.$link.'">' . $links["title"] . '</a></td>';
    }
}
