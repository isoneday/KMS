<?php
/**
 * @author GTFW CRUD Generator 
 */
 
class PageSearch extends Database
{

    public function __construct($connectionNumber = 0)
    {
        parent::__construct($connectionNumber);
        $this->LoadSql('module/page.search/business/mysqlt/pagesearch.sql.php');
        $this->SetDebugOn();
    }

public function countModKmsdata()
    {
        $query = $this->mSqlQueries['count_modkmsdata'];
        $result = $this->Open($query, array());
        return $result[0]['total'];
    }

    public function countPageSearch($filter)
    {
       
     
      //   $query = $this->mSqlQueries['count_pagesearch'];
      //  $result = $this->Open($query, array(filter['id_masdok']));
      // return $result[0]['total'];
if (is_array($filter))
            extract($filter);
        $str = '';
          if (!empty($filedata_path)) {
            $str .= " AND LOWER(filedata_path) LIKE('%$filedata_path%')";
        } 
           $limit = '';
        if (!empty($display)) {
            $limit = "LIMIT $start, $display";   
        }
     
        $query = $this->mSqlQueries['get_pagesearch'];
        $query = str_replace('--search--', $str, $query);
      $query = str_replace('--limit--', $limit, $query);
     $result = $this->Open(stripslashes($query),array());
   
    
}
 
    public function getPageSearch($filter)
    {
        function myTruncate2($string, $limit, $break=" ", $pad="...")
{
  // return with no change if string is shorter than $limit
  if(strlen($string) <= $limit) return $string;

  $string = substr($string, 0, $limit);
  if(false !== ($breakpoint = strrpos($string, $break))) {
    $string = substr($string, 0, $breakpoint);
  }

  return $string . $pad;
}
function bold($string, $word)
{
    //return preg_replace('/\b'.$word.'\b/i', '<strong>'.$word.'</strong>', $string);
    return str_ireplace($word,'<strong>'.$word.'</strong>',$string);
  }

 if (is_array($filter))
            extract($filter);
        $str = '';
         $limit =1;
        if (!empty($display)) {
            $limit = "LIMIT $start, $display";   
        }
        
        $query = $this->mSqlQueries['get_pagesearch'];
        $query = str_replace('--search--', $str, $query);
      $query = str_replace('--limit--', $limit, $query);
    //  $query = str_replace('--idmasdok--', $limit, $query);
     $result = $this->Open(stripslashes($query),array($filter['idmasdok']));
 //  $aha = ['time'];
   $return =$result[0]['filedata_path'];
  // $return2 =$result[0]['filedata_size'];
  //   echo $return2;die(); //  $tile=".txt";
   
  // print_r($result);die();
    $a=".txt";
    $b=".csv";
        $tile=array($a,$b);

        for($k=0;$k<count($tile);$k++){

            $path_to_check = $return.'*'.'-'.$filter['idmasdok'].$tile[$k].'';
            //$needle = $_POST['cari'];
       
            //$search = $_POST['cari'];
            if (is_array($filter))
                extract($filter);

            if(!empty($cari)){
       
                $j=0;
                
                foreach(glob ($path_to_check."*") as $filename){
                   // echo "<pre>";
                   // print_r($filename);echo "</pre>";
                     //            $keyword=fopen('haha.txt', '')
                     // $pattern    = preg_replace('/\s|\t|\r|\n/', '|', $keyword);
                     // $search     = preg_replace("/$pattern/i", '<b>\0</b>', $keyword);
                    $i=0;                    
                    foreach(file($filename) as $fli=>$fl){
                        if(stripos($fl,$cari)!==false && $i==0){
                            $file = new SplFileObject($filename);
                            $myfile=$fli+1;
                              $file->seek($myfile-1);
                              $sear=$file->current();
                              $hasil=myTruncate2($sear,253);
                              $file_asli = end(split('/',$filename));
                              $data[] = array(
                    			       	    'filename' => $filename,
                    		                'judul'=>$test=$result[$j]['kmsdata_keyword'],
                                     'jenis_dokumentasi'=>$test=$result[$j]['nama_dokumentasi'],
                           		      'idmasdok'=>$test=$result[$j]['idmasdok'],
                                    'uploadby'=>$test=$result[$j]['uploadby'],
                                      
                              	      'line' =>$fli+1,
                                      'timee'  =>$test=$result[$j]['time'],
                                      'filecari'=>bold($hasil, $cari),   
                                      'nama_file' => substr($file_asli, 0,-4),
                                      'file_download' =>$this->getOriginFile($file_asli,$filter['idmasdok']),
                                      );
                      //                 while ($line = fgets($myfile)) {
                      // // <... Do your work with the line ...>
                      //               echo($line);

//print_r($filter);                              
                              break;
                         }
  // $hasil2=array_unique($data); 
                    }
                          
                    $j++;           
                }
            }
            

        }

    //echo "<pre>".$this->GetLastError()."</pre>";
//exec($cmd);    
     //  echo "<pre>".$this->GetLastError()."</pre>";die;
//print_r($data[]);
    $result = $this->Open($this->mSqlQueries['get_pagesearch'], array($id));
 
        if ($result) {
            return $result[0];                            
        }
    else{
        return $data;
}
    }
   
 
    public function getOriginFile($filename,$id){
        $result = $this->Open($this->mSqlQueries['getOriginFile'], array($filename,$id));
        //echo "<pre>".$this->GetLastError()."</pre>";
      //  echo $filename;die();
        //print_r($result);
        if ($result) {
            return $result[0]['filedata_enc'];
        }
    }

    public function getDetailPageSearch($id)
    {
        $result = $this->Open($this->mSqlQueries['get_detail_pagesearch'], array($id));
        if ($result) {
            return $result[0];
        }
    }
    
    public function insertPageSearch($params)
    {
        return $this->Execute($this->mSqlQueries['insert_pagesearch'], $params);
    }
    
    public function updatePageSearch($params)
    {
        return $this->Execute($this->mSqlQueries['update_pagesearch'], $params);
    }
    
    public function deletePageSearch($id)
    {
        return $this->Execute($this->mSqlQueries['delete_pagesearch'], array($id));
    }
    
    public function listPageSearch()
    {
        return $this->Open($this->mSqlQueries['list_pagesearch'], array());
    }
}

// End of file PageSearch.class.php