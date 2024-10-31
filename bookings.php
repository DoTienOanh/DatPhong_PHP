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
            <a href="index.php" class="text-secondary text-decoration-none">HOME</a>
             <span class="text-secondary">></span>
             <a href="#" class="text-secondary text-decoration-none">BOOKINGS</a>
        </div>
    </div>

    <?php
include("connect.inp");

// Truy vấn lấy dữ liệu từ cơ sở dữ liệu với câu lệnh chuẩn
$query = "SELECT bc.*, bo.* FROM booking_confirmation AS bc 
          INNER JOIN booking_order AS bo ON bc.booking_id = bo.booking_id 
          WHERE (
              bo.booking_status='Confirmed'
              OR bo.booking_status='Pending'
              OR bo.booking_status='Cancelled'
          ) AND bo.user_id=?
          ORDER BY bo.booking_id DESC";

$stmt = $con->prepare($query);

// Kiểm tra nếu truy vấn chuẩn bị thành công
if ($stmt) {
    // Liên kết tham số user_id với kiểu số nguyên (i)
    $stmt->bind_param('i', $_SESSION['uId']);
    $stmt->execute();

    // Lấy kết quả
    $result = $stmt->get_result();
    
    while ($data = $result->fetch_assoc()) {
        $date = date("d-m-Y", strtotime($data['datentime']));
        $checkin = date("d-m-Y", strtotime($data['check_in']));
        $checkout = date("d-m-Y", strtotime($data['check_out']));

        $status_bg = "";
        if ($data['booking_status'] == 'Confirmed') {
            $status_bg = "bg-success";
        } else if ($data['booking_status'] == 'Cancelled') {
            $status_bg = "bg-danger";
        } else {
            $status_bg = "bg-warning";
        }

        echo <<<bookings
        <div class='col-md-4 px-4 mb-4'>
            <div class='bg-white p-3 rounded shadow-sm'>
                <h5 class='fw-bold'>{$data['room_name']}</h5>
                <p>{$data['price']} per night</p>
                <p>
                    <b>Check in:</b> $checkin <br>
                    <b>Check out:</b> $checkout
                </p>
                <p>
                    <b>Amount:</b> {$data['price']} <br>
                    <b>Order ID: </b> {$data['order_id']}
                    <b>Date: </b> $date
                </p>
                <p>
                    <span class='badge $status_bg'>{$data['booking_status']}</span>
                </p>
            </div>
        </div>
        bookings;
    }

    $stmt->close();
    } else {
    echo "Lỗi truy vấn: " . $con->error;
    }

        ?>
            <?php require('inc/footer.php'); ?>
    
 </div>
</body>
</html>