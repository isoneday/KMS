
  <!-- FAQ Section -->
  <section class="faq-section">
    <div class="container">
      <div class="row">
        <div class="col-xs-12 faq-section-container">
          <div class="row">
            <div class="col-md-12">
              <h1 class="page-header title-header">FAQ</h1>
              <h2 class="text-center">Knowledge Management System</h2>
              <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
              <?php 
              if(!empty($faq)){
                for($i=0; $i < sizeof($faq); $i++){
                  $no   = $i + 1; 
                  $in   = ($i == 0) ? $in = 'in': $in = '' ;
                  echo '              <div class="panel panel-default">'."\r\n";
                  echo '                <div class="panel-heading" role="tab" id="heading'.$i.'">'."\r\n";
                  echo '                 <h4 class="panel-title">'."\r\n";
                  echo '                    <a role="button" data-toggle="collapse" data-parent="#accordion" data-target="#collapse'.$i.'" href="javascript:;" aria-expanded="true" aria-controls="collapse'.$i.'">'.$no.". ".$faq[$i]["faq_question"].'
                                         </a>'."\r\n";
                  echo '                 </h4>'."\r\n";
                  echo '                </div>'."\r\n";
                  echo '               <div id="collapse'.$i.'" class="panel-collapse collapse '.$in.'" role="tabpanel" aria-labelledby="heading'.$i.'">';
                  echo '                 <div class="panel-body">'.$faq[$i]["faq_answer"].'</div>'."\r\n";
                  echo '                </div>'."\r\n";
                  echo '             </div>';
                }
              }
              ?>
              </div>
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