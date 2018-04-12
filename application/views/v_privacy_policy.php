<div class="headline merchant">
    <div class="container">
      <div class="row">
        <div class="col-xs-12">
          <div class="merchant-text">
            <h1 class="whatson-headline-Subtitle">Privacy Policy</h1>
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
if(!empty($policy)){
    echo  '<h1>'.$policy["policy_name"].'</h1>';
    echo   $policy['policy_info'];
}
?>
    </div>
  </section>
  <!-- end: Whatson Section -->