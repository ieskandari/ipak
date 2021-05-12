<?php
if(isset($ViewData["TableBtns"])&&count($ViewData["TableBtns"])>0)
{
    foreach($ViewData["TableBtns"] as $row)
    {
         echo '<th></th>';
    }
}