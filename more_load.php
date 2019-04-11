<?php

//load_data.php
include 'database_connection.php';

if(isset($_POST["name"])):
    if($_POST["name"] != ''):
        $sql = "SELECT * FROM packs WHERE company_id = '".$_POST["name"]."'";
    else:
        $sql = "SELECT * FROM packs";
    endif;
    $result = mysqli_query($conn, $sql);

    echo "<div class='card' id='table' style='margin-top:10px; padding-left: 13px; padding-right: 13px;'>
        <div class='card-body' style=' padding: 0px !important;'>
            <h4 class='card-title' style='margin-bottom: 0 !important; margin-top: 10px;'>Requested packages</h4>
        </div>
        <table class='table table-striped table-dark' id='mytable' style='margin-top: 15px; text-align: center'>
            <thead>
            <tr>
                <th style='width: 150px' scope='col'>PACK ID</th>
                <th style='width: 150px' scope='col'>PACK NAME</th>
                <th style='width: 450px' scope='col'>PACK DESCRIPTION</th>
                <th style='width: 150px' scope='col'>PACK TYPE</th>
            </tr>
            </thead>
            <tbody>";

    while($rows = mysqli_fetch_assoc($result)):

        $id = $rows['pack_code'];
        $name =$rows['name'];
        $des = $rows['short_details'];
        $type = $rows['item_type'];

       echo "<tr>
                    <td style='width: 150px' class='nr'>$id</td>                  
                    <td style='width: 150px'>$name</td>
                    <td style='width: 450px'>$des</td>
                    <td style='width: 150px'>$type</td>
                    <td>
                        <button type='button' id='$id' data-toggle='modal' data-target='.bd-example-modal-lg'
                        class='btn btn-primary btn-sm view_data'>MORE <i class='fas fa-chevron-circle-down'></i></button>
                    </td>
                </tr>";
    endwhile; echo "
                
         </tbody>
        </table>
    </div>
    </div>
    </div>
    <br>
    <br>
    
    ";
include 'm-footer.php';
endif;

if(isset($_POST["pack"])):

    $sql = "SELECT * FROM packs WHERE pack_code= '".$_POST["pack"]."'";

    $result = mysqli_fetch_assoc(mysqli_query($conn, $sql));
    $c_id = $result['cave_id'];
    $r_id = $result['row_id'];

    $r_s = mysqli_fetch_assoc(mysqli_query($conn, "SELECT serial FROM `rows` WHERE id='$r_id'"));
    $rNo = $r_s['serial'];


    $fontColor1 = "000";
    $bgColor1 = "fff";
    $fontColor2 = "000";
    $bgColor2 = "fff";
    $fontColor3 = "000";
    $bgColor3 = "fff";
    $fontColor4 = "000";
    $bgColor4 = "fff";
    $fontColor5 = "000";
    $bgColor5 = "fff";

    $rowBgColor1 = "fff";
    $rowTesxtColor1 = "000";
    $rowBgColor2 = "fff";
    $rowTesxtColor2 = "000";
    $rowBgColor3 = "fff";
    $rowTesxtColor3 = "000";
    $rowBgColor4 = "fff";
    $rowTesxtColor4 = "000";
    $rowBgColor5 = "fff";
    $rowTesxtColor5 = "000";

        if ($c_id == 1) {
            $fontColor1 = "fff";
            $bgColor1 = "00bcd4";
        } elseif ($c_id == 2) {
            $fontColor2 = "fff";
            $bgColor2 = "00bcd4";
        } elseif ($c_id == 3) {
            $fontColor3 = "fff";
            $bgColor3 = "00bcd4";
        } elseif ($c_id == 4) {
            $fontColor4 = "fff";
            $bgColor4 = "00bcd4";
        } elseif ($c_id == 5) {
            $fontColor5 = "fff";
            $bgColor5 = "00bcd4";
        } else {
            $fontcolor = "000";
            $bgColor = "fff";
        }

        if ($rNo == 1) {
            $rowBgColor1 = "00bcd4";
            $rowTesxtColor1 = "fff";
        } elseif ($rNo == 2) {
            $rowBgColor2 = "00bcd4";
            $rowTesxtColor2 = "fff";
        } elseif ($rNo == 3) {
            $rowBgColor3 = "00bcd4";
            $rowTesxtColor3 = "fff";
        } elseif ($rNo == 4) {
            $rowBgColor4 = "00bcd4";
            $rowTesxtColor4 = "fff";
        } elseif ($rNo == 5) {
            $rowBgColor5 = "00bcd4";
            $rowTesxtColor5 = "fff";
        } else {
            $rowBgColor = "fff";
            $rowTesxtColor = "000";
        }


        echo "
        <div class='row'>
            <div class='col-md-6'>
                <div class='row'>
                    <div class='col-md-2'>
                        <div class='div vr' style='background-color: #$bgColor1; color: #$fontColor1;'>
                            <h3>CAVE 1</h3>
                        </div>
                    </div>
                    <div class='col-md-2'>
                        <div class='div vr' style='background-color: #$bgColor2; color: #$fontColor2;'>
                            <h3>CAVE 1</h3>
                        </div>
                    </div>
                    <div class='col-md-2'>
                        <div class='div vr' style='background-color: #$bgColor3; color: #$fontColor3;'>
                            <h3>CAVE 3</h3>
                        </div>
                    </div>
                    <div class='col-md-2'>
                        <div class='div vr' style='background-color:#$bgColor4; color: #$fontColor4;'>
                            <h3>CAVE 4</h3>
                        </div>
                    </div>
                    <div class='col-md-2'>
                        <div class='div vr' style='background-color: #$bgColor5; color: #$fontColor5;'>
                            <h3>CAVE 5</h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class='col-md-6' style='text-align: center'>
                <div class='ar' style='background-color: #$rowBgColor1; color: #$rowTesxtColor1;'>
                    <h2 class='bm'>ROW 1</h2>
                </div>
                <div class='ar' style='background-color: #$rowBgColor2; color: #$rowTesxtColor2;'>
                    <h2 class='bm'>ROW 2</h2>
                </div>
                <div class='ar' style='background-color: #$rowBgColor3; color: #$rowTesxtColor3;'>
                    <h2 class='bm'>ROW 3</h2>
                </div>
                <div class='ar' style='background-color: #$rowBgColor4; color: #$rowTesxtColor4;'>
                    <h2 class='bm'>ROW 4</h2>
                </div>
                <div class='ar' style='background-color: #$rowBgColor5; color: #$rowTesxtColor5;'>
                    <h2 class='bm'>ROW 5</h2>
                </div>
            </div>
        </div>
        ";


endif;
?>