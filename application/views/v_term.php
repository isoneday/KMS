<div class="headline merchant">
    <div class="container">
      <div class="row">
        <div class="col-xs-12">
          <div class="merchant-text">
            <h1 class="whatson-headline-Subtitle">Terms & Conditions</h1>
          </div>
        </div>
      </div>
    </div>
  </div>
	<!-- end: headline -->

  <!-- Whatson Section -->
  <section class="merchant-section opensans-font">
    <div class="container">

<?php 
if(!empty($term)){
    echo  '<h1>'.$term["term_title"].'</h1>';
    echo   $term['term_content'];
}
?>
    </div>
  </section>
  <!-- end: Whatson Section -->