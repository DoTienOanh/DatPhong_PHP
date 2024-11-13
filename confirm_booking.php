<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require('inc/links.php'); ?>
    <title>CONFIRM BOOKING</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body class="bg-light">
    <?php require('inc/header.php');?>
    <?php require('connect.inp');?>
    <?php
      function filteration($data) {
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $data[$key] = htmlspecialchars(strip_tags(trim($value)));
            }
        } else {
            $data = htmlspecialchars(strip_tags(trim($data)));
        }
        return $data;
    }

    function redirect($url) {
        header("Location: $url");
        exit();
    }
    if(!isset($_GET['id'])){
        redirect('rooms.php'); 
    }


    $room_id = filteration($_GET['id']);
    include("connect.inp");

    $stmt = $con->prepare("SELECT * FROM rooms WHERE room_id = ?");
    $stmt->bind_param("i", $room_id);
    $stmt->execute();
    $room_res = $stmt->get_result();

    if ($room_res->num_rows == 0) {
        header('Location: rooms.php');
        exit;
    }

    $room_data = $room_res->fetch_assoc();
    $room_price = $room_data['price'];
    ?>

    <div class="container">
     <div class="row">
        <div class="col-12 my-5 mb-4 px-4">
            <h2 class="fw-bold"> CONFIRM BOOKING</h2>
        </div>
        <div class="col-lg-7 col-md-12 px-4">
            <div id="roomCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <img src="images/<?php echo $room_data['image_url']; ?>" class="card-img-top">
                </div>    
            </div>
            <h5><?php echo $room_data['room_name']; ?></h5>
            <h6 class="mb-4" id="price"><?php echo $room_data['price']; ?></h6>
        </div>
        <div class="col-lg-5 col-md-12 px-4">
            <div class="card mb-4 border-0 shadow-sm rounded-3">
                <div class="card-body">
                    <form action="#" method="POST" id="booking_form">
                        <h6 class="mb-3">BOOKING DETAILS</h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Name</label>
                                <input name="name" type="text" class="form-control shadow-none" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">PhoneNumber</label>
                                <input name="phonenum" type="number" class="form-control shadow-none" required>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label">Address</label>
                                <input name="address" type="text" class="form-control shadow-none" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Check-in</label>
                                <input name="checkin" type="date" class="form-control shadow-none" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label mb-1">Check-out</label>
                                <input name="checkout" type="date" class="form-control shadow-none" required>
                            </div>

                            <div class="col-12">
                                <div class="spinner-border text-info mb-3 d-none" id="info_loader" role="status">
                                    <span class="visually-hidden">Loading.....</span>
                                </div>
                            </div>

                            <div class="col-12">
                                <h6 class="mb-3 text-danger" id="pay_info">Vui lòng nhập ngày checkin và checkout!</h6>
                                <div class="pay_now" id="pay_now">
                                    <script src="https://www.paypal.com/sdk/js?client-id=AcRFoe-qt7M7cdr5naUgz1mUGNZkjehzrqzTLh0tYsK-syVpAVkI3lLRkhHC-xhtU0ZpgXMdC68J0m6A&buyer-country=US&currency=USD&components=buttons&enable-funding=card&disable-funding=venmo,paylater"
                                        data-sdk-integration-source="developer-studio"></script>
                                    <script src="app.js"></script>
                                </div>
                            </div>
                        </div> 
                    </form>
                </div>
            </div>
        </div>
    </div>


    <?php
// Kết nối cơ sở dữ liệu và kiểm tra phòng
$room_id = filteration($_GET['id']);
include("connect.inp");
$booked_dates = [];
$stmt = $con->prepare("SELECT check_in, check_out FROM booking_order WHERE room_id = ?");
$stmt->bind_param("i", $room_id);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $booked_dates[] = ['checkin' => $row['check_in'], 'checkout' => $row['check_out']];
}
$stmt->close();
?>
<script>
    const bookedDates = <?php echo json_encode($booked_dates); ?>;
</script>

<script>
// Lấy giá phòng từ PHP
const roomPrice = <?php echo json_encode($room_data['price']); ?>;

// Hàm tính số ngày giữa hai ngày
function date_diff(startDate, endDate) {
    const diffTime = Math.abs(endDate - startDate); // Tính thời gian chênh lệch
    return Math.ceil(diffTime / (1000 * 60 * 60 * 24)); // Chuyển đổi từ milliseconds sang days
}

let payment_usd = 0;
// Hàm xác thực ngày nhận phòng và trả phòng
function validateDates() {
let checkin = booking_form.elements['checkin'].value;
let checkout = booking_form.elements['checkout'].value;

if (!checkin || !checkout) {
    pay_info.textContent = "Vui lòng nhập ngày checkin và checkout!"; // Hiển thị thông báo nếu không chọn đủ ngày
    booking_form.elements['pay_now'].setAttribute('disabled', true); // Vô hiệu hóa nút thanh toán
    return false; // Kết thúc hàm
}

// Chuyển đổi ngày thành định dạng Date để dễ so sánh
let checkinDate = new Date(checkin);
let checkoutDate = new Date(checkout);
let today = new Date();

// Đặt thời gian của ngày hiện tại về 0 giờ để so sánh dễ hơn
today.setHours(0, 0, 0, 0);

// Kiểm tra nếu ngày check-in là quá khứ
if (checkinDate < today) {
    pay_info.textContent = "Ngày check-in không thể là ngày trong quá khứ!";
    booking_form.elements['pay_now'].setAttribute('disabled', true);
    return false;
}

// Kiểm tra nếu ngày check-out trước ngày check-in
if (checkoutDate <= checkinDate) {
    pay_info.textContent = "Ngày check-out không thể nhỏ hơn ngày check-in!";
    booking_form.elements['pay_now'].setAttribute('disabled', true);
    return false;
}

for (let booking of bookedDates) {
        let bookedCheckin = new Date(booking.checkin);
        let bookedCheckout = new Date(booking.checkout);

        if ((checkinDate < bookedCheckout) && (checkoutDate > bookedCheckin)) {
            pay_info.textContent = "Ngày bạn chọn trùng với một khoảng thời gian đã đặt!";
            return false;
        }
    }

// Nếu cả hai ngày hợp lệ, tính số ngày và tổng tiền
let count_days = date_diff(checkinDate, checkoutDate);
let price = parseFloat(document.getElementById('price').textContent); // Lấy giá phòng từ phần tử HTML
let payment_vnd = roomPrice * count_days;
const usd = 23000;
// Cập nhật giá trị payment_usd
payment_usd = (payment_vnd / usd).toFixed(2);;

// Hiển thị thông tin thanh toán
pay_info.innerHTML = "Total days: " + count_days + "<br>Total payment: " + payment_vnd.toFixed(2) + "VND = " +payment_usd + "$";

document.getElementById('pay_now').setAttribute('data-payment-usd', payment_usd);
        
// Bật nút thanh toán
booking_form.elements['pay_now'].removeAttribute('disabled');

return true;
}

// Gắn sự kiện onchange vào các input ngày
booking_form.elements['checkin'].addEventListener('change', validateDates);
booking_form.elements['checkout'].addEventListener('change', validateDates);
</script>

<?php require('inc/footer.php'); ?>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
