<?php
    include 'header.php';
    include 'database_connection.php';
    if(!isset($_SESSION)):
        session_start();
    endif;

    $errors = array();
    $success = array();


    $email = $_SESSION['email'];

    $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
    $date = $dt->format('Y-m-d');
    $time = $dt->format('h:i:s');

    //for company id
    $sql_name = "SELECT id FROM users WHERE company_email='$email'";
    $usernameQuery = mysqli_query($conn, $sql_name);
    $row = mysqli_fetch_assoc($usernameQuery);
    $company_id = $row['id'];

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

    if (isset($_POST['files_entry'])):
        $fileName = $_POST['file_name'];
        $description = $_POST['description'];
        $boxid = $_POST['boxName'];
        $rowid = $_POST['rowName'];
        $caveId = $_POST['caveName'];
        $code = $_POST['item_code'];
        $unit = $_POST['file_unit'];

        $code_check_query = "SELECT * FROM `files` WHERE itemcode='$code' LIMIT 1";
        $result = mysqli_query($conn, $code_check_query);
        $unique = mysqli_fetch_assoc($result);

        if ($unique): // if user exists
            if ($unique['itemcode'] === $code):
                array_push($errors, "Item code already exists");
            endif;
        endif;

        //for entry book
        $s = "SELECT * FROM `files` WHERE box_id= '$boxid'";
        $r = mysqli_query($conn,$s);
        $num_rows = mysqli_num_rows($r);
        if($num_rows < 5):
            $sql_box = "INSERT INTO `files` (`name`,description,company_id,row_id,box_id,cave_id,datevalue,timevalue, itemcode, unit) VALUES ('$fileName', '$description','$company_id', '$rowid', '$boxid', '$caveId', '$date','$time', '$code', '$unit')";
            mysqli_query($conn, $sql_box);
            array_push($success,"box is stored properly.");
        else:
            array_push($errors, "There are no spece");
        endif;
    endif;

?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="card col-lg-12" style="margin-top: 25px; margin-bottom: 20px;">
                <div class="card-header" style="text-align: center; background: #A3E4D7;">
                    Welcome <strong><?php echo $username ?></strong>
                </div>

                <div class="card-body">
                    <div class="card-body">
                        <form method="post" action="company-input.php">
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
                                <label for="universtyName">Enter the name of itmes</label>
                                <input type="text" class="form-control" name="box_name">
                            </div>

                            <div class="form-group">
                                <label for="universtyName">Select a cave</label>
                                <select class="form-control" id="caveName" name="caveName">
                                    <option selected hidden>Select one...</option>
                                    <?php echo fill_cave_name($conn); ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="universtyName">Select a row</label>
                                <select class="form-control" id="rowName" name="rowName">
                                    <option selected hidden>Select one...</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="universtyName">Select a box</label>
                                <select class="form-control" id="boxName" name="boxName">
                                    <option selected hidden>Select one...</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="universtyName">Enter the file name</label>
                                <input type="text" class="form-control" name="file_name" placeholder="draf paper">
                            </div>

                            <div class="form-group">
                                <label for="universtyName">Enter the item code</label>
                                <input type="text" class="form-control" name="item_code" placeholder="ebea0000">
                            </div>

                            <div class="form-group">
                                <label for="universtyName">Enter the file description</label>
                                <textarea placeholder="Enter description" id="company-content" name="description" rows="2" spellcheck="false" class="form-control autosize-target text-left"></textarea>
                            </div>

                            <div class="form-group">
                                <label for="universtyName">Enter the unit of itmes</label>
                                <input type="text" class="form-control" name="file_unit" placeholder="12" ">
                            </div>

                            <div style="text-align: center">
                                <input type="submit" class="btn btn-success btn-lg" value="Done" name="files_entry">
                            </div>
                        </form>
                    </div>
                </div>
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