<?php
  $is_date=false;
  if($field->type=="date"||$field->type=="datetime")
  {
      $is_date=true;
  }
  $ViewData["IsDate"]=$is_date;