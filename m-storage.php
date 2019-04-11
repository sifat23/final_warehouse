<?php
include 'database_connection.php';
include 'm-header.php';

//for popup automatic cave name with cave type
function fill_company_name($conn){
    $output = '';
    $sql = "SELECT * FROM `users`";
    $result = mysqli_query($conn, $sql);
    $output .= '<option value="NULL" hidden selected disabled>Plsease Select a Company</option>';
    while($row = mysqli_fetch_array($result))
    {
        $output .= '<option value="'.$row["id"].'">'.$row["user_name"].'</option>';
    }
    return $output;
}
?>

<div class="container">
    <div class="row justify-content-center align-content-center" style="margin-top: 1rem; margin-bottom: 2rem">
        <div class="col-md-6">
            <div class="card">
                <div class="card-title">
                    <h4>Warehouse Forum</h4>
                </div>
                <div class="card-body"><hr style="margin-top: -1rem !important;">
                   <div class="form-group">
                       <select class="form-control" id="c_name">
                           <?php echo fill_company_name($conn); ?>
                       </select>


                   </div>
                </div>
            </div>
        </div>
    </div>

    <div id="details">
    </div>



        <script>
            $(document).ready(function(){
                $('#c_name').change(function(){
                    var name = $(this).val();
                    $.ajax({
                        url:"more_load.php",
                        method:"POST",
                        data:{name:name},
                        success:function(data){
                            $('#details').html(data);
                        }
                    });
                });
            });

            //rest data finding with item code
            $(document).on('click', '.view_data', function () {
                var pack = $(this).attr('id');
                //alert(pack);
                $.ajax({
                    url: "more_load.php",
                    method: "POST",
                    data: {pack: pack},
                    success: function (data) {
                        $('#md').html(data);
                    }
                });
            });
        </script>


    <!-- Large modal -->
    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" style=" max-width: 100% !important;">
            <div class="modal-content" style="padding: 2rem">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="md">

                </div>
            </div>
        </div>
    </div>