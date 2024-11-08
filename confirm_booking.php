<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require('inc/links.php'); ?>
    <title>CONFIRM BOOKING</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<style>
    .btn-pay-now {
  width: 100%;            
  background-color: #2ec1ac; 
  color: #ffffff;         
  padding: 10px;          
  font-size: 16px;        
  font-weight: bold;      
  border: none;           
  cursor: pointer;        
  border-radius: 5px;     
}
.btn-pay-now:hover {
  background-color: #279e8c; 
}
</style>
</head>
<body class="bg-light">
    <?php require('inc/header.php');?>
    <?php require('connect.inp');?>

    <?php
        // if(!isset($_GET['uId'])){
        //     redirect('rooms.php');
        // }

        // $data = filteration($_GET);

        // $room_res = select("SELECT * from 'rooms' Where 'room_id'=? AND 'status' =?",[$data['uId'],1,0],'iii');
        // if(mysqli_num_rows($room_res)==0){
        //     redirect('rooms.php');
        // }
        // $room_data = mysqli_fetch_assoc($room_res);
        //if(!isset($_GET['uId'])){
          //  header('Location: index.php');
            //exit;
        //}
    //tính từ code này nhé
        // Lấy thông tin phòng từ cơ sở dữ liệu
       // $uId = $_GET['uId'];
        $sql = "SELECT room_name, price FROM rooms WHERE room_id =  1 AND availability = 1";
       // $stmt = $conn->prepare($sql);
        //$stmt->bind_param("i", $uId);
        //$stmt->execute();
        //$result = $stmt->get_result();
        $result=$con->query($sql);

        if($result->num_rows == 0){
            header('Location: index.php');
            exit;
        }

        $room_data = $result->fetch_assoc();
    ?>
    
    <div class="container">
     <div class="row">

        <div class="col-12 my-5 mb-4 px-4">
            <h2 class="fw-bold"> CONFIRM BOOKING</h2>
        </div>
        <div class="col-lg-7 col-md-12 px-4">
            <div id="roomCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <img src="images/nature-2.jpg" class="card-img-top">
                </div>    
            </div>
            <h5><?php echo$room_data['room_name'];?></h5>
            <h6 class="mb-4" id="price"><?php echo $room_data['price'];?></h6>
        </div>
        <div class="col-lg-5 col-md-12 px-4">
            <div class="card mb-4 border-0 shadow-sm rounded-3">
                <div class="card-body">
                    <form action="#" method="POST" id="booking_form">
                        <h6 class="mb-3">BOOKING DETAILS</h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label ">Name</label>
                                <input name="name" type="text" class="form-control shadow-none" required>  
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label ">PhoneNumber</label>
                                <input name="phonenum" type="number" class="form-control shadow-none" required>  
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label ">Address</label>
                                <input name="address" type="text" class="form-control shadow-none" required>  
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label ">Check-in</label>
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
                            <h6 class="mb-3 text-danger" id="pay_info">Provide check-in & check-out date!</h6>
                            <button name="pay_now" class="btn-pay-now " disabled>Pay Now</button>
                            </div>
                        </div> 
                    </form>
            </div>
         </div>
        </div>
    </div>
<script>
    function date_diff(startDate, endDate) {
        // Tính số ngày giữa hai ngày
        const diffTime = Math.abs(endDate - startDate);
        return Math.ceil(diffTime / (1000 * 60 * 60 * 24)); // Chuyển đổi từ milliseconds sang days
    }

    function validateDates() {
    let checkin = booking_form.elements['checkin'].value;
    let checkout = booking_form.elements['checkout'].value;
    
    // Chuyển đổi ngày thành định dạng Date để dễ so sánh
    let checkinDate = new Date(checkin);
    let checkoutDate = new Date(checkout);
    let today = new Date();
    
    // Đặt thời gian của ngày hiện tại về 0 giờ để so sánh dễ hơn
    today.setHours(0, 0, 0, 0);

    // Kiểm tra nếu ngày check-in là quá khứ
    if (checkinDate < today) {
        pay_info.textContent = "Check-in date cannot be in the past!";
        booking_form.elements['pay_now'].setAttribute('disabled', true);
        return false;
    }
    
    // Kiểm tra nếu ngày check-out trước ngày check-in
    if (checkoutDate <= checkinDate) {
        pay_info.textContent = "Check-out date must be after check-in date!";
        booking_form.elements['pay_now'].setAttribute('disabled', true);
        return false;
    }
    
    // Nếu ngày hợp lệ, bật nút và ẩn thông báo lỗi
    //pay_info.textContent = "";
    //booking_form.elements['pay_now'].removeAttribute('disabled');
    //return true;

    // Tính số ngày
    if (checkin && checkout) {
            // Tính số ngày
            let count_days = date_diff(checkinDate, checkoutDate);
            let price = parseFloat(document.getElementById('price').textContent); // Lấy giá phòng từ phần tử HTML
            let payment = price * count_days;

            // Hiển thị thông tin thanh toán
            pay_info.innerHTML = "Total days: " + count_days + "<br>Total payment: $" + payment.toFixed(2);
            
            // Bật nút thanh toán
            booking_form.elements['pay_now'].removeAttribute('disabled');
        } else {
            // Nếu chưa chọn đủ ngày, ẩn thông tin thanh toán
            pay_info.textContent = "Provide check-in & check-out date!";
            booking_form.elements['pay_now'].setAttribute('disabled', true);
        }

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
        