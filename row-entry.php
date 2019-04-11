<?php
    include 'header.php';
    include 'database_connection.php';

    $errors = array();
    $success = array();

    if(!isset($_SESSION)):
        session_start();
    endif;

    //entry code
    if (isset($_POST['rows_entry'])):
        $rowName = $_POST['row_name'];
        $description = $_POST['description'];
        $caveID = $_POST['caveName'];
        $caveType = $_POST['caveType'];

        $s = "SELECT * FROM `rows` WHERE cave_id= '$caveID'";
        $r = mysqli_query($conn,$s);
        $num_rows = mysqli_num_rows($r);
        if($num_rows < 5):
            $sql_row = "INSERT INTO `rows` (`name`,details,cave_id,cave_type) VALUES ('$rowName', '$description', '$caveID', '$caveType')";
            mysqli_query($conn, $sql_row);
            array_push($success,"Rows is stored properly.");
        else:
            array_push($errors, "There are no spece.");
        endif;

    endif;

?>
    <div class="container col-md-6 center-screen">
        <div class="card">
            <div class="card-header">
                Featured
            </div>
            <div class="card-body">
                <form method="post" action="row-entry.php">
                    <?php if (count($errors) > 0): ?>
                        <?php foreach ($errors as $error): ?>
                            <p class="alert alert-danger"><?php echo $error; ?></p>
                        <?php endforeach ?>
                    <?php endif; ?>

                    <?php if (count($success) > 0): ?>
                        <?php foreach ($success as $suc): ?>
                            <p class="alert alert-success"><?php echo $suc; ?></p>
                        <?php endforeach ?>
                    <?php endif; ?>

                    <div class="form-group">
                        <label for="universtyName">Enter the row name</label>
                        <input type="text" class="form-control" name="row_name" placeholder="Havana Propartice">
                    </div>

                    <div class="form-group">
                        <label for="universtyName">Enter The row Description</label>
                        <textarea placeholder="Enter description" id="company-content" name="description" rows="2" spellcheck="false" class="form-control autosize-target text-left"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="universtyName">Enter The Type of Cave</label>
                        <select class="form-control" id="caveType" name="caveType">
                            <option selected hidden>Select one...</option>
                            <option value="Data House">Data House</option>
                            <option value="Grosarry">Grosarry</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="universtyName">Enter The Type of Cave</label>
                        <select class="form-control" id="caveName" name="caveName">
                            <option selected hidden>Select one...</option>
                        </select>
                    </div>

                    <input type="submit" class="btn btn-success" value="Done" name="rows_entry">
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function(){
            $('#caveType').change(function(){
                var t = $(this).val();
                $.ajax({
                    url:"load_data.php",
                    method:"POST",
                    data:{type:t},
                    success:function(data){
                        $('#caveName').html(data);
                    }
                });
            });
        });
    </script>

<?php
include 'footer.php';
?>