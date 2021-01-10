<?php
session_start();
include 'database/database.php';
include 'app/selection.php';
include 'app/save.php';
include 'app/delete.php';
include 'app/search.php';
include 'app/edit.php';
include 'app/update.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Project Manager</title>
    <link rel="stylesheet" href="resources/css/style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</head>

<body>
    <?php

    if (isset($_SESSION['message'])) : ?>
        <div class="alert mr-2 ml-2 alert-<?= $_SESSION['msg_type'] ?>">
            <?php
            echo $_SESSION['message'];
            unset($_SESSION['message']);
            ?>
        </div>
    <?php endif ?>

    <header>
        <div class="shadow-container mr-2 ml-2">
            <div class="body-content">
                <nav class="navbar navbar-expand-lg navbar-light bg-light mt-3 ">
                    <div class="collapse navbar-collapse " id="navbarSupportedContent">
                        <div>
                            <div class="dropdown mr-5 ">
                                <button class="btn btn-primary dropdown-toggle pr-4 pl-4" type="button" data-toggle="dropdown">Manage Table
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
                    <div class="float-end align-middle"><span class="align-middle text-primary ">PROJECT MANAGER</span></div>
                </nav>
            </div>
        </div>
    </header>

    <main>
        <div class="container mt-5">
            <div class="row justify-content-left">

                <form action="<?php ($_SERVER['REQUEST_URI']); ?>" method="post">
                    <?php if ($_GET['path'] == "employees" || $_GET['path'] == "") : ?>
                        <div class="form-group">
                            <label for="name"><?php echo (($update == true) ? ("<strong>Edit Employee</strong>") : ("<strong>Add Employee</strong>")); ?></label>
                            <div class="form-group d-flex">
                                <input type="text" class="form-control" name="name" value="<?php echo ($update == true ? $first_en : ""); ?>" placeholder="Enter employee's name">

                                <?php

                                if ($update) {
                                    $query = "SELECT projects.id, projects.name FROM projects";
                                    $res = mysqli_query($conn, $query) or die(mysqli_connect_error($query));
                                    echo ("<select class='ml-5 custom-select' name='select_name'>");
                                    echo ("<option value=''selected disabled>Projects</option>");
                                    while ($row = mysqli_fetch_array($res)) {
                                        echo "<option value=" . $row['id'] . ">" . $row['name'] . "</option>";
                                    }
                                    echo ("</select>");
                                }
                                ?>
                            </div>

                        </div>
                    <?php else : ?>
                        <div class="form-group">
                            <label for="name"><?php echo (($update == true) ? ("<strong>Edit Project</strong>") : ("<strong>Add Project</strong>")); ?></label>
                            <input type="text" class="form-control" value="<?php echo ($update == true ? $first_en : ""); ?>" name="name" placeholder="Enter project's name">
                        </div>
                    <?php endif; ?>

                    <div class="form-group">

                        <?php if ($update == true) : ?>
                            <button class="btn btn-info" type="submit" name="update">Update</button>
                        <?php else : ?>
                            <button class="btn btn-primary" type="submit" name="save">Save</button>
                        <?php endif; ?>

                    </div>
                </form>

            </div>
        </div>

        <?php

        print('<div class="container mt-5"><table class="table"><thead><tr><th>ID</th><th>' . ($_GET['path'] === 'projects' ?  "Project's Name" : "Employee's Name") . '</th><th>' . ($_GET['path'] === 'projects' ?  "Employee's Name" : "Project's Name") . '</th><th>Action</th>');

        $stmt->execute();
        $stmt->store_result();
        $count = $stmt->num_rows;
        if ($count > 0) {
            while ($stmt->fetch()) {
                echo "<tr>
                    <td>" . $id . "</td>
                    <td>" . $first_en . "</td>
                    <td>" . $second_en . "</td>
                    <td>
                        <button><a href=\"?path=" . $table_name . "&delete=$id\">" . ($_GET['path'] === 'projects' ?  "DELETE PROJECT" : "DELETE EMPLOYEE") . "</a></button>
                        <button><a href=\"?path=" . $table_name . "&edit=$id\">" . ($_GET['path'] === 'projects' ?  "EDIT PROJECT" : "EDIT EMPLOYEE") . "</a></button>
                    </td>
                </tr>";
            }
            print('</table>');
            print('<br />');
            print('<br />');
        } else {
            echo ("<tr>
        <td>No data found</td></tr>");
            print('</table>');
        }
        ?>
    </main>

    <footer class="footer mt-auto py-3 bg-light">
        <div class="container mr-2 ml-2">
            <span class="text-muted">Tadas Baltic Institute of technology 2021</span>
        </div>
    </footer>
</body>

</html>
<?php
$stmt->free_result();
$stmt->close();

mysqli_close($conn);
unset($_SESSION['msg_type']);
session_destroy();
?>