<?php

//load_data.php
include 'database_connection.php';
$total = 20;

$output = '';
if(isset($_POST["cave"])):
    if($_POST["cave"] != ''):
        $sql = "SELECT * FROM `rows` WHERE  cave_id='".$_POST["cave"]."'";
    else:
        $sql = "SELECT * FROM `rows`";
    endif;
    $result = mysqli_query($conn, $sql);
    $output .='<h4>Storage Managment</h4>';
    while($row = mysqli_fetch_array($result)):
        $id = $row['id'];
        $s = "SELECT * FROM `packs` WHERE row_id ='$id'";
        $r = mysqli_query($conn,$s);
        $num_rows = mysqli_num_rows($r);
        $empty_rows = $total - $num_rows;
        $percetege = round(($empty_rows / $total) * 100, 1);
        $net = 100 - $percetege;
        $output .= '<p>'.$row["name"].'</p>';
        $output .= '<p>'.$net.'% used already</p>';
        $output .= '<div class="outter">';
        $output .= '<div class="inner" style="width:'.$net.'%"></div>';
        $output .= '</div>';
    endwhile;
    echo $output;
endif;

if(isset($_POST["row"])):
    if($_POST["row"] != ''):
        $sql = "SELECT * FROM `rows` WHERE  id='".$_POST["row"]."'";
    else:
        $sql = "SELECT * FROM `rows`";
    endif;
    $result = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_array($result)):
        $cave_id = $row['cave_id'];
        $id = $row['id'];
        $type = $row['cave_type'];
        $name = $row['name'];
        $s = "SELECT * FROM `packs` WHERE row_id ='$id'";
        $r = mysqli_query($conn,$s);
        $num_rows = mysqli_num_rows($r);
        $empty_rows = $total - $num_rows;
        $percetege = round(($empty_rows / $total) * 100, 1);
        $net = 100 - $percetege;

        $sql_name = "SELECT cave_name FROM cave WHERE id='$cave_id'";
        $usernameQuery = mysqli_query($conn, $sql_name);
        $b_row = mysqli_fetch_assoc($usernameQuery);
        $cave_name = $b_row['cave_name'];


        echo    "   <div>
                        <h4>Row Description</h4>
                        <p> Row Name: $name </p>
                        <p> Cave Name : $cave_name </p>
                        <p> Row ID: $id </p>
                        <p> Row Type: $type </p>
                        <p>$net% already used spece</p>
                        <div class='outter'>
                            <div class='inner' style='width: $net%'></div>
                        </div>
                    </div>";
    endwhile;
    echo $output;
endif;


if (isset($_POST['delete'])){
    $id = $_POST['delete'];
    mysqli_query($conn, "DELETE FROM customer_request WHERE pack_id='$id'");

}
?>