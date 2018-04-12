
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
                    <span class="registerbar">Not a member yet? </span>
                    <button class="btns dropdown-toggle btn-bahasa" type="button" onclick="window.location.href = '<?php echo base_url();?>register'" style="margin-right:10px;background-color:#0071b7;color:#fff !important;">
                        <i class="fa fa-pencil-square-o" style="padding-right:5px"></i> Register
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
                    <!--<h1 class="page-header title-header">Penjelasan <span class="text-blue">Beasiswa</span></h1>-->
                </div>
                <div class="col-md-6">
                    <p class="redactional">
                        <b class="strong">Beasiswa Pertamina Sobat Bumi</b> diberikan kepada mahasiswa/ mahasiswi yang mendukung, menerapkan, serta menciptakan budaya dan kehidupan yang ramah terhadap lingkungan secara konsisten dan berkelanjutan.<br><br> 
                        Penerima <b class="strong">Beasiswa Pertamina Sobat Bumi</b> diharapkan menjadi agen perubahan dalam bidang lingkungan, pemberdayaan sosial kemasyarakatan serta dapat memberikan kontribusi positif dalam meningkatkan kualitas kehidupan masyarakat Indonesia.<br><br> 
                        Pertamina Foundation akan memberikan beasiswa kepada mahasiswa dan mahasiswi yang berkuliah pada mitra Perguruan Tinggi Negeri dan Perguruan Tinggi Swasta di Indonesia. Pada Gelombang Pertama, diberikan 100 beasiswa di 11 mitra Perguruan Tinggi.
                    </p>
                </div>
                <div class="col-md-6">
                    <table class="table table-bordered">
                        <thead class="header-table">
                            <tr>
                                <th></th>
                                <th>Nama Perguruan Tinggi</th>
                                <th>Lokasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td>Universitas Syiah Kuala</td>
                                <td>Nanggroe Aceh Darussalam</td>
                            </tr>
                            <tr>
                                <th scope="row">2</th>
                                <td>Universitas Mulawarman</td>
                                <td>Kalimantan Timur</td>
                            </tr>
                            <tr>
                                <th scope="row">3</th>
                                <td>Universitas Sumatera Utara</td>
                                <td>Sumatera Utara</td>
                            </tr>
                            <tr>
                                <th scope="row">4</th>
                                <td>Universitas Negeri Surabaya</td>
                                <td>Jawa Timur</td>
                            </tr>
                            <tr>
                                <th scope="row">5</th>
                                <td>Universitas Gadjah Mada</td>
                                <td>D.I. Jogjakarta</td>
                            </tr>
                            <tr>
                                <th scope="row">6</th>
                                <td>Institut Teknologi Sepuluh November</td>
                                <td>Jawa Timur</td>
                            </tr>
                            <tr>
                                <th scope="row">7</th>
                                <td>Universitas Negeri Jakarta</td>
                                <td>Jakarta</td>
                            </tr>
                            <tr>
                                <th scope="row">8</th>
                                <td>Universitas Teknologi Sumbawa</td>
                                <td>Nusa Tenggara Barat</td>
                            </tr>
                            <tr>
                                <th scope="row">9</th>
                                <td>Universitas Udayana</td>
                                <td>Bali</td>
                            </tr>
                            <tr>
                        
                                <th scope="row">10</th>
                                <td>Universitas Musamus Merauke</td>
                                <td>Papua</td>
                            </tr>
                            <tr>
                                <th scope="row">11</th>
                                <td>Universitas Cenderawasih</td>
                                <td>Papua</td>
                            </tr>
                        
                        </tbody>
                    </table>
                </div>

                <div class="col-md-12 caption">
                    <p class="redactional young">Ayo rebut kesempatan memperoleh bantuan beasiswa UKT Rp. 10.000.000 selama setahun, dan 
                        biaya hidup Rp.500.000 per bulan.<br>Jadilah 100 mahasiswa terbaik yang tergabung dalam <b class="strong">Beasiswa Pertamina Sobat Bumi</b>.</p>
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
                    <h1 class="page-header title-header">Syarat <span class="text-blue">Pendaftaran</span></h1>
                </div>
                <div class="col-md-6">
                    <h2 class="blueheader">Syarat Umum</h2>
                    <ol class="redactional">
                        <li>Warga Negara Indonesia yang dibuktikan Kartu Tanda Penduduk (KTP) yang sah dan masih berlaku.</li> 
                        <li>Terdaftar sebagai mahasiswa/ mahasiswi aktif atau tidak dalam masa cuti dari mitra 11 Perguruan Tinggi seperti tersebut di atas.</li>
                        <li>Mahasiswa/Mahasiswa Angkatan (Tahun Masuk) 2014 dan 2015</li>
                        <li>Telah menyelesaikan masa studi minimal 2 semester.</li>
                        <li>Indeks Prestasi Kumulatif (IPK) pada saat pendaftaran minimal 3.0</li>
                        <li>Mengisi formulir pendaftaran online di <a href="http://beasiswa.pertaminafoundation.org/">www.beasiswa.pertaminafoundation.org</a>.</li>
                        <li>Bersedia menjalani proses seleksi yang diselenggarakan Pertamina Foundation.</li>
                        <li>Tidak terlibat penyalahgunaan obat terlarang/narkoba dan kriminal</li>
                    </ol>
                </div>
                <div class="col-md-6">
                    <h2 class="greenheader">Syarat Khusus</h2>
                    <ol class="redactional">
                        <li>Bersedia menulis karya tulis dalam bentuk essay, dengan ketentuan: 
                            <ul>
                                <li>Essay bukan merupakan hasil plagiat.</li>
                                <li>Ditulis dalam 4 halaman dengan jumlah kata tulisan 1200 – 1400, dan jarak antar baris 1,5 spasi.</li>
                                <li>Tulisan bertema “Peran Mahasiswa Dalam Penciptaan Energi Baru dan Terbarukan�? atau “Pemberdayaan Masyarakat Dalam Pemanfaatan Energi Baru dan Terbarukan�? disertai dengan foto kegiatan minimal 2 buah foto.</li>  
                                <li>Essay mengutamakan sumber daya lokal/ teknologi rendah, berkontribusi positif terhadap lingkungan, mempunyai dampak meningkatkan kualitas hidup masyarakat.</li>
                            </ul>
                        <li>Melampirkan scan/ foto surat rekomendasi dari fakultas/ jurusan/ bagian akademik perihal mahasiswa yang berangkutan tidak sedang menerima beasiswa dari organisasi lain dan mahasiswa aktif/ tidak sedang dalam masa cuti.</li>
                        <li>Melampirkan scan/ foto surat rekomendasi dari tokoh/ pengurus/ pelaku organisasi lingkungan hidup, dan atau organisasi sosial kemasyarakatan.</li>
                        <li>Melampirkan scan/ foto slip pembayaran Uang Kuliah Tunggal (UKT).</li>
                        <li>Melampirkan scan/ foto transkrip nilai.</li>
                        <li>Melampirkan scan/ foto surat keterangan tidak mampu dari RT/RW/Kelurahan apabila dari keluarga kurang mampu.</li>
                        <li>Melampirkan scan/ foto Kartu Keluarga (KK).</li>
                    </ol>
                </div>
                <hr>
                <div class="col-md-12">
                    <a class="btn btn-success btn-lg text-center" style="width:100%" onclick="window.location.href = '<?php echo base_url();?>register'">DAFTAR</a>
                </div>
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