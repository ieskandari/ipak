<thead>
<?php
do_action("before_thead");
do_action("before_thead_" . $ViewData["ModelName"]);
?>
                <tr>
                    <th  title="<?php  echo _T("select-all"); ?>" class="first-th"><input type="checkbox" /></th>
                    <th class="second-th">
                        <?php  echo _T("table-row-counter");  ?>
                    </th>
                    <?php  
                    foreach($ViewData["HeaderData"] as $field)
                    {                        
                        $class="sorting";
                        $sort="asc";
                        if(isset($ViewData["HeaderDataSortValue"][$field->name]))
                        {
                            $val=$ViewData["HeaderDataSortValue"][$field->name];
                            $class=$class."-".$val;
                            if($val=="asc")
                            {
                                $sort="desc";
                            }      
                            else
                            {
                                $sort="asc";
                            }                   
                        }
                        $head= apply_filters("table_th_".$field->name."_". $ViewData["ModelName"],$field->get_title($ViewData["ModelName"]));
                     echo '<th title="'.'مرتب سازی بر حسب'.' '.$head.'" class="'.$class.'"><a href="?page=1&sort_'.$field->name.'='.$sort.'">'.$head.'</a></th>';
                    }
                    include "btns_header.php";
                    ?>
                    <th class="last-th"></th>
                </tr>
                <?php
do_action("after_thead");
do_action("after_thead_" . $ViewData["ModelName"]);
?>
            </thead>
