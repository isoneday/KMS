
<!-- FAQ Section -->
<section class="faq-section">
  <div class="container">
    <div class="row">
      <div class="col-xs-12 faq-section-container">
        <div class="row">
          <div class="col-md-12">
            <h1 class="page-header title-header">News</h1>
          </div>
          <div class="col-md-4">
            <div class="sr-only">Column</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- end: FAQ Section -->

  <!-- end: Section List News -->
	

	<section class="opensans-font">
   	<div class="container">

<?php 
if(!empty($news)){
	for($i=0; $i < sizeof($news); $i++){
    $news[$i]["news_date"]        = date("d/m/Y h:i A", strtotime($news[$i]["news_date"]));
    $news[$i]["news_photo_path"]  = base_url() . 'bo/' . $news[$i]["news_photo_path"] . $news[$i]["news_photo"];
    $news_link                    = base_url().'news/detail/'.$news[$i]["news_id"];     

		echo ' 	<div class="row">'."\r\n";
		echo '		<div class="col-md-1 col-sm-1">&nbsp;</div>'."\r\n";
		echo '		<div class="col-md-10 list-newsblock">'."\r\n";
		echo '			<div class="row">'."\r\n";
		echo '				<div class="col-xs-8 content-text">'."\r\n";
		echo '		     	<div class="list-news-content">'."\r\n";
		echo '             <div class="list-news-title">'."\r\n";
		echo '							<a href="'.$news_link.'" title=""><h2>'.$news[$i]["news_title"].'</h2></a>'."\r\n";
		echo '             </div>'."\r\n";
		echo '           	<small class="list-news-date">Posted by <strong>'.$news[$i]["user_user_name"].'</strong> on '.$news[$i]["news_date"].'</small> '."\r\n";
		echo '           	<p class="list-news-subtitle">'.$news[$i]["news_snippet"].'</p> '."\r\n";
		echo '             <a href="'.$news_link.'" title="" class="green-bright">Continue Reading <i class="fa fa-caret-right"></i></a> '."\r\n";
		echo '      			</div> '."\r\n";
		echo '       	</div> '."\r\n";
		echo '        <div class="col-xs-4"> '."\r\n";
		echo '          <div class="list-news-image-container"> '."\r\n";
		echo '            <img class="list-news-image" width="100%" src="'.$news[$i]["news_photo_path"].'" alt="'.$news[$i]["news_photo"].'"> '."\r\n";
		echo '          </div> '."\r\n";
		echo '        </div> '."\r\n";
		echo '      </div> '."\r\n";
		echo '     </div> '."\r\n";
		echo '     <div class="col-md-1"> &nbsp; </div> '."\r\n";
		echo '   </div> '."\r\n";
	}
} else {
		echo '		<div class="alert alert-warning" role="alert">'."\r\n";
		echo '			No Data Avaliable';
		echo '		</div>'."\r\n";
}
?>
      
    </div>
  </section>
  <!-- Section List News -->
