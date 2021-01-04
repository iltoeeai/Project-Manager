<?php
include 'database.php';

$table = 'employees';

if (isset($_GET['path']) and $_GET['path'] !== $table) {
    if ($_GET['path'] == 'employees' or $_GET['path'] == 'projects')
        $table = $_GET['path'];
}
// echo $table;

$sql = "SELECT "
    . $table . ".id, "
    . $table . ".name, GROUP_CONCAT(" . ($table === 'projects' ? 'employees' : 'projects') . ".name SEPARATOR \", \")" .
    " FROM " . $table .
    " LEFT JOIN " . ($table === 'projects' ? 'employees' : 'projects') .
    " ON " . ($table === 'projects' ? 'employees.project_id = projects.id' : 'employees.project_id = projects.id') .
    " GROUP BY " . $table . ".id";


if (isset($_POST['search1'])) {
    if ($_GET['path'] == 'employees' || $_GET['path'] == "") {

        $search_term = $conn->real_escape_string($_POST['search_box']);
        $sql_search = "SELECT employees.id, employees.name, projects.name FROM employees, projects WHERE employees.project_id = projects.id AND employees.name LIKE '%$search_term%'";
        $stmt = $conn->prepare($sql_search);
        $stmt->bind_result($id, $first_en, $second_en);
    } else {
        $search_term = $conn->real_escape_string($_POST['search_box']);
        $sql_search = "SELECT projects.id, projects.name, employees.name FROM employees, projects WHERE employees.project_id = projects.id AND projects.name LIKE '%$search_term%'";
        $stmt = $conn->prepare($sql_search);
        $stmt->bind_result($id, $first_en, $second_en);
    }
} else {
    $stmt = $conn->prepare($sql);
    $stmt->bind_result($id, $first_en, $second_en);
}

$stmt->execute();
// var_dump($stmt);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Project Manager</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</head>

<body>
    <header>
        <div class="shadow-container">
            <div class="body-content">
                <nav class="navbar navbar-expand-lg navbar-light bg-light mt-3 ">
                    <div class="collapse navbar-collapse " id="navbarSupportedContent">
                        <div>
                            <div class="dropdown mr-5 ">
                                <button class="btn btn-primary dropdown-toggle pr-4 pl-4" type="button" data-toggle="dropdown">Manage Data
                                    <span class="caret"></span></button>
                                <ul class="dropdown-menu">
                                    <div class="d-flex flex-column justify-content-center align-items-center">
                                        <li class="mt-2"><a href="?path=projects">Projects</a></li>
                                        <li class="mt-2 mb-2"><a href="?path=employees">Employees</a></li>
                                    </div>
                                </ul>
                            </div>
                        </div>
                        <form class="form-inline my-2 my-lg-0" action="" method="post" name="search_form">
                            <input class="form-control mr-sm-2" type="text" name="search_box" value="" placeholder="<?php echo ($_GET['path'] === 'projects' ?  "Enter project's name" : "Enter employee's name"); ?>">
                            <button class="btn btn-outline-success my-2 my-sm-0" type="submit" name="search1" value="Search">
                                <?php echo ($_GET['path'] === 'projects' ?  "Search for project" : "Search for employee"); ?></button>
                        </form>
                    </div>
                </nav>
            </div>
        </div>
    </header>
    <main>

        <?php

        print('<div class="container mt-5"><table class="table"><thead><tr><th>ID</th><th>Name</th><th>' . ($_GET['path'] === 'projects' ?  "Employee" : "Projects") . '</th><th>Action</th>');

            while ($stmt->fetch()) {
                echo "<tr>
                    <td>" . $id . "</td>
                    <td>" . $first_en . "</td>
                    <td>" . $second_en . "</td>
                    <td>
                        <button><a href=\"?path=" . $table . "&delete=$id\">DELETE</a></button>
                        <button><a href=\"?path=" . $table . "&update=$id\">UPDATE</a></button>
                    </td>
                </tr>";
            }
        ?>
    </main>
</body>

</html>
<?php
$stmt->close();

mysqli_close($conn);
?>