<?php

/**
 * GT_Cramer
 * 
 * Class used for Create solution for double linear equation method using cramer
 * 
 * @author Agung Puji Mustofa, agungpm_ti -at- yahoo.com
 * @package general
 * @version $Id: GT_Cramer.class.php 0001 2012-10-06 12:22:00 $
 */

class GT_Cramer {
	
	var $ar_data 		= array();
	var $ar_sum			= array(); // jumlah persamaan
	var $matrix_input 	= array(); // matrix input model
	var $matrix_variable= array(); // matix variable
	var $matrix_result	= array(); // matrix result
	var $ar_result		= array(); // array result
	const EPSILON 		= 1e-10;
	
	function __construct() {
		// do nothing
	}
	
	function setInput($data) {
		$this->ar_data = $data;
	}
	
	function getCramer() {
		$this->createSum();
		$this->CreateMatrixInput();
		$this->InversMatrix();
		return $this->ar_result;
	}
	
	
	function createSum() {
		foreach ($this->ar_data as $data_id => $data) {
			foreach ($data as $dat_id => $dat) {
				if ($this->ar_sum[$dat_id]=='') {
					$this->ar_sum[$dat_id] =0;
				}	
				$this->ar_sum[$dat_id] += $dat;
			}
		}
	}
	
	function createMatrixInput() {
		$jumlah = sizeOf($this->ar_data);
		$jumlah_per_baris = sizeOf($this->ar_sum);
		
		// make base point for matrix (n X1 X2 X3)
		$this->matrix_input[0][0] = $jumlah;
		$this->matrix_result[0] 	= $this->ar_sum[0];
		for($i=1;$i<$jumlah_per_baris;$i++) {
			$this->matrix_input[0][$i] = $this->ar_sum[$i];
			$this->matrix_input[$i][0] = $this->ar_sum[$i];
		}
		
		// calculate the other with multiplication
		for($i=1;$i<$jumlah_per_baris;$i++) {
			for($j=1;$j<$jumlah_per_baris;$j++) {
				$this->matrix_input[$i][$j] =0;
				
				for($a=0;$a<$jumlah;$a++) {
					$this->matrix_input[$i][$j] += $this->ar_data[$a][$i]*$this->ar_data[$a][$j];
				}
			
			}
		}
		
		for($i=1;$i<$jumlah_per_baris;$i++) {
			$this->matrix_result[$i] = 0;
			for($a=0;$a<$jumlah;$a++) {
				$this->matrix_result[$i] += $this->ar_data[$a][$i]*$this->ar_data[$a][0];
			}				
		}
		
		
		
	}
	
	function inversMatrix() {
	    $N  = count($this->matrix_result);
	
	    // forward elimination
	    for ($p=0; $p<$N; $p++) {
	
	      // find pivot row and swap
	      $max = $p;
	      for ($i = $p+1; $i < $N; $i++)
	        if (abs($this->matrix_input[$i][$p]) > abs($this->matrix_input[$max][$p]))
	          $max = $i;
	      $temp = $this->matrix_input[$p]; $this->matrix_input[$p] = $this->matrix_input[$max]; $this->matrix_input[$max] = $temp;
	      $t    = $this->matrix_result[$p]; $this->matrix_result[$p] = $this->matrix_result[$max]; $this->matrix_result[$max] = $t;
	
	      // check if matrix is singular
	      if (abs($this->matrix_input[$p][$p]) <= EPSILON) die("Matrix is singular or nearly singular");
	
	      // pivot within A and b
	      for ($i = $p+1; $i < $N; $i++) {
	        $alpha = $this->matrix_input[$i][$p] / $this->matrix_input[$p][$p];
	        $this->matrix_result[$i] -= $alpha * $this->matrix_result[$p];
	        for ($j = $p; $j < $N; $j++)
	          $this->matrix_input[$i][$j] -= $alpha * $this->matrix_input[$p][$j];
	      }
	    }
	
	    // zero the solution vector
	    $x = array_fill(0, $N-1, 0);
	
	    // back substitution
	    for ($i = $N - 1; $i >= 0; $i--) {
	      $sum = 0.0;
	      for ($j = $i + 1; $j < $N; $j++)
	        $sum += $this->matrix_input[$i][$j] * $x[$j];
	      $x[$i] = ($this->matrix_result[$i] - $sum) / $this->matrix_input[$i][$i];
	    }
	
		
		
	    $this->ar_result= $x;
		
		return $x;	
	}	
	
	
}

// contoh 
/*
$data = array (
	0 => array(134,1,127,7),
	1 => array(176,1,134,42),
	2 => array(165,1,176,-9)
);

$oCramer = new Cramer();
$oCramer->setInput($data);
$oCramer->getCramer();

print_r($oCramer->ar_result);
*/
?>