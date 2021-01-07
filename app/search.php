<?php
#SEARCH
if (isset($_POST['search1'])) {
    if ($_GET['path'] == 'employees' || $_GET['path'] == "") {

        $search_term = $conn->real_escape_string($_POST['search_box']);
        $sql_search = "SELECT employees.id, employees.name, projects.name FROM employees LEFT JOIN projects ON employees.project_id = projects.id WHERE employees.name LIKE '%$search_term%'";
        $stmt = $conn->prepare($sql_search);

        $stmt->bind_result($id, $first_en, $second_en);

    } else {
        $search_term = $conn->real_escape_string($_POST['search_box']);
        $sql_search = "SELECT projects.id, projects.name, employees.name FROM projects LEFT JOIN employees ON employees.project_id = projects.id WHERE projects.name LIKE '%$search_term%'";
        $stmt = $conn->prepare($sql_search);
        $stmt->bind_result($id, $first_en, $second_en); //binding by position
    }
} else {
    $stmt = $conn->prepare($sql);
    $stmt->bind_result($id, $first_en, $second_en);
}