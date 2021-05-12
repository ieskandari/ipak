<?php
use sys\TR as TR;
use sys\tools as tools;
function add_filter($tag_name, $callback = NULL,$order=10)
{
  //TR->vars->list_function_filter[$fun1]=$fun2;
  if($callback)
  {
   TR::$filters[$tag_name][] =array("func"=>$callback,"order"=>$order); 
  }
  else
  {
   unset(TR::$filters[$tag_name]);
  }
}
function  apply_filters()
{
  $numargs = func_num_args();
  $arg_list = func_get_args();
  $tag_name="";
  $val="";
  if(isset($arg_list[0]))
  {
    $tag_name=$arg_list[0];
  }
  $value=array(); 

  for ($i = 1; $i < $numargs; $i++) 
  {
    $value[$i-1]=$arg_list[$i];
  }
  $val="";
  if(isset($value[0]))
  {
    $val=$value[0];
  }
  if(isset(TR::$filters[$tag_name])) // Fire a callback
  {
    $data=tools::array_orderby(TR::$filters[$tag_name],'order');
    foreach($data as $func)
    {
     
      $function=$func["func"];
   
      $val= call_user_func_array($function,$value);
      $value[0]=$val;
    }
  }
  return $val;
}
function  do_action()
{
  $numargs = func_num_args();
  $arg_list = func_get_args();
  $tag_name="";
  if(isset($arg_list[0]))
  {
    $tag_name=$arg_list[0];
  }
  $value=array();
  for ($i = 1; $i < $numargs; $i++) 
  {
    $value[$i-1]=$arg_list[$i];
  }
  if(isset(TR::$events[$tag_name])) // Fire a callback
  {
    $data=tools::array_orderby(TR::$events[$tag_name],'order');
    foreach($data as $func)
    {
      $function=$func["func"];
      $val= call_user_func_array($function,$value);
    }
  }
}
function  do_logic()
{
  $numargs = func_num_args();
  $arg_list = func_get_args();
  $tag_name="";
  if(isset($arg_list[0]))
  {
    $tag_name=$arg_list[0];
  }
  $value=array();
  for ($i = 1; $i < $numargs; $i++) 
  {
    $value[$i-1]=$arg_list[$i];
  }
  $ret=1;

  if(isset(TR::$logics[$tag_name])) // Fire a callback
  {
    $data=tools::array_orderby(TR::$logics[$tag_name],'order');
    foreach($data as $func)
    {
      $function=$func["func"];
      $val= call_user_func_array($function,$value);
 
      if(is_numeric($val))
      {
        if($val>0)
        {
           $val=1;
        }
 
        $ret=$ret*$val;
      }
    }
  }
  return $ret;
}
function  add_action($tag_name, $callback = NULL,$order=10)
{
  if($callback)
  {
   TR::$events[$tag_name][] =array("func"=>$callback,"order"=>$order); 
  }
  else
  {
   unset(TR::$events[$tag_name]);
  }
}
function  add_logic($tag_name, $callback = NULL,$order=10)
{
  if($callback)
  {
  
   TR::$logics[$tag_name][] =array("func"=>$callback,"order"=>$order); 

  }
  else
  {
   unset(TR::$logics[$tag_name]);
  }

}
?>