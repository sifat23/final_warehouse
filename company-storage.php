<?php
    include 'home_header.php';
    include 'database_connection.php';
    if(!isset($_SESSION)):
        session_start();
    endif;

    $errors = array();

    $email = $_SESSION['email'];
    $sql_name = "SELECT id FROM users WHERE user_email='$email'";
    $usernameQuery = mysqli_query($conn, $sql_name);
    $row = mysqli_fetch_assoc($usernameQuery);
    $company_id = $row['id'];

//    $sql = "SELECT * FROM files WHERE company_id='$company_id'";
//    $result = mysqli_query($conn, $sql);


    if(isset($_POST['search'])):
        $valueToSearch = $_POST['valueToSearch'];
        // search in all table columns
        // using concat mysql function
        $query = "SELECT * FROM `packs` WHERE company_id='$company_id' AND CONCAT(`pack_code`,`name`) LIKE '%".$valueToSearch."%'";
        $search_result = filterTable($query);
    else:
        $query = "SELECT * FROM `packs` WHERE company_id='$company_id' ";
        $search_result = filterTable($query);
    endif;

    // function to connect and execute the query
    function filterTable($query){
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "test";

        $conn = mysqli_connect($servername, $username, $password, $dbname);
        $filter_Result = mysqli_query($conn, $query);
        return $filter_Result;
    }

?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="card col-lg-12" style="margin-top: 5rem; margin-bottom: 5px;">
                <div class="card-header" style="text-align: center; background: #A3E4D7;">
                    <p>What you looking for?</p>
                </div>
                <form action="company-storage.php" method="post">

                    <?php if (count($errors) > 0): ?>
                        <?php foreach ($errors as $err): ?>
                            <p class="alert alert-danger"><?php echo $err; ?></p>
                        <?php endforeach ?>
                    <?php endif; ?>


                    <div class="row">
                        <div class="col-lg-10" style="margin-top: 10px;">
                            <div class="form-group">
                                <input type="text" name="valueToSearch" class="form-control" placeholder="Type the item code here" style="text-align: center;">
                            </div>
                        </div>
                        <div class="col-lg-1">
                            <input type="submit" name="search" style="margin-left: 4px;" class="btn btn-info btn-lg" value="Filter">
                        </div>
                    </div>
                </form>
            </div>

            <div class="card col-md-12">
                <table class="table table-striped table-dark" style="margin-top: 15px; text-align: center">
                    <thead>
                    <tr>
                        <th scope="col">CODE</th>
                        <th scope="col">NAME</th>
                        <th style="width: 470px;" scope="col">DESCRIPTION</th>
                        <th scope="col">MANUFACTURER</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php while($rows = mysqli_fetch_assoc($search_result)): ?>
                        <tr>
                            <td class="nr"><?php echo $rows['pack_code'] ?></td>
                            <td><?php echo $rows['name']; ?></td>
                            <td style="width: 470px;"><?php echo $rows['short_details']; ?></td>
                            <td><?php echo $rows['pack_manufacturer']; ?></td>
                            <td>
                                <input type="button" value="More" class="btn btn-primary btn-sm view_data" data-toggle="modal" data-target="#exampleModalCenter">
                            </td>
                        </tr>
                    <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>


        <script>
            $(document).ready(function(){
                $(".view_data").click(function(){
                    var id = $(this).closest("tr");
                    var text = id.find(".nr").text();
                    //alert(text);
                    $.ajax({
                        url:"load_data.php",
                        method:"POST",
                        data:{code:text},
                        success:function(data){
                            $('#selection').html(data);
                        }
                    });
                });
            });
        </script>


        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Item Details</h5>
                    </div>
                    <div class="modal-body" id="selection">
                    </div>
                    <div class="modal-footer">
                        <input type ="submit" class="btn btn-primary">
                        <button type ="button" class ="btn btn-light" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
<br>



<?php
include 'user_footer.php';
?>