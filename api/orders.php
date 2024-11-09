<?php
// api/orders.php
require('connect.inp'); // Kết nối cơ sở dữ liệu

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    
    // Kiểm tra dữ liệu đầu vào
    if (isset($data['amount']) && isset($data['user_id']) && isset($data['room_id']) && isset($data['check_in']) && isset($data['check_out'])) {
        
        // Kiểm tra định dạng ngày
        $check_in = DateTime::createFromFormat('Y-m-d', $data['check_in']);
        $check_out = DateTime::createFromFormat('Y-m-d', $data['check_out']);
        
        if ($check_in && $check_out && $check_in < $check_out) {
            // Tạo đơn hàng trong bảng booking_order
            $stmt = $con->prepare("INSERT INTO booking_order (user_id, room_id, check_in, check_out, booking_status, order_id) VALUES (?, ?, ?, ?, 'Pending', ?)");
            $order_id = uniqid('ORD_'); // Tạo ID đơn hàng
            $stmt->bind_param("iisss", $data['user_id'], $data['room_id'], $data['check_in'], $data['check_out'], $order_id);
            
            if ($stmt->execute()) {
                // Trả về ID đơn hàng
                $booking_id = $con->insert_id; // Lấy ID của booking vừa tạo
                
                // Tiến hành chèn dữ liệu vào bảng payment_details
                $payment_stmt = $con->prepare("INSERT INTO payment_details (booking_id, amount, payment_date, payment_status, payment_method, trans_id) VALUES (?, ?, NOW(), 'Completed', 'PayPal', ?)");
                $trans_id = uniqid('TXN_'); // Tạo ID giao dịch
                $payment_stmt->bind_param("ids", $booking_id, $data['amount'], $trans_id);
                
                if ($payment_stmt->execute()) {
                    // Trả về ID đơn hàng và ID giao dịch
                    echo json_encode(['id' => $order_id, 'transaction_id' => $trans_id]);
                } else {
                    // Trả về lỗi nếu không thể chèn vào payment_details
                    http_response_code(500);
                    echo json_encode(['error' => 'Failed to record payment details.']);
                }
            } else {
                // Trả về lỗi nếu không thể thực hiện truy vấn
                http_response_code(500);
                echo json_encode(['error' => 'Failed to create order.']);
            }
        } else {
            // Trả về lỗi nếu ngày không hợp lệ
            http_response_code(400);
            echo json_encode(['error' => 'Invalid check-in or check-out date.']);
        }
    } else {
        // Trả về lỗi nếu dữ liệu không đầy đủ
        http_response_code(400);
        echo json_encode(['error' => 'Missing required fields.']);
    }
    exit;
}
?>