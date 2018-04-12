
        <div class="footertop">
          <div class="col-lg-12">
            <div class="col-lg-3 footer-block">
              <h4 class="footer-header">Contact</h4>
              <h3>Gamatechno Indonesia</h3>
              <h5>Head Office:</h5>
              <p>
                  Jalan Cik Di Tiro No. 34<br> 
                  YOGYAKARTA - 55223<br>
                  INDONESIA
              </p>
             <h5>Branch Office:</h5>
              <p>
                 Gedung UGM - Samator Pendidikan Lantai 10<br> 
                  Jalan Dr. Sahardjo No. 83 - Tebet, Manggarai<br>
                  JAKARTA SELATAN - 12850<br>
                  INDONESIA
              </p>
            
            </div>
            <div class="col-lg-5 footer-block">
              <h4 class="footer-header">Videos</h4>
              <iframe width="100%" height="220px" src="<?php echo (!empty($video['video_url']))?  $video['video_url'] : '';?>" frameborder="0" allowfullscreen style="border-radius:5px;margin-right:10px;"></iframe>
            </div>
            <div class="col-lg-4 footer-block">
              <h4 class="footer-header">News Update</h4>
              <ul class="list-footer">
              </ul>
            </div>
          </div>
        </div>

        <!-- Footer -->
        <footer class="footerlow">
            <div class="row" style="padding-top:10px;">
                <div class="col-lg-12">
                    <p>Copyright &copy; Knowledge Management System 2016 by iswandi saputra</p>
                </div>
            </div>
        </footer>

        <!-- jQuery -->
        <script src="<?php echo base_url();?>js/jquery.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="<?php echo base_url();?>js/bootstrap.min.js"></script>

        <!-- Script to Activate the Carousel -->
        <script>
            $('.carousel').carousel({
                interval: 5000 //changes the speed
            })
        </script>

        <script>
            $(function() {
                $('a[href*=#]:not([href=#])').click(function() {
                    if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
                        var target = $(this.hash);
                        target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                        if (target.length) {
                            $('html,body').animate({
                                scrollTop: target.offset().top
                            }, 1000);
                            return false;
                        }
                    }
                });
            });
        </script>

    </body>

</html>
<!-- /patTemplate:tmpl -->
