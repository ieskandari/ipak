<?php
class export
{
    var $data = array();
    var $plugin = "";
    var $model = "";
    var $header = array();
    function __construct($params = array())
    {
        $this->data = $params["data"];
        $this->header = $params["header"];
        $this->plugin = $params["plugin"];
        $this->model = $params["model"];
    }
    function toCSV()
    {
        header('Content-Encoding: UTF-8');
        header('Content-Type: text/csv; charset=utf-8');
        header(sprintf('Content-Disposition: attachment; filename=csv-%s.csv', date('dmY-His')));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        //echo "\xEF\xBB\xBF";
        $data = [];
        $row1 = [];
        foreach ($this->header as $field) {
            $row1[] = $field->title;
        }
        $data[] = $row1;

        foreach ($this->data as $row) {
            $row1 = [];
            foreach ($this->header as $field) {
                //if(isset($row[$field->name]))
                {
                    $row1[] = get_field_data($row, $field, true, $this->plugin, $this->model);
                }
            }
            $data[] = $row1;
        }
        $df = fopen('php://output', 'w');
        //This line is important:
        //   fputs( $df, "\xEF\xBB\xBF" ); // UTF-8 BOM !!!!!
        fputs($df, $bom = chr(0xEF) . chr(0xBB) . chr(0xBF));
        foreach ($data as $row) {
            fputcsv($df, $row);
        }
        fclose($df);
        exit();
    }
    function toExcel()
    {

        header('Content-Encoding: UTF-8');
        $timestamp = time();
        $filename = 'excel_' . $timestamp . '.xls';

        header("Content-Type: application/vnd.ms-excel; charset=utf-8");

        header("Content-Disposition: attachment; filename=\"$filename\"");
        $str = '<html xmlns:o="urn:schemas-microsoft-com:office:office"
xmlns:x="urn:schemas-microsoft-com:office:excel"
xmlns="http://www.w3.org/TR/REC-html40">
    <head>
        <meta http-equiv=Content-Type content="text/html; charset=windows-1252"/>
        <meta name=ProgId content=Excel.Sheet/>
        <meta name=Generator content="Microsoft Excel 11"/>';
        $str = $str . "</head>";
        $str = $str . "<body>";
        $str = $str . "<table>";
        $str = $str . "<thead>";
        $str = $str . "<tr>";
        foreach ($this->header as $field) {
            $str = $str . "<th>" . $field->title . "</th>";
        }
        $str = $str . "</tr>";
        $str = $str . "</thead>";
        $str = $str . "<tbody>";
        foreach ($this->data as $row) {
            $str = $str . "<tr>";
            foreach ($this->header as $field) {
                if (isset($row[$field->name])) {
                    $str = $str . "<td>" . $row[$field->name] . "</td>";
                }
            }
            $str = $str . "</tr>";
        }
        $str = $str . "</tbody>";
        $str = $str . "</table>";
        $str = $str . "</body>";
        $str = $str . "</html>";
        $str = mb_convert_encoding($str, "HTML-ENTITIES", "UTF-8");

        echo $str;

        exit();
    }
    function print_t()
    {

        global $ViewData;
        $ViewData["PrintHeader"] = array();
        $ViewData["PrintData"] = $this->data;
        $ViewData["PrintFontSize"] = 12;
        if (isset($_POST["font-size"])) {
            $ViewData["PrintFontSize"] = $_POST["font-size"];
        }

        foreach ($this->header as $field) {
            if (isset($_POST[$field->name . "_check"])) {
                $ViewData["PrintHeader"][] = $field;
            }
        }
        if (isset($_POST["title"])) {
             include "export-save.php";
            return;
        }
        if ($ViewData["IsGroupBy"]) {
            include "print-group-by.php";
        } else {
            include "print-table.php";
        }
    }
    function toExcelNew()
    {
    }
}
