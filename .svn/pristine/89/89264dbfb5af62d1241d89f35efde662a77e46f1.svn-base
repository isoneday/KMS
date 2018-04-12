<!-- Page Content -->
      <div class="container highspace">
        <!-- Content Row -->
        <div class="row" style="padding-top:0px;">
          <!-- Blog Post Content Column -->
          <div class="col-lg-8">
            <!-- Blog Post -->
            <h1 class="text-blue"><a href="#"><?php echo $news_content['news_title'];?></a></h1>
            <!-- Preview Image -->
            <img class="img-responsive" src="<?php echo $image_path.$news_content['news_photo'];?>" alt="<?php echo $news_content['news_photo'];?>">
            <hr>
            <!-- Date/Time -->
            <small><?php echo date("l, F d, Y", strtotime($news_content['news_date'])); ?><span class="pull-right">Posted by : <a href="#">Admin</a></span></small>
            <hr>
            <!-- Post Content -->
            <?php 
              echo $news_content['news_content'];
            ?>
            <hr>
          </div>
          <!-- Blog Sidebar Widgets Column -->
          <div class="col-md-4">
            <!-- Blog Search Well -->
            <div class="well bluebg">
              <h4>Blog Search</h4>
              <form action="<?php echo base_url();?>news/" method="GET" enctype="multipart/form-data">
                <div class="input-group">
                  <input name="search" type="text" class="form-control">
                  <span class="input-group-btn">
                    <button class="btn btn-success" type="submit"><i class="fa fa-search"></i></button>
                  </span>
                </div>
              </form>
              <!-- /.input-group -->
            </div>
            <!-- Blog Categories Well -->
            <div class="well">
              <h4>Berita Lainnya</h4>
              <div class="row" style="padding-top:0px;">
                <div class="col-lg-12">
                  <ul class="list-unstyled">
                  <?php 
                    if(!empty($recent_news)){
                      for($i=0;$i<sizeof($recent_news);$i++){
                        echo '                    <li class="list-sidebar">'."\r\n";
                        echo '                        <img class="news-sidebar pull-left" src="'.$image_path.$recent_news[$i]['news_photo'].'">'."\r\n";
                        echo '                        <h4><a href="'.base_url().'news/detail/'.$recent_news[$i]['news_id'].'">'.$recent_news[$i]['news_title'].'</a></h4>'."\r\n";
                        echo '                        <span class="date-sidebar"><small>'.date("l, F d, Y", strtotime($recent_news[$i]['news_date'])).'</small></span>'."\r\n";
                        echo '                    </li>'."\r\n";
                      }
                    }
                  ?>
                  </ul>
                </div>
              </div>
              <!-- /.row -->
            </div>
          </div>
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container -->