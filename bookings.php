<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require('inc/links.php'); ?>
    <title><?php echo $settings_r['site_title'] ?> -BOOKINGS</title>
</head>
<body class="bg-light">
    <?php
    require('inc/header.php'); 
    //3p11: login các kiểu
    ?>
 
 <div class="container">
    <div class="row">

    <div class="col-12 my-5 px-4">
        <h2 class="fw-bold">BOOKINGS</h2>
        <div style="font-size:14px;">
            <!-- <a href="index.php" class="text-secondary text-decoration-none">HOME</a> -->
             <!-- <span class="text-secondary">></span> -->
             <a href="#" class="text-secondary text-decoration-none">BOOKINGS</a>
        </div>
    </div>

    <?php
        $query ="SELECT bc.*, bd.* FROM 'booking_confirmation' as bc INNER JOIN 'booking_order' as bo ON bc.booking_if = bd.booking_id WHERE (
        (bo.booking_status='Confirmed')
        OR (bo.booking_status='Pending')
        OR (bo.booking_status='Cancelled')
        )
        AND (bo.user_id=?)
        ORDER BY bo.booking_id DESC";

        $result = select($query,[$_SESSION['uId']],'i');
        while($data= mysqli_fetch_assoc($result)){
            $date = date("d-m-Y, strtotime($data[datentime]");
            $checkin = date("d-m-Y", strtotime($data['check_in']));
            $checkout = date("d-m-Y", strtotime($data['check_out']));

            $status_bg="";
            $btn="";

            if($data['booking_status']=='Confirmed'){
                $status_bg = "bg-success";
            }
            else if($data['booking_status']=='Cancelled'){
                $status_bg = "bg-danger";
            }
            else{
                $status_bg = "bg-warning";             
            }
            
            echo<<<bookings
            <div class='col-md-4 px-4 mb-4'>
                <div class='bg-white p-3 rounded shadow-sm'>
                <h5 class='fw-bold'>$data[room_name]</h5>
                <p>$data[price] per night</p>
                <p>
                    <b>Check in:</b> $checkin <br>
                    <b>Check out:</b> $checkout
                </p>
                <p>
                    <b>Amount:</b> $data[price] <br>
                    <b>Order ID: </b> $data[order_id]
                    <b>Date: </b> $date
                </p>
                <p>
                <span class='badge $status_bg'>$data[booking_status]</span>
                </p>
                </div>
            </div>
            bookings;

        }
        ?>
            <?php require('inc/footer.php'); ?>
    
 </div>
</body>
</html>