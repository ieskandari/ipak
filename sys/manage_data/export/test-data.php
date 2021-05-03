<?php
    function to_excel($data, $headers = array())
    {
        header('Content-Encoding: UTF-8');
        header('Content-Type: text/csv; charset=utf-8');
        header(sprintf('Content-Disposition: attachment; filename=my-csv-%s.csv', date('dmY-His')));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
   
        $df = fopen('php://output', 'w');
        //This line is important:
        //  fputs( $df, "\xEF\xBB\xBF" ); // UTF-8 BOM !!!!!
        fputs($df, $bom = chr(0xEF) . chr(0xBB) . chr(0xBF));
        foreach ($data as $row) {
            fputcsv($df, $row);
        }
        fclose($df);
        exit();
    }
    $data=array();
    $data[]=array("name"=>"جلیل","lname"=>"نوری");
    $data[]=array("name"=>"بهنام","lname"=>"اسماعیلی");
    to_excel($data);
