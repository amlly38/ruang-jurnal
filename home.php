<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Ruang Jurnal</title>
    <style>
       @import url('https://fonts.googleapis.com/css2?family=Protest+Guerrilla&display=swap');
      .container-fluid {
          grid-template-columns: 1fr;
      }
               
      .header {
          background-image: url('asetfoto/homepage.png');
          background-size: cover;
          background-position: center;
          height: 100vh;
          display: flex;
          align-items: center;
          justify-content: center;
      }

      .bg-polos {
          background-image: url('asetfoto/bgpolos.png');
          background-size: cover;
          background-position: center;
          height: 100vh;
          display: flex;
          align-items: center;
          justify-content: center;
      }

      .bg-coklat {
          background-image: url('asetfoto/bgcoklat.png');
          background-size: cover;
          background-position: center;
          height: 100vh;
          display: flex;
          align-items: center;
          justify-content: center;
      }

      .content {
          text-align: center;
          color: white;
      }
    </style>
</head>
<body>
    <!-- nav section start -->
<nav class="navbar navbar-expand-lg sticky-top">
  <div class="container-fluid">
    <a class="navbar-brand fw-semibold text-dark" href="index.php">
      <img src="asetfoto/logo.png" alt="Logo" width="35" height="35" class="d-inline-block align-text-top">
      <i class="text-black ms-2"> Ruang Jurnal </i>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" 
    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="nav justify-content-end me-auto">  <li class="nav-item">
          <a class="nav-link active text-black" aria-current="page" href="home.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-black" href="#about">About</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-black" href="#contact">Contact</a>
        </li>
        <li class="nav-item">
          <a class="btn btn-dark" href="login.php" role="button">Login</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

    <div class="header">
        </div>
    </div>

    <section class="py-3 py-md-5 bg-polos" id="about">
        <div class="container">
          <div class="row gy-3 gy-md-4 gy-lg-0 align-items-lg-center">
            <div class="col-12 col-lg-6 col-xl-5">
              <img class="img-fluid rounded" loading="lazy" src="asetfoto/about.png" alt="About 1">
            </div>
            <div class="col-12 col-lg-6 col-xl-7">
              <div class="row justify-content-xl-center">
                <div class="col-12 col-xl-11">
                  <h2 class="mb-3">Apa Itu Ruang Jurnal?</h2>
                  <p class="lead fs-4 mb-3 text-secondary">Gerbang Menuju Dunia Literasi dan Karya Tulis di 
                    Universitas Singaperbangsa Karawang</p>
                  <p class="mb-5">Para penulis, peneliti, dan pengamat memanfaatkan Ruang Jurnal sebagai wadah 
                    di mana mereka dapat menemukan, melihat, dan mengunggah karya tulis mereka, yang terdiri dari 
                    makalah dan jurnal. Selain berfungsi sebagai gudang tulisan, Ruang Jurnal juga berfungsi sebagai 
                    komunitas pencinta ilmu.</p>
                  <div class="row gy-4 gy-md-0 gx-xxl-5X">
                    <div class="col-12 col-md-6">
                      <div class="d-flex">
                        <div>
                          <h2 class="h4 mb-3">MAKALAH</h2>
                          <p class="text-secondary mb-0">Makalah adalah karya tulis ilmiah yang membahas suatu pokok 
                            bahasan tertentu secara sistematis dan logis, dengan tujuan untuk memberikan informasi, 
                            pengetahuan, dan pemahaman kepada pembaca.</p>
                        </div>
                      </div>
                    </div>
                    <div class="col-12 col-md-6">
                      <div class="d-flex">
                        <div>
                          <h2 class="h4 mb-3">JURNAL</h2>
                          <p class="text-secondary mb-0">Jurnal merupakan salah satu media yang digunakan untuk 
                            menyajikan hasil penelitian atau kajian ilmiah dalam bentuk tulisan. Jurnal memiliki peran 
                            yang sangat penting dalam menyebarluaskan pengetahuan dan informasi.</p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- about end -->
      
      <!-- contact start -->

  <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
  <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <!------ Include the above in your HEAD tag ---------->
  
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" 
  integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous">

<div class="bg-coklat">
  <div class="container-fluid" id="contact">
      <h1 class="text-center mt-2 text-light">Contact Address</h1>
      <hr>
      <div class="container-fluid">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126897.46300668558!2d107.17456246249999!3d-6.323239800000005!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6977ccb34822e1%3A0x6c4c7c12678610e0!2sUniversitas%20Singaperbangsa%20Karawang%20(UNSIKA)!5e0!3m2!1sid!2sid!4v1714917267225!5m2!1sid!2sid" 
          width="100%" height="320" style="border:0;" allowfullscreen="" loading="lazy" 
          referrerpolicy="no-referrer-when-downgrade" width="100%" height="100vh" frameborder="0" 
          style="border:0" allowfullscreen></iframe>
      </div>
      <div class="row text-center">
          <div class="col-4 box1 pt-4">
            <a href="tel:(0267)641177"><i class="fas fa-phone fa-3x text-light"></i>
            <h3 class="d-none d-lg-block d-xl-block text-light">Phone</h3>
            <p class="d-none d-lg-block d-xl-block text-light">(0267)641177</p></a>
          </div>
          <div class="col-4 box2 pt-4">
            <a href=""><i class="fas fa-home fa-3x text-light"></i>
            <h3 class="d-none d-lg-block d-xl-block text-light">Address</h3>
            <p class="d-none d-lg-block d-xl-block text-light">Jl. HS. Ronggo Waluyo, Telukjambe Timur, Karawang, 
              Jawa Barat, Indonesia - 41361</p></a>
          </div>
          <div class="col-4 box3 pt-4">
            <a href="mailto:info@unsika.ac.id"><i class="fas fa-envelope fa-3x text-light"></i>
            <h3 class="d-none d-lg-block d-xl-block text-light">E-mail</h3>
            <p class="d-none d-lg-block d-xl-block text-light">info@unsika.ac.id</p></a>
          </div>
      </div>
  </div>
</div>
  <!-- contact end -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>