
        <!-- Header Carousel -->
        <header id="myCarousel" class="carousel slide">
          <!-- Indicators -->
          <ol class="carousel-indicators">
            <?php 
              if(!empty($banner)){
                for($i = 0; $i < sizeof($banner); $i++){
                  if($i==0) 
                    echo '            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>'."\r\n";
                  else
                    echo '            <li data-target="#myCarousel" data-slide-to="'.$i.'"></li>'."\r\n";
                }
              }
            ?>
          </ol>
          <!-- Wrapper for slides -->
          <div class="carousel-inner">
            <?php 
              if(!empty($banner)){
                for($i = 0; $i < sizeof($banner); $i++){
                  $active = '';
                  if($i==0) {
                    $active = ' active';
                  }
                  echo '                <div class="item '.$active.'">'."\r\n";
                  echo '                  <div class="fill" style="background-image:url(\''.$image_path.$banner[$i]['slider_photo'].'\')"></div>'."\r\n";
                  echo '                  <div class="carousel-caption">'."\r\n";
                  echo '                    <h2>'.$banner[$i]['slider_title'].'</h2>'."\r\n";
                  echo '                  </div>'."\r\n";
                  echo '                </div>'."\r\n";
                }
              }
            ?>
          </div>
          <!-- Controls -->
          <a class="left carousel-control" href="javascript:;" data-target="#myCarousel" data-slide="prev">
              <span class="icon-prev"></span>
          </a>
          <a class="right carousel-control" href="javascript:;" data-target="#myCarousel" data-slide="next">
              <span class="icon-next"></span>
          </a>
        </header>
        <div class="container bar-search">
            <div class="col-lg-6 bar-content">
                <ul class="listsearch">
                    <li><span class="underheader">Subscribe our channels</span></li>
                    <li><a href="#"><img class="icon-sosmed" src="<?php echo base_url();?>img/fb-icon.png"></a></li>
                    <li><a href="#"><img class="icon-sosmed" src="<?php echo base_url();?>img/twitter-icon.png"></a></li>
                    <li><a href="#"><img class="icon-sosmed" src="<?php echo base_url();?>img/ig-icon.png"></a></li>
                </ul>
            </div>
            <div class="col-lg-6 search-listbox">
                <div class="dropdown pull-right bahasa">
                    <button class="btns dropdown-toggle btn-bahasa" type="button" onclick="window.location.href = '<?php echo base_url();?>bo'" style="margin-right:10px">
                        <i class="fa fa-sign-in" style="padding-right:5px"></i> Login
                    </button>
                  </div>
            </div>
        </div>

        <!-- Page Content -->
        <div class="container">

            <!-- Marketing Icons Section -->
            <!--<div class="row" id="home">
                <hr>
                <div class="img-red text-center">
                    <ul>
                        <li><img class="img-responsive news-sidebar img-redaction2" src="img/gallery/redactional1.jpg"></li>
                        <li><img class="img-responsive news-sidebar img-redaction1" src="img/gallery/redactional2.jpg"></li>
                        <li><img class="img-responsive news-sidebar img-redaction" src="img/gallery/redactional3.jpg"></li>
                        <li><img class="img-responsive news-sidebar img-redaction1" src="img/gallery/redactional4.jpg"></li>
                        <li><img class="img-responsive news-sidebar img-redaction2" src="img/gallery/redactional5.jpg"></li>
                    </ul>
                </div>
                <p class="text-center redactional">
                    Sebagai bentuk kepedulian terhadap pendidikan dan lingkungan hidup,  PT. Pertamina (Persero) melalui Pertamina Foundation memberikan beasiswa pendidikan kepada putra – putri terbaik Indonesia guna pengembangan keahlian dan pengetahuan untuk menciptakan sumber daya manusia yang unggul.<br>Putra-putri terbaik Indonesia juga dilatih untuk menjadi Sobat Bumi, manusia yang mampu mengelola kekayaan alam Indonesia secara arif dan bijaksana serta peduli terhadap lingkungan.
                </p>
                <hr>
            </div>-->
            <!-- /.row -->

            <!-- Features Section -->
            <div class="row" id="penjelasan">
                <div class="col-lg-12">
                    <!--<h1 class="page-header title-header">Penjelasan <span class="text-blue">Knowledge Management System</span></h1>-->
                </div>
                  <div class="col-lg-12">
                    <h1 class="page-header title-header"><span class="text-blue">Profile Perusahaan</span></h1>
                </div>
              
                <div class="col-md-6">
                    <p class="redactional">
                        <b class="strong">Gamatechno</b> adalah perusahaan yang memiliki fokus pada pengembangan produk dan solusi teknologi informasi untuk segmen perguruan tinggi, lembaga pemerintah, perusahaan penyedia jasa transportasi dan logistik, serta industri lifestyle.
                        <b class="strong"> PT Gamatechno Indonesia (Gamatechno)</b> resmi berdiri pada tanggal 4 Januari 2005 dan berkantor pusat di Yogyakarta. Guna meningkatkan layanan kepada lebih dari 240 klien di seluruh Indonesia yang tersebar dari Banda Aceh hingga Papua, pada tahun 2013 Gamatechno membuka kantor cabang di Jakarta.<br><br>
                        Seiring dengan perkembangan perusahaan, saat ini Gamatechno memiliki fokus pada pengembangan produk dan solusi teknologi informasi untuk segmen perguruan tinggi, lembaga pemerintah, perusahaan penyedia jasa transportasi dan logistik, serta industri lifestyle. Layanan yang berfokus pada 4 segmen utama tersebut selanjutnya didefinisikan sebagai <b class="strong">gtSmartCity Solution</b>, yaitu solusi berbasis sistem dan teknologi informasi guna mewujudkan sebuah kota cerdas dengan ciri less paper, less time, less cash dan less complexity untuk meningkatkan tatanan hidup masyarakat.Untuk <b class="strong">segmen perguruan tinggi</b>, produk unggulan Gamatechno adalah gtCampus Suite yaitu sistem informasi terintegrasi untuk perguruan tinggi yang terdiri atas berbagai software modular yang dirancang sesuai dengan proses bisnis perguruan tinggi mulai dari pengelolaan penerimaan calon mahasiswa, pengelolaan perkuliahan mahasiswa hingga lulus, pengelolaan aset kampus yang meliputi aset sumber daya manusia, keuangan dan aset barang, perpustakaan, penelitian dan beasiswa hingga dashboard system untuk pimpinan kampus.<br>

                    </p>
                </div>
                <div class="col-md-6">
                    <p class="redactional">
Untuk <b class="strong">segmen lembaga pemerintah</b>, Gamatechno memiliki beberapa produk unggulan, diantaranya adalah gtPerizinan (sistem pengelolaan pelayanan perizinan terpadu), gtAspirasi (sistem pengelolaan aspirasi masyarakat), serta aplikasi gtGroupware (sistem kolaborasi dan arsip perkantoran). Selain produk-produk tersebut, Gamatechno juga melayani pengembangan portal website lembaga dengan konsep citizen centric, serta pengembangan berbagai aplikasi berbasis web lainnya sesuai dengan kebutuhan lembaga.<br><br>
Untuk <b class="strong">segmen transportasi dan logistik</b>, Gamatechno mengembangkan beberapa produk unggulan bagi perusahaan atau organisasi yang bergerak dibidang layanan transportasi dan logistik, yaitu gtFleets (sistem informasi pengelolaan armada), gtSmartTicket System (sistem tiket elektronik berbasis smartcard), serta aplikasi mTransport (aplikasi mobile untuk informasi dan layanan transportasi publik).
Pada segmen lifestyle, Gamatechno mengembangkan produk-produk aplikasi back-end dan front-end untuk beberapa sub industri diantaranya taman hiburan dan wisata, pusat belanja dan entertainment, microfinance, dan industri kesehatan. Beberapa portofolio produk untuk segmen lifestyle ini antara lain eoviz.com (small & medium enterprises resource planning system on cloud), mEvent (aplikasi mobile informasi event), serta mCatalog (aplikasi mobile informasi katalog produk).<br><br>
Selain pengembangan produk aplikasi berbasis web, mobile, smartcard dan beberapa teknologi terkini lainnya yang dikemas dalam gtSmartCity Solution, Gamatechno juga menyediakan jasa konsultasi IT, audit IT, training IT, serta layanan maintenance sistem dan agregasi konten digital.

                    </p>
                </div>
               
                <div class="col-md-12 caption">
                    <p class="redactional young">Gamatechno adalah perusahaan yang memiliki fokus pada pengembangan produk dan solusi teknologi informasi untuk segmen perguruan tinggi, lembaga pemerintah, perusahaan penyedia jasa transportasi dan logistik, serta industri lifestyle </p>
                </div>
            </div>
            <!-- /.row -->

            <!-- Features Section -->
            <!-- <div class="row" id="tahap">
                <div class="col-lg-12">
                    <h1 class="page-header title-header">Tahapan <span class="text-blue">Seleksi</span></h1>
                </div>
                <div class="col-md-12">
                    <table class="table table-bordered">
                      <thead class="header-table">
                        <tr>
                          <th></th>
                          <th>Kegiatan</th>
                          <th>Waktu Pelaksanaan</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <th scope="row">1</th>
                          <td>Sosialisasi dan Pembukaan Beasiswa</td>
                          <td>28 Sept - 2 Okt 2015</td>
                        </tr>
                        <tr>
                          <th scope="row">2</th>
                          <td>Pendaftaran Beasiswa</td>
                          <td>3 - 15 Oktober 2015</td>
                        </tr>
                        <tr>
                          <th scope="row">3</th>
                          <td>Pengumuman Lolos Seleksi untuk Wawancara</td>
                          <td>21 Oktober 2015</td>
                        </tr>
                        <tr>
                          <th scope="row">4</th>
                          <td>Seleksi Wawancara</td>
                          <td>26 Okt - 6 Nov 2015</td>
                        </tr>
                        <tr>
                          <th scope="row">5</th>
                          <td>Pengumuman</td>
                          <td>9 November 2015</td>
                        </tr>
                        <tr>
                          <th scope="row">6</th>
                          <td>Penandatangan Perjanjian & Pendaftaran Ulang</td>
                          <td>9 - 13 November 2015</td>
                        </tr>
                        <tr>
                          <th scope="row">7</th>
                          <td>Penyaluran Pertamina Beasiswa Sobat Bumi</td>
                          <td>Akhir November 2015</td>
                        </tr>
                      </tbody>
                    </table>
                </div>
            </div> -->
            <!-- /.row -->

            <!-- Features Section -->
            <div class="row" id="syarat">
                <div class="col-lg-12">
                    <h1 class="page-header title-header"><span class="text-blue">visi</span> & <span class="text-blue">misi</span></h1>
                </div>
                <div class="col-md-6">
                    <h2 class="blueheader">VISI</h2>
                    <ol class="redactional">
                        <li>To be a market leader in national smart city development</li>

                    </ol>
                </div>
                <div class="col-md-6">
                    <h2 class="greenheader">MISI</h2>
                    <ol class="redactional">
                        <li>Mengakomodasi kebutuhan, sumber daya, dan tujuan UGM</li>
                                   <li>Menciptakan masyarakat cerdas melalui produk-produk TI yang digunakan sehari-hari</li>
                                   <li>Berpartisipasi aktif dalam komunitas global untuk mengembangkan industri kreatif digital</li>
                    </ol>
                </div>
                <hr>
            </div>
            <!-- /.row -->

            <!-- Portfolio Section 
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header title-header">Our <span class="text-blue">Videos</span></h1>
                </div>
                <div class="col-md-4 col-sm-6">
                    <iframe width="100%" height="250px" src="https://www.youtube.com/embed/_vRgAVbeWoM" frameborder="0" allowfullscreen style="border-radius:5px;"></iframe>
                </div>
                <div class="col-md-4 col-sm-6">
                    <iframe width="100%" height="250px" src="https://www.youtube.com/embed/JJk5Flujfq4" frameborder="0" allowfullscreen style="border-radius:5px"></iframe>
                </div>
                <div class="col-md-4 col-sm-6">
                    <iframe width="100%" height="250px" src="https://www.youtube.com/embed/_vRgAVbeWoM" frameborder="0" allowfullscreen style="border-radius:5px;"></iframe>
                </div>
            </div>
            <!-- /.row 
    
            <!-- News Section 
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header title-header">
                        News <span class="text-blue">Update</span>
                    </h1>
                </div>
                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <h3 class="text-blue"><a href="single-post.html">Lorem Ipsum Dollor Sit Amet</a></h3>
                            <small>Senin, 31 Agustus 2015<span class="pull-right">Posted by : <a href="#">Admin</a></span></small>
                            <img class="img-responsive news-thumb" src="img/news/news1.jpg">
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Itaque, optio corporis quae nulla aspernatur in alias at numquam rerum ea excepturi expedita tenetur assumenda voluptatibus eveniet incidunt dicta nostrum quod?</p>
                            <a href="#" class="btn btn-success">Read More...</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <h3 class="text-blue"><a href="single-post.html">Lorem Ipsum Dollor Sit Amet</a></h3>
                            <small>Senin, 31 Agustus 2015<span class="pull-right">Posted by : <a href="#">Admin</a></span></small>
                            <img class="img-responsive news-thumb" src="img/news/news2.jpg">
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Itaque, optio corporis quae nulla aspernatur in alias at numquam rerum ea excepturi expedita tenetur assumenda voluptatibus eveniet incidunt dicta nostrum quod?</p>
                            <a href="#" class="btn btn-success">Read More...</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <h3 class="text-blue"><a href="single-post.html">Lorem Ipsum Dollor Sit Amet</a></h3>
                            <small>Senin, 31 Agustus 2015<span class="pull-right">Posted by : <a href="#">Admin</a></span></small>
                            <img class="img-responsive news-thumb" src="img/news/news3.jpg">
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Itaque, optio corporis quae nulla aspernatur in alias at numquam rerum ea excepturi expedita tenetur assumenda voluptatibus eveniet incidunt dicta nostrum quod?</p>
                            <a href="#" class="btn btn-success">Read More...</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container -->