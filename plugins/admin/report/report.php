<?php
class report
{
    var $model = "";
    var $query_cnt = "";
    var $orderby = "";
    var $fields = array();
    var $add_query = "";
    var $params = array();
    var $add_posts = array();
    var $chartTitle = "";
    function view()
    {
        global $TR_db, $TR_tools, $ViewData;

        foreach ($this->add_posts as $post) {
            if (isset($_POST[$post]) && $_POST[$post] > 0) {
                $this->params[":" . $post] = $_POST[$post];
                $this->add_query = $this->add_query . " and " . $post . "=:" . $post;
            }
        }
        $ViewData["Fields"] = $this->get_fields_report();
        $ViewData["ChartTitle"] = $this->chartTitle;
        $chart_labels = array();
        $chart_data = array();
        $excel_data = array();
        $query = "";
        $year_id = -1;
        $month_id = 0;
        if (isset($_POST["year_id"])) {
            $year_id = $_POST["year_id"];
        }
        if (isset($_POST["month_id"])) {
            $month_id = $_POST["month_id"];
        }
        if ($month_id > 0) {
            $year = get_jalali_year($year_id);
            $count_day = 30;
            if ($month_id < 7) {
                $count_day = 31;
            }
            $order_by = $this->orderby;


            for ($x=1;$x<=$count_day;$x++) {
                $query = " select " . $this->query_cnt . " as cnt from " . $this->model . "  where 1=1 " . $this->add_query . " and ((" . $this->orderby . ">='" . $TR_tools->to_miladi($year . "/" . $month_id . "/".$x) .' 00:00:00'. "' and ". $this->orderby . "<='" . $TR_tools->to_miladi($year . "/" . $month_id . "/".$x) .' 23:59:59'. "') or ". $this->orderby . "='". $TR_tools->to_miladi($year . "/" . $month_id . "/".$x)."') ";
                $rows = $TR_db->pdo_json($query, $this->params);
              // echo $query.'<br>';
                $title=$year . "/" . $month_id . "/".$x;
                $chart_labels[] = $title;
           
                $chart_data[] = $rows[0]["cnt"];
                $excel_data[] = array("title" => $title, "val" => $rows[0]["cnt"]);
            }
        } else if ($year_id == 0) {
            $query = "select * from " . $this->model . " where 1=1 " . $this->add_query . " order by " . $this->orderby . " desc limit 1";
            $rows = $TR_db->pdo_json($query, $this->params);
            if (count($rows) > 0) {
                $last_date = $TR_tools->to_jalali($rows[0]["" . $this->orderby . ""], "Y");

                $query = "select * from " . $this->model . " where 1=1 " . $this->add_query . " order by " . $this->orderby . "  limit 1";
                $rows = $TR_db->pdo_json($query, $this->params);
                $first_date = $TR_tools->to_jalali($rows[0]["" . $this->orderby . ""], "Y");
                for ($x = $first_date; $x <= $last_date; $x++) {

                    $query = " select " . $this->query_cnt . " as cnt from " . $this->model . "  where 1=1 " . $this->add_query . " and " . $this->orderby . ">='" . $TR_tools->to_miladi($x . "/1/1") . "' and " . $this->orderby . "<='" . $TR_tools->to_miladi($x . "/12/30") . "'";
                    $rows = $TR_db->pdo_json($query, $this->params);
                    $chart_labels[] = $x;
                    $chart_data[] = $rows[0]["cnt"];
                    $excel_data[] = array("title" => $x, "val" => $rows[0]["cnt"]);
                }
            }
        } else {
            $query = "select * from admin_admin_year where id=:id ";
            $rows = $TR_db->pdo_json($query, array(":id" => $year_id));
            $year = $year_id;
            if (count($rows) > 0) {
                $year = $rows[0]["content"];
            }
            $months = get_range_month($year);
            foreach ($months as $month) {
                $query = " select " . $this->query_cnt . " as cnt from " . $this->model . " where 1=1 and " . $this->add_query . " " . $this->orderby . ">='" . $TR_tools->to_miladi($month["from"]) . "' and " . $this->orderby . "<='" . $TR_tools->to_miladi($month["to"]) . "'";

                $rows = $TR_db->pdo_json($query, $this->params);
                $chart_labels[] = $month["title"];
                $chart_data[] = $rows[0]["cnt"];
                $excel_data[] = array("title" => $month["title"], "val" => $rows[0]["cnt"]);
            }
        }
        $ViewData["MyData"] = $excel_data;

        $ViewData["ChartLabels"] = $TR_tools->json_encode($chart_labels);
        $ViewData["ChartData"] = $TR_tools->json_encode($chart_data);
        if (isset($_POST["excel"])) {
            $this->excel($excel_data);
            return;
        }
        include BasePath . "plugins/admin/report/view/report.php";
    }

    function excel($inputdata)
    {
        header('Content-Encoding: UTF-8');
        header('Content-Type: text/csv; charset=utf-8');
        header(sprintf('Content-Disposition: attachment; filename=csv-%s.csv', date('dmY-His')));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        //   echo "\xEF\xBB\xBF";
        $data = [];
        $row1 = [];
        $row1[] = "عنوان";
        $row1[] = "مقدار";
        $data[] = $row1;

        foreach ($inputdata as $row) {
            $row1 = [];
            $row1[] = $row["title"];
            $row1[] = $row["val"];
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
    function get_fields_report()
    {
        $fields = array();
        $fields["year_id"] = new field(
            array(
                "name" => "year_id", "title" => "سال", "type" => "bigint", "nullable" => true, "is_form_filter" => true, "in_form" => true, "fk" => array(
                    "model" => "admin/admin_year", "key" => "id", "title" => "title"
                )
            )
        );
        $fields["month_id"] = new field(
            array(
                "name" => "month_id", "title" => "ماه", "type" => "bigint", "nullable" => true, "is_form_filter" => true, "in_form" => true, "fk" => array(
                    "model" => "admin/admin_month", "key" => "id", "title" => "title"
                )
            )
        );
        foreach ($this->fields as $key => $field) {
            $fields[$key] = $field;
        }
        return $fields;
    }
}
