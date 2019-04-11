<?php
session_start();
$email = $_SESSION['email'];

include 'home_header.php';
include 'database_connection.php';

$row = mysqli_fetch_assoc(mysqli_query($conn,"SELECT id FROM users WHERE user_email='$email'"));
$id = $row['id'];
?>

<div>
    <div class="container">
        <?php
        //total stored
            $sql =mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM payment WHERE user_mail='$email'"));
            $com = $sql['user_name'];
            $p_name = $sql['packege_name'];
            $p_limit = $sql['pack_limit'];
            $i_limit = $sql['item_limit'];
            $money = $sql['amount'];
            $expire_date = $sql['exp_date'];

            if (empty($com)):
            ?>
                <div class="card" style="margin-top: 6rem; padding: 1rem">

                    <h1>No offers taken yet</h1>
                </div>
                <?php else: ?>
                <div class="card" style="margin-top: 6rem; padding: 1rem">
                    <div class="row justify-content-md-center">
                        <h3 class="card-title">Package Details</h3>
                    </div><hr>
                    <div class="row justify-content-md-center">
                        <h1 style=" margin-bottom: 1rem; color: #00cc99;"><i class="fas fa-star-of-life"></i> <?php echo $p_name; ?> <i class="fas fa-star-of-life"></i></h1>
                    </div>
                    <div class="row justify-content-md-center">
                        <h5><b>Expire Date : &nbsp;&nbsp;<?php echo $expire_date; ?></b></h5>
                    </div>
                    <div class="row justify-content-md-center">
                        <h6>Item Limit : &nbsp;&nbsp;<?php echo $i_limit; ?> Pieces</h6>
                    </div>
                    <div class="row justify-content-md-center">
                        <h6>Pack Limit : &nbsp;&nbsp;<?php echo $p_limit; ?> Pieces</h6>
                    </div>
                    <div class="row justify-content-md-center">
                        <h6>Pack Price : &nbsp;&nbsp;$<?php echo $money; ?> </h6>
                    </div>
                </div>
        <?php endif; ?>
        <section class="pricing py-5">
            <div class="container-fluid">
                <div class="row">
                    <!-- Primary Tier -->
                    <div class="col-lg-3">
                        <div class="card mb-5 mb-lg-0 h-100">
                            <div class="card-body">
                                <h5 class="card-title text-muted text-uppercase text-center">Primary Offers</h5>
                                <h6 class="card-price text-center">$29.99<span class="period">/month</span></h6>
                                <hr>
                                <ul class="fa-ul">
                                    <li><span class="fa-li"><i class="fas fa-check"></i></span>5 Pack Limit</li>
                                    <li><span class="fa-li"><i class="fas fa-check"></i></span>2000 Item Limit</li>
                                    <li><span class="fa-li"><i class="fas fa-check"></i></span>Community Access</li>
                                    <li><span class="fa-li"><i class="fas fa-check"></i></span>10% Off in Transport And Shipment</li>
                                    <li><span class="fa-li"><i class="fas fa-check"></i></span>Monthly Status Reports</li>
                                    <li><span class="fa-li"><i class="fas fa-check"></i></span>Shared Phone Support</li>
                                    <li><span class="fa-li"><i class="fas fa-check"></i></span>Free Bonus Point Every 6 Month</li>
                                </ul>
                            </div>
                            <div class="card-footer">
                                <a href="payment.php?option=1&id=<?php echo $id; ?>" class="btn btn-block btn-primary text-uppercase" >TRY This</a>
                            </div>
                        </div>
                    </div>
                    <!-- Plus Tier -->
                    <div class="col-lg-3">
                        <div class="card mb-5 mb-lg-0 h-100">
                            <div class="card-body">
                                <h5 class="card-title text-muted text-uppercase text-center">Standared Offers</h5>
                                <h6 class="card-price text-center">$109.99<span class="period">/month</span></h6>
                                <hr>
                                <ul class="fa-ul">
                                    <li><span class="fa-li"><i class="fas fa-check"></i></span>15 Pack Limit</li>
                                    <li><span class="fa-li"><i class="fas fa-check"></i></span>7000 Item Limit</li>
                                    <li><span class="fa-li"><i class="fas fa-check"></i></span>Community Access</li>
                                    <li><span class="fa-li"><i class="fas fa-check"></i></span>20% Off in Transport And Shipment</li>
                                    <li><span class="fa-li"><i class="fas fa-check"></i></span>Monthly Status Reports</li>
                                    <li><span class="fa-li"><i class="fas fa-check"></i></span>Shared Phone Support</li>
                                    <li><span class="fa-li"><i class="fas fa-check"></i></span>Free Bonus Point Every Month</li>
                                </ul>
                            </div>
                            <div class="card-footer">
                                <a href="payment.php?option=2&id=<?php echo $id; ?>" class="btn btn-block btn-primary text-uppercase" >TRY This</a>
                            </div>
                        </div>
                    </div>
                    <!-- Plus Tier -->
                    <div class="col-lg-3">
                        <div class="card mb-5 mb-lg-0">
                            <div class="card-body">
                                <h5 class="card-title text-muted text-uppercase text-center">Plus Offers</h5>
                                <h6 class="card-price text-center">$299.99<span class="period">/month</span></h6>
                                <hr>
                                <ul class="fa-ul">
                                    <li><span class="fa-li"><i class="fas fa-check"></i></span>25 Pack Limit</li>
                                    <li><span class="fa-li"><i class="fas fa-check"></i></span>15000 Item Limit</li>
                                    <li><span class="fa-li"><i class="fas fa-check"></i></span>Community Access</li>
                                    <li><span class="fa-li"><i class="fas fa-check"></i></span>Free Transport And Shipment</li>
                                    <li><span class="fa-li"><i class="fas fa-check"></i></span>Monthly Status Reports</li>
                                    <li><span class="fa-li"><i class="fas fa-check"></i></span>Dedicated Phone Support</li>
                                    <li><span class="fa-li"><i class="fas fa-check"></i></span>Free Bonus Point Every Week</li>
                                </ul>
                            </div>
                            <div class="card-footer">
                                <a href="payment.php?option=3&id=<?php echo $id; ?>" class="btn btn-block btn-primary text-uppercase" >TRY This</a>
                            </div>
                        </div>
                    </div>
                    <!-- Pro Tier -->
                    <div class="col-lg-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title text-muted text-uppercase text-center">Pro Offers</h5>
                                <h6 class="card-price text-center">$499.99<span class="period">/month</span></h6>
                                <hr>
                                <ul class="fa-ul">
                                    <li><span class="fa-li"><i class="fas fa-check"></i></span>50 Pack Limit</li>
                                    <li><span class="fa-li"><i class="fas fa-check"></i></span>25000 Item Limit</li>
                                    <li><span class="fa-li"><i class="fas fa-check"></i></span>Community Access</li>
                                    <li><span class="fa-li"><i class="fas fa-check"></i></span>Free Transport And Shipment</li>
                                    <li><span class="fa-li"><i class="fas fa-check"></i></span>Monthly Status Reports</li>
                                    <li><span class="fa-li"><i class="fas fa-check"></i></span>Dedicated Phone Support</li>
                                    <li><span class="fa-li"><i class="fas fa-check"></i></span>Free Bonus Point Every Day</li>
                                </ul>
                            </div>
                            <div class="card-footer">
                                <a href="payment.php?option=4&id=<?php echo $id; ?>" class="btn btn-block btn-primary text-uppercase" >TRY This</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

<?php
include 'user_footer.php';
?>
