<!-- Page Content -->
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <h1 class="page-header title-header">Download <span class="text-blue">Dokumen</span></h1>
          <table class="table">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama File</th>
                <th>Download</th>
              </tr>
            </thead>
            <tbody>
              <?php 
                if(!empty($documents)){
                  for($i=0; $i<sizeof($documents);$i++){
                    $no = $i+1;
                    echo '              <tr>';
                    echo '                <th scope="row">'.$no.'</th>'."\r\n";
                    echo '                <td><span class="icon-extension"><img src="img/icons/pdf_icon.png"></span>'.$documents[$i]['document_title'].'</td>'."\r\n";
                    echo '                <td><a target="blank_" href="'.$doc_path.$documents[$i]['document_file_'].'"class="btn btn-success btn-sm"><i class="fa fa-download"></i> Download</a></td>'."\r\n";
                    echo '              <tr>'."\r\n";
                  }
                } else{
                    echo '              <tr>';
                    echo '                <th scope="row"></th>'."\r\n";
                    echo '                <td>No Documnets</td>'."\r\n";
                    echo '              <tr>'."\r\n";
                }
            
              ?>        
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <!-- /.container -->