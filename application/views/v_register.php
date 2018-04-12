<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registration Form | Portal Beasiswa Pertamina Sobat Bumi | Pertamina Foundation</title>
    <link rel="shortcut icon" href="img/favicon.png">
    <!-- Styles -->
    <link href="<?php echo base_url(); ?>font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"><!-- font-awesome -->
    <link href="<?php echo base_url(); ?>js/dropdown-menu/dropdown-menu.css" rel="stylesheet" type="text/css"><!-- dropdown-menu -->
    <link href="<?php echo base_url(); ?>bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css"><!-- Bootstrap -->
    <link href="<?php echo base_url(); ?>js/fancybox/jquery.fancybox.css" rel="stylesheet" type="text/css"><!-- Fancybox -->
    <link href="<?php echo base_url(); ?>bootstrap/style.css" rel="stylesheet" type="text/css"><!-- theme styles -->
    <link href="<?php echo base_url(); ?>bootstrap/bootstrap-datepicker.css" rel="stylesheet">
  </head>

  <body role="document">
    <!-- device test, don't remove. javascript needed! -->
    <span class="visible-xs"></span><span class="visible-sm"></span><span class="visible-md"></span><span class="visible-lg"></span>
    <!-- device test end -->
    <div class="col-lg-12 topbar">
      <div class="dropdown pull-right bahasa">
        <button class="btns dropdown-toggle btn-bahasa" type="button" onclick="window.location.href = '<?php echo base_url(); ?>bo'" style="margin-right:10px">
          <i class="fa fa-sign-in" style="padding-right:5px"></i> Login
        </button>
        <span class="registerbar">Not a member yet? </span>
        <button class="btns dropdown-toggle btn-bahasa" type="button" onclick="window.location.href = '<?php echo base_url(); ?>register'" style="margin-right:10px;background-color:#2ecc71;color:#fff !important;">
          <i class="fa fa-pencil-square-o" style="padding-right:5px"></i> Register
        </button>
      </div>
    </div>
    <div id="k-head" class="container"><!-- container + head wrapper -->
      <div class="row">
        <div class="col-lg-12">
          <div id="k-site-logo"><!-- site logo -->
            <h1 class="k-logo">
              <a href="<?php echo base_url(); ?>" title="Home Page">
                <center><img src="<?php echo base_url(); ?>img/site-logo.png" alt="Site Logo" class="img-responsive" /></center>
              </a>
            </h1>
          </div><!-- site logo end -->
        </div>
      </div><!-- row end -->
    </div><!-- container + head wrapper end -->
    <div id="k-body"><!-- content wrapper -->
      <div class="container"><!-- container -->
        <div class="row"><!-- row -->
          <div class="k-breadcrumbs col-lg-12 clearfix"><!-- breadcrumbs -->
          </div><!-- breadcrumbs end -->
        </div><!-- row end -->
        <div class="row no-gutter"><!-- row --></div><!-- upcoming events wrapper end -->
        <div class="row no-gutter"><!-- row --></div><!-- upcoming events wrapper end -->
        <div class="col-lg-12 col-md-12"><!-- recent news wrapper -->
          <div class="col-padded"><!-- inner custom column -->
            <!--Form Registrasi-->
              <div class="main-content col-lg-8 col-md-8" id="kriteria">
                <h1 class="title-widget bigtitle titlereg">Form Registrasi Beasiswa Pertamina Sobat Bumi</h1>
                  <?php
                  if ($success != '') {
                      echo '    <div class="alert-custom text-center">';
                      echo '      <div class="col-md-12 col-sm-12 col-xs-12 alert-banner">';
                      echo '        <div class="alert alert-success alert-dismissible fade in" role="alert">';
                      echo '          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                      echo '          <strong>Success!</strong> ' . $success;
                      echo '        </div>';
                      echo '      </div>';
                      echo '    </div>';
                  }

                  if ($fail != '') {
                      echo '    <div class="alert-custom text-center">';
                      echo '      <div class="col-md-7 col-sm-10 col-xs-12 alert-banner">';
                      echo '        <div class="alert alert-warning alert-dismissible fade in" role="alert">';
                      echo '          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                      echo '          <strong>Warning!</strong> ' . $fail;
                      echo '        </div>';
                      echo '      </div>';
                      echo '    </div>';
                  }
                  ?>
                <hr/>
                  <form id="formPendaftaran" class="xhr_form std_form"  enctype="multipart/form-data" method="post" action="<?php echo base_url(); ?>register/action">
                    <table class="table-edit" width="100%">
                      <tr>
                        <th width="30%"><label class="col-sm-12">Tahun Masuk Kuliah</label></th>
                        <td>
                          <select name="tahun_masuk" id="tahun_masuk">
                            <option value="-1">Pilih Tahun Masuk</option>
                            <?php
                            $end_date = date("Y");
                            $start_date = 2014;
                            for ($i = 0; $start_date <= $end_date; $i++) {
                                echo "<option value='$start_date'>$start_date</option>";
                                $start_date++;
                            }
                            ?>
                          </select>
                          &nbsp;*
                        </td>
                      </tr>
                      <tr><td>&nbsp;</td></tr>
                      <tr>
                        <th><label class="col-sm-2">Nim</label></th>
                        <td>
                          <input type="text" id="nim" name="nim" value="" size="30" /> *
                        </td>
                        <td></td>
                      </tr>
                      <tr><td>&nbsp;</td></tr>
                      <tr>
                          <th><label class="col-sm-2">Nama</label></th>
                          <td>
                              <input type="text" id="nama" name="nama" value="" size="50" /> *
                          </td>
                          <td></td>
                      </tr>
                      <tr><td>&nbsp;</td></tr>
                      <tr>
                        <th><label class="col-sm-12">Tanggal Lahir</label></th>
                        <td>
                          <select name="tanggal">
                              <option value="-1">Tanggal</option>
                              <?php
                              for ($i = 1; $i <= 31; $i++) {
                                  echo "<option value='".sprintf('%02d', $i)."'>" . sprintf('%02d', $i) . "</option>";
                              }
                              ?>
                          </select>
                          &nbsp;
                          <select name="bulan">
                            <option value="-1">Bulan</option>
                              <?php
                              $bulan = array(1 => "Januari", 2 => "Februari", 3 => "Maret", 4 => "April", 5 => "Mei", 6 => "Juni", 7 => "juli", 8 => "Agustus", 9 => "September", 10 => "Oktober", 11 => "November", 12 => "Desember");
                              for ($a = 1; $a <= count($bulan); $a++) {
                                  echo "<option value='".sprintf('%02d', $a)."'>" . $bulan[$a] . "</option>";
                              }
                              ?>
                          </select>
                          &nbsp;
                          <select name="tahun">
                            <option value="-1">Tahun</option>
                              <?php
                              for ($c = 1990; $c <= 2016; $c++) {
                                  echo "<option value='$c'>" . $c . "</option>";
                              }
                              ?>
                          </select>
                        </td>
                      </tr>
                      <tr><td>&nbsp;</td></tr>
                      <tr>
                        <th><label class="col-sm-2">Email</label></th>
                        <td>
                          <input type="text" id="email" name="email" value="" size="20" /> *
                        </td>
                      </tr>
                      <tr><td>&nbsp;</td></tr>
                      <tr>
                        <th><label class="col-sm-12">Sumber Informasi Beasiswa</label></th>
                        <td>
                          <select name="sumber_info_beasiswa" id="sumber_info_beasiswa">
                          <option value="-1">Pilih Sumber Informasi</option>
                            <?php
                            foreach ($sumber_info_beasiswa->result() as $rows) {
                                echo "<option value='" . $rows->sumberinfo_id . "'>" . $rows->sumberinfo_name . "</option>";
                            }
                            ?>
                          </select>
                          &nbsp;*
                        </td>
                      </tr>
                      <tr><td>&nbsp;</td></tr>
                      <tr>
                        <th><label class="col-sm-12">Universitas</label></th>
                        <td>
                          <select onchange="selectFakultas(this.options[this.selectedIndex].value)" name="universitas" id="universitas">
                            <option value="-1">Pilih Universitas</option>
                            <?php
                            foreach ($universitas->result() as $item) {
                                echo "<option value='" . $item->id . "'>" . $item->name . "</option>";
                            }
                            ?>
                          </select>
                          &nbsp;*
                        </td>
                      </tr>
                      <tr><td>&nbsp;</td></tr>
                      <tr>
                        <th><label class="col-sm-12">Jenjang</label></th>
                        <td>
                          <select name="jenjang_pendidikan" id="jenjang_pendidikan">
                            <option value="-1">Pilih Jenjang Pendidikan</option>
                            <?php
                            foreach ($jenjang_pendidikan->result() as $row) {
                                echo "<option value='" . $row->jenjangpendidikan_id . "'>" . $row->jenjangpendidikan_name . " (" . $row->jenjangpendidikan_kode . ")</option>";
                            }
                            ?>
                          </select>
                            &nbsp;*
                        </td>
                      </tr>
                      <tr><td>&nbsp;</td></tr>
                      <tr>
                        <th><label class="col-sm-12">Fakultas</label></th>
                        <td>
                          <select id="fakultas_dropdown" name="fakultas" onchange="selectJurusan(this.options[this.selectedIndex].value)">
                              <option value="-1">Pilih Fakultas</option>
                          </select>
                          <span id="fakultas_loader"></span>
                          &nbsp;*
                        </td>
                      </tr>
                      <tr><td>&nbsp;</td></tr>
                      <tr>
                        <th><label class="col-sm-12">Jurusan</label></th>
                        <td>
                          <select id="jurusan_dropdown" name="jurusan" onchange="selectProdi(this.options[this.selectedIndex].value)">
                              <option value="-1">Pilih Jurusan</option>
                          </select>
                          <span id="jurusan_loader"></span>
                          &nbsp;*
                        </td>
                      </tr>
                      <tr><td>&nbsp;</td></tr>
                      <tr>
                        <th><label class="col-sm-12">Program Studi</label></th>
                        <td>
                          <select id="prodi_dropdown" name="prodi">
                              <option value="-1">Pilih Program Studi</option>
                          </select>
                          <span id="prodi_loader"></span>
                          &nbsp;*
                        </td>
                      </tr>
                      <tr>
                        <th><label class="col-sm-12">Kode Verifikasi</label></th>
                        <td>
                          <form method="GET" id="fmCaptcha">
                            <div style="margin-top:15px;">
                              <div id="captcha">
                                <?php echo $captcha; ?>
                              </div>
                             <!--  <img src="<?php echo base_url(); ?>captcha/index.php" id="captcha" /> -->
                              <!-- CHANGE TEXT LINK -->
                              <a href="javascript:;" onclick="create_captcha();" id="change-image">Tidak terbaca? Ganti text.</a>
                              <br/><br/>
                             </div>
                            <input type="text" name="captcha" id="captcha-form" />
                            <i>(masukkan di sini)</i>
                          </form>
                        </td>
                      </tr>
                    </table>
                    </br>
                    <center><input class="btn btn-default" name="save" type="submit" value="Submit" /></center>
                  </form>
                </div><!-- inner custom column end -->
                <!--end form-registrasi-->
            </div>
          </div><!-- recent news wrapper end -->
        </div><!-- row end -->
      </div><!-- container end -->
    </div><!-- content wrapper end -->
    <div id="k-subfooter"><!-- subfooter -->
        <div class="container"><!-- container -->
            <div class="row"><!-- row -->
                <div class="col-lg-6" style="padding-top:30px;">
                    <b class="contactfooter">Kontak Program Beasiswa PF-Beasiswa Pertamina Sobat Bumi</b>
                    <p class="text-white">
                        Email: beasiswa@pertaminafoundation.org<br>
                        Telp. 021 290 443 16
                    </p>
                </div>
                <div class="col-lg-6">
                    <p class="copy-text text-inverse text-white pull-right">
                        &copy; 2015 Gamatechno Indonesia. All rights reserved.
                    </p>
                </div>
            </div><!-- row end -->
        </div><!-- container end -->
    </div><!-- subfooter end -->

    <script src="<?php echo base_url(); ?>js/jquery-1.js"></script>
    <script src="<?php echo base_url(); ?>js/bootstrap-datepicker.js"></script>
    <script src="<?php echo base_url(); ?>jQuery/jquery-migrate-1.2.1.min.js"></script>
    
    <!-- Bootstrap -->
    <script src="<?php echo base_url(); ?>bootstrap/js/bootstrap.min.js"></script>
    
    <!-- Drop-down -->
    <script src="<?php echo base_url(); ?>js/dropdown-menu/dropdown-menu.js"></script>

    <!-- Fancybox -->
    <script src="<?php echo base_url(); ?>js/fancybox/jquery.fancybox.pack.js"></script>
    <script src="<?php echo base_url(); ?>js/fancybox/jquery.fancybox-media.js"></script><!-- Fancybox media -->

    <!-- Responsive videos -->
    <script src="<?php echo base_url(); ?>js/jquery.fitvids.js"></script>

    <!-- Audio player -->
    <script src="<?php echo base_url(); ?>js/audioplayer/audioplayer.min.js"></script>

    <!-- Pie charts -->
    <script src="<?php echo base_url(); ?>js/jquery.easy-pie-chart.js"></script>

    <!-- Theme -->
    <script src="<?php echo base_url(); ?>js/jquery.validate.js"></script>

    <script type="text/javascript">
      //add select box validation 
      $.validator.addMethod("valueNotEquals", function(value, element, arg){
       return arg != value;
      }, "Value must not equal arg.");

      $("#formPendaftaran").validate({
          rules: {
              tahun_masuk : {
                  valueNotEquals: "-1"
              },
              email: {
                  required: true,
                  email: true,
                  remote: {
                      url: "<?php echo base_url() . 'register/member_check/'; ?>",
                      type: "post",
                      data:
                      {
                          login: function()
                          {
                              return $('#formPendaftaran :input[name="captcha"]').val();
                          }
                      }
                  }
              },
              nama: {
                  required: true
              },
              tanggal: {
                  valueNotEquals: "-1"
              },
              bulan: {
                  valueNotEquals: "-1"
              },
              tahun: {
                  valueNotEquals: "-1"
              },
              sumber_info_beasiswa: {
                  valueNotEquals: "-1"
              },
              nim: {
                  required: true,
                  remote: {
                      url: "<?php echo base_url() . 'register/nim_check/'; ?>",
                      type: "post",
                      data:
                          {
                            login: function()
                            {
                              return $('#formPendaftaran :input[name="nim"]').val();
                            }
                          }
                  }
              },
              universitas: {
                  valueNotEquals: "-1"
              },
              jenjang_pendidikan: {
                  valueNotEquals: "-1"
              },
              fakultas: {
                  valueNotEquals: "-1"
              },
              jurusan: {
                  valueNotEquals: "-1"
              },
              prodi: {
                  valueNotEquals: "-1"
              },
              captcha: {
                  required : true,
                  remote :
                  {
                      url: "<?php echo base_url() . 'register/check_captcha/'; ?>",
                      type: "post",
                      data:
                      {
                          captcha: function()
                          {
                              return $('#formPendaftaran :input[name="captcha"]').val();
                          }
                      }
                  }
              }
          },
          messages: {
              tahun_masuk : {
                  valueNotEquals: " Silahkan masukan tahun masuk Kuliah."
              },
              email: {
                  required: " Silahkan memasukkan alamat email",
                  remote: jQuery.validator.format("{0} sudah digunakan.")
              },
              nama: {
                  required: " Silahkan memasukkan Nama Anda"
              },
              tanggal: {
                  valueNotEquals: "Masukan tanggl."
              },
              bulan: {
                  valueNotEquals: "Masukan bulan."
              },
              tahun: {
                  valueNotEquals: "Masukan tahun."
              },
              nim: {
                  required: " Silahkan memasukkan Nim Anda",
                  remote: jQuery.validator.format("{0} sudah terdaftar.")
              },
              sumber_info_beasiswa: {
                  valueNotEquals: "Silahkan memilih sumber informasi."
              },
              universitas: {
                  valueNotEquals: "Silahkan memilih universitas."
              },
              jenjang_pendidikan: {
                  valueNotEquals: " Silahkan memilih jenjang pendidikan."
              },
              fakultas: {
                  valueNotEquals: " Silahkan memilih fakultas."
              },
              jurusan: {
                  valueNotEquals: " Silahkan memilih jurusan."
              },
              prodi: {
                  valueNotEquals: " Silahkan memilih program pendidikan."
              },
              captcha: {
                  required: "Isikan kode.",
                  remote: " Kode yang dimasukan salah."
              }
          }
      });
    </script>
    
    <script type="text/javascript">
        function selectFakultas(univ_id) {
            if (univ_id != "-1") {
                loadData('fakultas', univ_id);
                $("#jurusan_dropdown").html("<option value='-1'>Pilih Jurusan</option>");
            } else {
                $("#fakultas_dropdown").html("<option value='-1'>Pilih Fakultas</option>");
                $("#jurusan_dropdown").html("<option value='-1'>Pilih Jurusan</option>");
                $("#prodi_dropdown").html("<option value='-1'>Pilih Program Studi</option>");
            }
        }

        function selectJurusan(fakultas_id) {
            if (fakultas_id != "-1") {
                loadData('jurusan', fakultas_id);
            } else {
                $("#jurusan_dropdown").html("<option value='-1'>Pilih Jurusan</option>");
            }
        }

        function create_captcha() {
          $.ajax({
                type: "POST",
                url: "<?php echo base_url();?>register/create_captcha",
                cache: false,
                success: function(result) {
                   $("#captcha").html(result);
                }
            });
        }

        function selectProdi(jurusan_id) {
            if (jurusan_id != "-1") {
                loadData('prodi', jurusan_id);
            } else {
                $("#prodi_dropdown").html("<option value='-1'>Pilih Program Studi</option>");
            }
        }

        function loadData(loadType, loadId) {
            var dataString = 'loadType=' + loadType + '&loadId=' + loadId;
            var urlString = "<?php echo base_url(); ?>register/loadData";
            $("#" + loadType + "_loader").show();
            $("#" + loadType + "_loader").fadeIn(400).html('Please wait...');
            $.ajax({
                type: "POST",
                url: urlString,
                data: dataString,
                cache: false,
                success: function(result) {
                    $("#" + loadType + "_loader").hide();
                    $("#" + loadType + "_dropdown").html("<option value='-1'>Select " + loadType + "</option>");
                    $("#" + loadType + "_dropdown").append(result);
                }
            });
        }
    </script>
    <!--custom script-->
    <script type="text/javascript">
        $(function() {
            $('a[title]').tooltip();
        });

        $('.datepicker').datepicker({
        });

    </script>

<!--    <script>
        var suksesDaftar = '{STATUS_DAFTAR}';
        if (suksesDaftar) {
            document.getElementById('formPendaftaran').style.display = "none";
        }

    </script>-->

</body>
</html>

