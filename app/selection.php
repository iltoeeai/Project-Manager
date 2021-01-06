<?php
#LOGIC TO SELECT THE TABLE
$table_name = 'employees';

if (isset($_GET['path']) and $_GET['path'] !== $table_name) {
    if ($_GET['path'] == 'employees' or $_GET['path'] == 'projects')
        $table_name = $_GET['path'];
}
// echo $table_name;

#SELECT
$sql =
    "SELECT "
    . $table_name . ".id, "
    . $table_name . ".name, GROUP_CONCAT(" . ($table_name === 'projects' ? 'employees' : 'projects') . ".name SEPARATOR '; ')" .
    " FROM " . $table_name .
    " LEFT JOIN " . ($table_name === 'projects' ? 'employees' : 'projects') .
    " ON " . ($table_name === 'projects' ? 'employees.project_id = projects.id' : 'employees.project_id = projects.id') .
    " GROUP BY " . $table_name . ".id";