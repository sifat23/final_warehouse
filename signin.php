<?php
    include 'code.php';
    include 'header.php';
?>


    <div class="bg-local">
        <div class="container" >
            <div class="row h-100 justify-content-center align-items-center">
                <div class="card col-md-8" style="padding: 20px; margin-left: 1rem; margin-right: 1rem;">
                    <h2 class="card-title" align="center" style="color: white; margin-bottom: 1.5rem;">Signin Process</h2>
                    <form action="signin.php" method="post" onsubmit="return $.fn.myFunction()">

                        <?php if (count($errors) > 0): ?>
                            <?php foreach ($errors as $error): ?>
                                <p class="alert alert-danger" align="center" style="margin-bottom: 1rem;"><?php echo $error; ?></p>
                            <?php endforeach ?>
                        <?php endif ?>

                        <?php if (count($success) > 0): ?>
                            <?php foreach ($success as $suc): ?>
                                <p class="alert alert-success" align="center" style="margin-bottom: 10px;"><?php echo $suc; ?></p>
                            <?php endforeach ?>
                        <?php endif; ?>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="user_name" placeholder="Enter Username">
                                </div>

                                <div class="form-group">
                                    <textarea placeholder="Enter Present Address" name="address_one" rows="2" spellcheck="false" class="form-control autosize-target text-left"></textarea>
                                </div>

                                <div class="form-group">
                                    <select class="form-control" name="user_previlage">
                                        <option value="NULL" selected hidden>Select Previlage</option>
                                        <option value="company">For Company</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <input type="password" class="form-control" name="new_password" placeholder="Enter Password">
                                </div>

                            </div>


                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="user_email" placeholder="Enter Email Address">
                                </div>

                                <div class="form-group">
                                    <textarea placeholder="Enter Permanent Address" name="address_two" rows="2" spellcheck="false" class="form-control autosize-target text-left"></textarea>
                                </div>

                                <div class="form-group">
                                    <input type="text" class="form-control" name="user_phone_number" placeholder="Phone Number" minlength="11" maxlength="11">
                                </div>

                                <div class="form-group">
                                    <input type="password" class="form-control" name="confirm_password" placeholder="Confirm Password">
                                </div>
                            </div>
                        </div>
                        <div style="text-align: center;">
                            <input type="submit" class="btn btn-success" name="submit" value="SIGN IN">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body" style="height: 15rem">
                <div id="circle">
                    <div class="loader-pro">
                        <div class="loader-plus">
                            <div class="loader-noob">
                                <div class="loader-pop"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-md-center" style="margin-top: 1rem">
                    <h4>Processing</h4>
                </div>
                <div class="row justify-content-md-center">
                    <small>Please Wait...</small>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $.fn.myFunction = function() {
            $("#myModal").modal({
                backdrop: "static", //remove ability to close modal with click
                keyboard: false, //remove option to close with keyboard
                show: true //Display loader!
            });
            setTimeout(function() {
                $("#myModal").modal("hide");
                $('.modal-backdrop').remove();
            }, 15500);
            return true;
        }
    });
</script>