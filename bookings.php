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


// Truy vấn để lấy thông tin từ bảng booking_order và rooms
$query = "SELECT bo.*, r.room_name, r.price 
          FROM booking_order AS bo 
          INNER JOIN rooms AS r ON bo.room_id = r.room_id
          WHERE bo.booking_status IN ('Confirmed', 'Pending', 'Cancelled')
          ORDER BY bo.booking_id DESC";

$result = $con->query($query);

if ($result->num_rows > 0) {
    while ($data = $result->fetch_assoc()) {
        $date = date("d-m-Y", strtotime($data['check_in'])); // Ngày check-in để hiển thị
        $checkin = date("d-m-Y", strtotime($data['check_in']));
        $checkout = date("d-m-Y", strtotime($data['check_out']));

        // Xác định màu nền và trạng thái hiển thị
        $status_bg = "";
        $status_text = "";
        if ($data['booking_status'] == 'Confirmed') {
            $status_bg = "bg-success";
            $status_text = "booked";
        } else if ($data['booking_status'] == 'Cancelled') {
            $status_bg = "bg-danger";
            $status_text = "cancelled";
        } else {
            $status_bg = "bg-warning";
            $status_text = "pending";
        }

        echo <<<bookings
        <div class='col-md-4 px-4 mb-4'>
            <div class='bg-white p-3 rounded shadow-sm'>
                <h5 class='fw-bold'>{$data['room_name']}</h5>
                <p>₹{$data['price']} per night</p>
                <p>
                    <b>Check in:</b> $checkin <br>
                    <b>Check out:</b> $checkout
                </p>
                <p>
                    <b>Amount:</b> ₹{$data['price']} <br>
                    <b>Order ID:</b> {$data['order_id']} <br>
                    <b>Date:</b> $date
                </p>
                <p>
                    <span class='badge $status_bg'>$status_text</span>
                </p>
                <button class='btn btn-outline-dark btn-sm'>Download PDF</button>
bookings;


        // Hiển thị nút "Refund in Process" nếu trạng thái là "cancelled"
        if ($status_text == "cancelled") {
            echo "<button class='btn btn-outline-primary btn-sm mt-2'>Refund in Process</button>";
        }

        echo "</div></div>";
    }
} else {
    echo "<p>Không có dữ liệu đặt phòng.</p>";
}

// Đóng kết nối
$con->close();
        ?>
            <?php require('inc/footer.php'); ?>
    
 </div>
</body>
</html>