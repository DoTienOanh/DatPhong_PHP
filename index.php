<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel</title>
    <?php
    require('inc/links.php');
    ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
   <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <style>
      .availability-form{
        margin-top:-50px;
        z-index: 11;
        position: relative;
        }
      @media screen and (max-width: 575px){
        .availability-form{
        margin-top:25px;
       padding: 0 35px;
        }
      }


    </style>
</head>
<body class="bg-light">
  <!-- Header -->
<?php
require('inc/header.php');
?>

<?php
// Bắt đầu phiên làm việc
session_start();

// Kết nối cơ sở dữ liệu
include("connect.inp");

// Xử lý khi người dùng gửi form
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Lấy dữ liệu từ form
    $check_in = $_POST['check_in'];
    $check_out = $_POST['check_out'];
    $room_id = $_POST['room_id']; // Lấy ID phòng từ form

     // Chuyển đổi định dạng từ 'dd/mm/yyyy' sang 'yyyy/mm/dd'
     $check_in_date = DateTime::createFromFormat('d/m/Y', $check_in);
     $check_out_date = DateTime::createFromFormat('d/m/Y', $check_out);

    // Kiểm tra xem phòng có còn trống không
    $query = "SELECT * FROM booking_order 
              WHERE room_id = '$room_id' 
              AND (
                  (check_in <= '$check_out_date' AND check_out >= '$check_in_date') 
                  AND booking_status != 'Cancelled'
              )";

    $result = mysqli_query($con, $query);

      if (mysqli_num_rows($result) > 0) {
        // Phòng không còn trống
        echo "<script>
                document.getElementById('alertModalBody').innerText = 'Phòng đã được đặt trong khoảng thời gian này. Vui lòng chọn thời gian khác.';
                var myModal = new bootstrap.Modal(document.getElementById('alertModal'));
                myModal.show();
              </script>";
    } else {
        // Thực hiện đặt phòng
        $insert_query = "INSERT INTO booking_order (room_id, check_in, check_out, booking_status) 
                        VALUES ('$room_id', '$check_in_date', '$check_out_date', 'Pending')";
        if (mysqli_query($con, $insert_query)) {
            echo "<script>
                    document.getElementById('alertModalBody').innerText = 'Đặt phòng thành công!';
                    var myModal = new bootstrap.Modal(document.getElementById('alertModal'));
                    myModal.show();
                  </script>";
        } else {
            echo "<script>
                    document.getElementById('alertModalBody').innerText = 'Không thể đặt phòng: " . mysqli_error($con) . "';
                    var myModal = new bootstrap.Modal(document.getElementById('alertModal'));
                    myModal.show();
                  </script>";
        }
    }
}

?>



<!-- check availability form -->
<!-- <div class="container">
  <div class="row">
    <div class="col-lg-12 bg-white shadow p-4 rounded">
     <h5 class="mb-4"></h5> 
     <form>
      <div class="row align-items-end">
        <div class="col-lg-3 mb-3">
          <label class="form-label" style="font-weight:500;">Check-in</label>
          <input type="date" class="form-control shadow-none">
        </div>
        <div class="col-lg-3  mb-3">
          <label class="form-label" style="font-weight:500;">Check-out</label>
          <input type="date" class="form-control shadow-none">
        </div>
        <div class="col-lg-3  mb-3">
          <label class="form-label" style="font-weight:500;">Adult</label>
          
            <select class="form-select shadow-none">
             
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
            </select>
          
        </div>
        <div class="col-lg-2  mb-3">
          <label class="form-label" style="font-weight:500;">Children</label>
            
            <select class="form-select shadow-none">
             
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
            </select>
            
        </div>
        <div class="col-lg-1 mb-lg-3 mt-2">
          <button type="submit" class ="btn text-white shadow-none custom-bg">Submit</button>
        </div>

      </div>
     </form>
    </div>
  </div>
</div> -->
<div class="container">
  <div class="row">
    <div class="col-lg-12 bg-white shadow p-4 rounded">
     <h5 class="mb-4"></h5> 
     <form method="POST">
      <div class="row align-items-end">
        <div class="col-lg-3 mb-3">
          <label class="form-label" style="font-weight:500;">Check-in</label>
          <input type="date" name="check_in" class="form-control shadow-none" required>
        </div>
        <div class="col-lg-3 mb-3">
          <label class="form-label" style="font-weight:500;">Check-out</label>
          <input type="date" name="check_out" class="form-control shadow-none" required>
        </div>
        <div class="col-lg-3 mb-3">
          <label class="form-label" style="font-weight:500;">Room</label>
          <select name="room_id" class="form-select shadow-none" required>
            <option value="">Chọn phòng</option>
            <?php
            // Lấy danh sách các phòng có sẵn
            $room_res = mysqli_query($con, "SELECT * FROM rooms WHERE status = 'Available'");
            while ($room_data = mysqli_fetch_assoc($room_res)) {
                echo "<option value='{$room_data['room_id']}'>{$room_data['room_name']}</option>";
            }
            ?>
          </select>
        </div>
        <!-- <div class="col-lg-3 mb-3">
          <label class="form-label" style="font-weight:500;">Adult</label>
          <select class="form-select shadow-none" required>
              <option value="1">One</option>
              <option value="2">Two</option>
              <option value="3">Three</option>
          </select>
        </div>
        <div class="col-lg-2 mb-3">
          <label class="form-label" style="font-weight:500;">Children</label>
          <select class="form-select shadow-none" required>
              <option value="1">One</option>
              <option value="2">Two</option>
              <option value="3">Three</option>
          </select>
        </div> -->
        <div class="col-lg-1 mb-lg-3 mt-2">
          <button type="submit" class="btn text-white shadow-none custom-bg">Submit</button>
        </div>
      </div>
     </form>
    </div>
  </div>
</div>



<!-- Our Rooms -->
 <h2 class="mt-5 pt-4 mb-4 text-center fw-bold h-font">OUR ROOMS</h2>
 <div class="container">
  <div class="row">
  
    

    <?php
        include("connect.inp");
        $room_res = mysqli_query($con,"SELECT * FROM `rooms` WHERE status = 'available'");
        

        while($room_data = mysqli_fetch_assoc($room_res))
        {
           //get facilities of room
           $fac_q = mysqli_query($con,"SELECT f.facility_name FROM `facilities` f
            INNER JOIN room_facilities rfac ON f.facility_id=rfac.facility_id
             WHERE rfac.room_id = '{$room_data['room_id']}'");
           $facilities_data = "";
           while($fac_row = mysqli_fetch_assoc($fac_q)){
            $facilities_data .= "<span class='badge rounded-pill bg-light text-dark text-wrap'>
            $fac_row[facility_name]
            </span>";
           }
           //get images
           
           $room_thumb = $room_data['image_url'] ? $room_data['image_url'] : "default.jpg";
        // print room card 
        echo <<<data
          <div class="col-lg-4 col-md-6 my-3">
            <div class="card border-0 shadow" style="max-width: 350px; margin: auto;">
              <img src="images/$room_thumb" class="card-img-top">
              <div class="card-body">
                <h5>$room_data[room_name]</h5>
                <h6 class="mb-4">$room_data[price]VND</h6>
                <div class="features mb-4">
                  <h6 class="mb-1">Mô tả</h6>
                  $room_data[description]
                </div>
                <div class="facilities mb-4">
                  <h6 class="mb-1">Cơ sở vật chất</h6>
                  $facilities_data
                </div>
                <div class="d-flex justify-content-evenly">
                  <a href="confirm_booking" class="btn btn-sm text-white custom-bg shadow-none">Đặt ngay</a>
                  <a href="room_details.php?id=$room_data[room_id]" class="btn btn-sm btn-outline-dark shadow-none">Chi tiết</a>
                 
                </div>

              
              </div>
            </div>
          </div>
          

        data;

        }
        ?>



      
    <div class="col-lg-12 text-center mt-5">
      <a href="#" class="btn btn-sm btn-outline-dark rounded-0 fw-bold shadow-none">More Rooms</a>
    </div>
  </div>
 </div>

 <!-- Footer -->
 <?php
 require('inc/footer.php');
 ?>

<!-- Modal -->
<div class="modal fade" id="alertModal" tabindex="-1" aria-labelledby="alertModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="alertModalLabel">Thông báo</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="alertModalBody">
        <!-- Nội dung thông báo sẽ được thêm vào đây -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
      </div>
    </div>
  </div>
</div>


<script
src="https://www.paypal.com/sdk/js?client-id=AcRFoe-qt7M7cdr5naUgz1mUGNZkjehzrqzTLh0tYsK-syVpAVkI3lLRkhHC-xhtU0ZpgXMdC68J0m6A&buyer-country=US&currency=USD&components=buttons&enable-funding=card&disable-funding=venmo,paylater"
data-sdk-integration-source="developer-studio"
></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


</body>
</html>