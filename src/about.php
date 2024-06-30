<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>about</title>

   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="about">

   <div class="row">

      <div class="image">
         <img src="images/about-img.svg" alt="">
      </div>

      <div class="content">
         <h3>why choose us?</h3>
         <p>When it comes to online games, movies, and music, choosing us is the ultimate choice for an exceptional entertainment experience. With a vast selection spanning various genres and eras, our platform offers something for everyone. Convenience is at your fingertips, allowing you to access a world of entertainment from the comfort of your own home. Our commitment to high-quality content ensures immersive gameplay, stunning visuals, and captivating audio. Competitive pricing, accessible across multiple devices, makes enjoying your favorite content affordable and convenient. Plus, our dedicated customer support is always ready to assist you. Trust us for a secure and enjoyable online experience like no other.</p>
         <a href="contact.php" class="btn">contact us</a>
      </div>

   </div>

</section>

<section class="reviews">
   
   <h1 class="heading">client's reviews</h1>

   <div class="swiper reviews-slider">

   <div class="swiper-wrapper">

      <div class="swiper-slide slide">
         <img src="images/pic-1.png" alt="">
         <p>"I've been a loyal customer of this online games store for years, and I can confidently say that it's the best platform for all my gaming needs. The selection is extensive, covering both popular titles and hidden gems. The convenience of instant digital access saves me time and effort, and the high-quality graphics and immersive gameplay keep me engaged for hours. The competitive pricing and regular promotions make it even more affordable. With excellent customer support, this online games store has truly become my go-to destination for all things gaming."</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Abe Malone</h3>
      </div>

      <div class="swiper-slide slide">
         <img src="images/pic-2.png" alt="">
         <p>"If you're a movie enthusiast like me, this online movies store is a dream come true. The collection is vast and diverse, ranging from timeless classics to the latest blockbusters. Streaming movies on my smart TV is incredibly convenient, and the video quality is exceptional, offering a cinematic experience at home. The pricing is competitive, and I appreciate the special promotions that make it even more affordable. With an easy-to-navigate interface and reliable customer support, this movies store has become my one-stop shop for endless entertainment."</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Marie Doe</h3>
      </div>

      <div class="swiper-slide slide">
         <img src="images/pic-3.png" alt="">
         <p>"This online music store is a haven for music lovers. The catalog is extensive, featuring a wide range of genres and artists, ensuring there's something for every mood and taste. I love the seamless streaming experience, allowing me to enjoy my favorite songs on-the-go. The audio quality is outstanding, delivering crisp and clear sound. The pricing is reasonable, and I often take advantage of the special deals and discounts. The customer support is responsive and helpful, making my music shopping experience smooth and enjoyable."</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
            <i class="fa-regular fa-star"></i>
            <i class="fa-regular fa-star"></i>
         </div>
         <h3>John Black</h3>
      </div>

      <div class="swiper-slide slide">
         <img src="images/pic-4.png" alt="">
         <p>"I can't recommend this online store enough. Whether you're into gaming, movies, or music, this platform has it all. The selection is mind-blowing, catering to various interests and preferences. The convenience of accessing everything digitally is a game-changer, eliminating the need for physical copies. The quality of the content is top-notch, with impressive graphics, captivating storylines, and a wide range of musical genres. The pricing is competitive, making it accessible for all budgets. The customer support team is friendly and efficient, ensuring a seamless shopping experience. Trust me, once you try this online store, you won't look back."</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
            <i class="fa-regular fa-star"></i>
         </div>
         <h3>Alia Smith</h3>
      </div>

      <div class="swiper-slide slide">
         <img src="images/pic-5.png" alt="">
         <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quia tempore distinctio hic, iusto adipisci a rerum nemo perspiciatis fugiat sapiente.</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>john deo</h3>
      </div>

      <div class="swiper-slide slide">
         <img src="images/pic-6.png" alt="">
         <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quia tempore distinctio hic, iusto adipisci a rerum nemo perspiciatis fugiat sapiente.</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>john deo</h3>
      </div>

   </div>

   <div class="swiper-pagination"></div>

   </div>

</section>









<?php include 'components/footer.php'; ?>

<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

<script src="js/script.js"></script>

<script>

var swiper = new Swiper(".reviews-slider", {
   loop:true,
   spaceBetween: 20,
   pagination: {
      el: ".swiper-pagination",
      clickable:true,
   },
   breakpoints: {
      0: {
        slidesPerView:1,
      },
      768: {
        slidesPerView: 2,
      },
      991: {
        slidesPerView: 3,
      },
   },
});

</script>

</body>
</html>