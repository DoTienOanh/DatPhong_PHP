<?php
include("connect.inp");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $booking_id = $_POST['booking_id'];

    // Cập nhật trạng thái booking thành 'Cancelled'
    $update_query = "UPDATE booking_order SET booking_status = 'pending' WHERE booking_id = ?";
    $stmt = $con->prepare($update_query);
    $stmt->bind_param("i", $booking_id);

    if ($stmt->execute()) {
        // Chuyển hướng quay lại trang đặt phòng sau khi hủy thành công
        header("Location: bookings.php");
        exit();
    } else {
        echo "Có lỗi xảy ra. Không thể hủy đặt phòng.";
    }

    $stmt->close();
}

$con->close();
?>
