<?php
$update = false;
$insert = false;
$delete = false;
$servername = "localhost";
$username = "root";
$password = "";
$database = "notesphp";

//connection string for db connect

$conn = mysqli_connect($servername, $username, $password, $database);
if (!$conn) {
    die("db connection failed!!!!!!: " . mysqli_connect_error());
}

if(isset($_GET['delete'])) {
    $snodel = $_GET['delete'];
    $sqli = "DELETE FROM `notes` WHERE `srno` = $snodel";
    $resulti = mysqli_query($conn, $sqli);
    if (!$resulti) {
        echo "record not deleted  " . mysqli_error($conn) . "<br>";
    } else {
        $delete = true;
    }
    
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!(isset($_POST['snoEdit']))) {
        $title = $_POST['title'];
        $desc = $_POST['desc'];

        //inserting values in db
        $sqli = "INSERT INTO `notes` (`title`, `descrip`) VALUE ('$title','$desc')";
        $resulti = mysqli_query($conn, $sqli);
        if (!$resulti) {
            echo "record not added  " . mysqli_error($conn) . "<br>";
        } else {
            $insert = true;
        }
    } else {
        $snoedit = $_POST['snoEdit'];
        $edittitle = $_POST['edittitle'];
        $editdesc = $_POST['editdesc'];


        //Updating values in db
        $sqli = "UPDATE `notes` SET `title` = '$edittitle' , `descrip` = '$editdesc' WHERE `notes`.`srno` = $snoedit";

        $resulti = mysqli_query($conn, $sqli);

        if ($resulti) {
            $update = true;
        } else {
            echo "record not updated  " . mysqli_error($conn) . "<br>";
        }
    }
}
?>

<!doctype html>
<html lang="en">

<head>
   
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
    <title>Notes PHP pojec</title>
</head>
<style>

</style>


<body>

    <div class="modal fade" id="editmodal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit this note</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>
                    <form action="/notespojec/index.php" method="post">
                        <input type="hidden" name="snoEdit" id="snoEdit">
                        <div class="form-group">
                            <label for="edittitle">Notes Title</label>
                            <input type="text" class="form-control" id="edittitle" name="edittitle">
                        </div>
                        <div class="form-group">
                            <label for="editdesc">Note Description</label>
                            <textarea class="form-control" id="editdesc" name="editdesc" rows="3"></textarea>

                        </div>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </form>
                    </p>
                </div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">NotesP</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="/notespojec/index.php">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Contact</a>
                </li>

            </ul>
            <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
        </div>
    </nav>

    <?php
    if ($insert) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!!</strong> Note added successfully.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>';
    }
    if ($update) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!!</strong> Note updated successfully.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>';
    }
    if ($delete) {

        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>Success!</strong> Note deleted successfully.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>';
    }
    ?>
    <div class="container my-2">
        <h3>Add Notes to Notespojec</h3>
        <form action="/notespojec/index.php" method="post">
            <div class="form-group">
                <label for="title">Notes Title</label>
                <input type="text" class="form-control" id="title" name="title">
            </div>
            <div class="form-group">
                <label for="desc">Note Description</label>
                <textarea class="form-control" id="desc" name="desc" rows="3"></textarea>

            </div>

            <button type="submit" class="btn btn-primary">Add Note</button>
        </form>
    </div>
    <div class="container notetab">

        <table class="table" id="myTable">
            <thead>
                <tr>
                    <th scope="col">Sr.no.</th>
                    <th scope="col">Title</th>
                    <th scope="col">Description</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM `notes`";
                $result = mysqli_query($conn, $sql);
                $srn = 0;
                while ($row = mysqli_fetch_assoc($result)) {
                    $srn = $srn + 1;
                    echo "<tr>
                   <th scope='row'>" . $srn . "</th>
                   <td>" . $row['title'] . "</td>
                   <td>" . $row['descrip'] . "</td>
                   <td> <button class='edit btn btn-primary' id=" . $row['srno'] . ">Edit</button> <button class='delete btn btn-primary' id=" . $row['srno'] . ">Delete</button></td>
                 </tr>";
                }
                ?>
            </tbody>
        </table>

    </div>
    
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <script>
 
        $(document).ready(function() {
            $('#myTable').DataTable();

        });


        //row data is not selected after page 1 do not use:
        //let table = new DataTable('#myTable');
    </script>
    <script>
               
        edits = document.getElementsByClassName('edit');
  

        Array.from(edits).forEach((element) => {
            element.addEventListener("click", (e) => {
                tr = e.target.parentNode.parentNode;
                title = tr.getElementsByTagName("td")[0].innerText;
                description = tr.getElementsByTagName("td")[1].innerText;
                edittitle.value = title;
                editdesc.value = description;
                snoEdit.value = e.target.id;
                console.log(e.target.id, title, description);
                $('#editmodal').modal('toggle');
            })
        })
</script>
<script>
        deletes = document.getElementsByClassName('delete');
        //console.log(deletes);
        Array.from(deletes).forEach((element) => {
        element.addEventListener("click", (e) => {
            snodel = e.target.id;
            tr = e.target.parentNode.parentNode;
            title = tr.getElementsByTagName("td")[0].innerText;
            console.log(snodel);
            if(confirm(`do you want to delete ${title} note??`)){
                console.log(snodel);
                window.location = `/notespojec/index.php?delete= ${snodel}`;

            }
            else{
                console.log("not deleted");
            }
        })
    })
    </script>
</body>

</html>
