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

<!-- <div class="container-fluid px-lg-4 mt-4">
  <div class="swiper swiper-container">
    <div class="swiper-wrapper">
      <div class="swiper-slide">
        <img src="images/nature-1.jpg" class="w-100 d-block">
      </div>
      <div class="swiper-slide">
        <img src="images/nature-2.jpg"class="w-100 d-block">
      </div>
      <div class="swiper-slide">
        <img src="images/nature-3.jpg" class="w-100 d-block">
      </div>
      <div class="swiper-slide">
        <img src="images/nature-4.jpg"class="w-100 d-block">
      </div>
    </div>
  </div>  
</div> -->

<!-- <div class="modal fade" id="loginModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Understood</button>
      </div>
    </div>
  </div>
</div> -->


<!-- check availability form -->
<div class="container">
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
             
              <option value="1">One</option>
              <option value="2">Two</option>
              <option value="3">Three</option>
            </select>
          
        </div>
        <div class="col-lg-2  mb-3">
          <label class="form-label" style="font-weight:500;">Children</label>
            
            <select class="form-select shadow-none">
             
              <option value="1">One</option>
              <option value="2">Two</option>
              <option value="3">Three</option>
            </select>
            
        </div>
        <div class="col-lg-1 mb-lg-3 mt-2">
          <button type="submit" class ="btn text-white shadow-none custom-bg">Submit</button>
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
                  <a href="#" class="btn btn-sm text-white custom-bg shadow-none">Đặt ngay</a>
                  <a href="#" class="btn btn-sm btn-outline-dark shadow-none">Chi tiết</a>
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


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<!-- <script>
  var swiper = new Swiper(".swiper-container", {
    spaceBetween: 30,
    effect: "fade",
    loop:true,
    autoplay:{
      delay:3500,
      disableOnInteraction: false,
    }
  }); -->
</script>
</body>
</html>