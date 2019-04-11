<?php
include 'header.php';
include 'database_connection.php';
if(!isset($_SESSION)):
    session_start();
endif;

$errors = array();
$success = array();

    $email = $_SESSION['email'];

    //for token
    $sql_token = "SELECT registration_token FROM users WHERE company_email='$email'";
    $tokenQuery = mysqli_query($conn, $sql_token);
    $row = mysqli_fetch_assoc($tokenQuery);
    $token = $row['registration_token'];


    //for popup automatic cave name with cave type
    function fill_cave_name($conn){
        $output = '';
        $sql = "SELECT * FROM `cave`";
        $result = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_array($result))
        {
            $output .= '<option value="'.$row["id"].'">'.$row["cave_name"].'</option>';
        }
        return $output;
    }

    //entry code
    if (isset($_POST['box_entry'])):
        $boxName = $_POST['boxname'];
        $description = $_POST['description'];
        $rowid = $_POST['rowName'];
        $caveId = $_POST['caveName'];

        //for row name
        $sql = "SELECT `name` FROM `rows` WHERE id='$rowid'";
        $query = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($query);
        $row_name = $row['name'];

        //for row cave name
        $sql = "SELECT `cave_name` FROM `rows` WHERE id='$rowid'";
        $query = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($query);
        $cave_name = $row['cave_name'];

        //for entry book
        $s = "SELECT * FROM `boxs` WHERE row_id= '$rowid'";
        $r = mysqli_query($conn,$s);
        $num_rows = mysqli_num_rows($r);
        if($num_rows < 5):
            $sql_box = "INSERT INTO `boxs` (`name`,details,row_id,row_name,cave_name) VALUES ('$boxName', '$description', '$rowid', '$row_name', '$cave_name')";
            mysqli_query($conn, $sql_box);
            array_push($success,"box is stored properly.");
        else:
            array_push($errors, "There are no spece");
        endif;
    endif;
?>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <button class="btn btn-warning">Hired Item</button>
            </div>
        </div>

        <div class="row justify-content-center">
            <h4>Enter the box here fro use the row</h4>
            <div class="card col-md-12 box_entry">
                <form action="box-entry.php" method="post">
                    <?php if (count($success) > 0): ?>
                        <?php foreach ($success as $suc): ?>
                            <p class="alert alert-success"><?php echo $suc; ?></p>
                        <?php endforeach ?>
                    <?php endif; ?>

                    <?php if (count($errors) > 0): ?>
                        <?php foreach ($errors as $err): ?>
                            <p class="alert alert-danger"><?php echo $err; ?></p>
                        <?php endforeach ?>
                    <?php endif; ?>

                    <div class="form-group">
                        <label for="universtyName">Select a cave name name</label>
                        <select class="form-control" id="caveName" name="caveName">
                            <option selected hidden>Select one...</option>
                            <?php echo fill_cave_name($conn); ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="universtyName">Select a row name</label>
                        <select class="form-control" id="rowName" name="rowName">
                            <option selected hidden>Select one...</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="universtyName">Select a box name</label>
                        <select class="form-control" id="boxName" name="boxName">
                            <option selected hidden>Select one...</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="universtyName">Enter The file Name</label>
                        <input type="text" class="form-control" name="boxname" placeholder="Havana Propartice">
                    </div>

                    <div class="form-group">
                        <label for="universtyName">Enter file description</label>
                        <textarea placeholder="Enter description" id="company-content" name="description" rows="2" spellcheck="false" class="form-control autosize-target text-left"></textarea>
                    </div>

                    <div style="text-align: center;">
                        <input type="submit" class="btn btn-success" name="box_entry" value="Done">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function(){
            $('#caveName').change(function(){
                var row = $(this).val();
                $.ajax({
                    url:"load_data.php",
                    method:"POST",
                    data:{row:row},
                    success:function(data){
                        $('#rowName').html(data);
                    }
                });
            });
        });

        $(document).ready(function(){
            $('#rowName').change(function(){
                var box = $(this).val();
                $.ajax({
                    url:"load_data.php",
                    method:"POST",
                    data:{box:box},
                    success:function(data){
                        $('#boxName').html(data);
                    }
                });
            });
        });
    </script>


<?php
include 'footer.php';
?>