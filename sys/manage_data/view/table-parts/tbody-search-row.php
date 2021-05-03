<tr>
    <td></td>
    <td>

    </td>
    <?php
    foreach ($ViewData["HeaderData"] as $key => $field) {
        $value = "";
        $class = "";
        if (isset($ViewData["HeaderDataSearchValue"][$field->name])) {
            $value = $ViewData["HeaderDataSearchValue"][$field->name];
            $class = "form-control-warning";
        }
        if (!$field->has_fk() && $field->type != "date" && $field->type != "datetime") {
            echo '<td><form action="?page=1" method="post"><input class="' . $class . '" value="' . $value . '" id="search_' . $field->name . '" name="search_' . $field->name . '" /></form></td>';
        } else {
            echo '<td></td>';
        }
    }
    ?>
    <td></td>
</tr>