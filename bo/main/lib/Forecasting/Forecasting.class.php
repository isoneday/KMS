<?php

/**
 * GT_Forecasting
 * 
 * Class used for forecasting value for centaint period or event. It's support executive to decide what to supply for next period
 * 
 * @author Agung Puji Mustofa, agungpm_ti -at- yahoo.com
 * @package general
 * @version $Id: GT_Forecasting.class.php 0001 2012-10-06 12:22:00 $
 */
 
class GT_Forecasting {
    public $equation_result = '';  // if there is equation result for forecasting such as linear regresion
    public $forecast_result = array();
    public $equation_params = array();
    public $equation_type = '';
    
    /**
     * __construct(): constructor function
     *
     */
     
    function __construct()
    {
        // no nothings
    }
    
    
    /**
     * average(): function to calculate average data for certain period
     *
     * @param  array $data, its array based on simple array (a,b,c,d,e,f)
     * @return number $result
     */
     
     function average($data) {
        if (empty($data)) {
            return 0;
        } else {
            $sum_all_number     = 0;
            $count_all_number   = 0;
            
            foreach ($data as $item_id => $item) {
                $sum_all_number += $item;
                $count_all_number++;
            }
            
            $result = (float)($sum_all_number/$count_all_number);
            
            return $result;
        }
     }
     
    /**
     * linearRegresion(): function to calculate forecast on certain value using linear regresion
     * Linear regresion folowe this rule:
       1. Find axis and ordinat average
       2. Find b1 from b1x + b0 = Y
       3. find b0
     *
     * @param  array $axis, contain every value in axis line using as reference value
     * @param  array $ordinat, contain every value in ordinat line using as result value
     * @param  array $target, ordinat forecast from an axis available
     * @return array $result, array of number
     */     
     function linearRegresion($axis,$ordinat, $target) {
        $this->equation_type = 'linear_regresion';
        
		$sum_x 		=	0;
		$sum_y		=	0;	
    
        foreach ($ordinat as $ord_id => $ord) {
            $sum_x += $axis[$ord_id];
            $sum_y += $ord;
        }
        
        $average_x = $sum_x/sizeOf($axis);
        $average_y = $sum_y/sizeOf($ordinat);
        
        $b1 = 0;
        $b1_top = 0;
        $b1_below = 0;
        
        foreach ($ordinat as $ord_id => $ord) {
            $b1_top += (($axis[$ord_id] - $average_x )*($ord - $average_y));
            $b1_below += (($axis[$ord_id] - $average_x )*$axis[$ord_id] - $average_x );
        }
        
        if ($b1_below==0) {
            $b1 = 0;
        } else {
            $b1 = $b1_top/$b1_below;
        }
        
        $b0 = $average_y - ($b1*$average_x);
        
        $this->equation_result = 'y = '.$b1.'x';
        
        if ($b0 < 0) {
            $this->equation_result .= ' - '.abs($b0);
        } else {
            $this->equation_result .= ' + '.abs($b0);
        }
        
        if (!empty($target)) {
            foreach ($target as $targ_id => $targ) {
                $this->forecast_result[] = $b1*$targ + $b0;
            }
        }
        
        $this->equation_params = array ($b1, $b0);
        
        return $this->forecast_result;

     }
     
    /**
     * exponensialInterpolation(): function to calculate forecast on certain value using exponential interpolation
     * it's like linear regresion but using matemathic rule z = ln(y), it will follow this process:
       1. Find axis and ordinat average
       2. Find b1 from b1x + b0 = Y
       3. find b0
     *
     * @param  array $axis, contain every value in axis line using as reference value
     * @param  array $ordinat, contain every value in ordinat line using as result value
     * @param  array $target, ordinat forecast from an axis available
     * @return array $result, array of number
     */ 
     function exponensialInterpolation($axis,$ordinat, $target) {
        $this->equation_type = 'exponential_interpolation';
        
		$sum_x 		=	0;
		$sum_y		=	0;	
        
        // change to log mode
        foreach ($ordinat as $ord_id => $ord) {
            $ordinat[$ord_id] = log($ord,10);	
        }
    
        foreach ($ordinat as $ord_id => $ord) {
            $sum_x += $axis[$ord_id];
            $sum_y += $ord;
        }
        
        $average_x = $sum_x/sizeOf($axis);
        $average_y = $sum_y/sizeOf($ordinat);
        
        $b1 = 0;
        $b1_top = 0;
        $b1_below = 0;
        
        foreach ($ordinat as $ord_id => $ord) {
            $b1_top += (($axis[$ord_id] - $average_x )*($ord - $average_y));
            $b1_below += (($axis[$ord_id] - $average_x )*$axis[$ord_id] - $average_x );
        }
        
        if ($b1_below==0) {
            $b1 = 0;
        } else {
            $b1 = $b1_top/$b1_below;
        }
        
        $b0 = $average_y - ($b1*$average_x);
        
        $this->equation_result = 'y = '.$b1.'x';
        
        if ($b0 < 0) {
            $this->equation_result .= ' - '.abs($b0);
        } else {
            $this->equation_result .= ' + '.abs($b0);
        }
        
        if (!empty($target)) {
            foreach ($target as $targ_id => $targ) {
                $this->forecast_result[] = $b1*$targ + $b0;
            }
        }
        
        $this->equation_params = array ($b1, $b0);
        
        return $this->forecast_result;
     }
     
     

     function polinomialInterpolation($axis,$ordinat,$order,$target) {
        // define matrix consist permutation combination each order level, it's means if order = 2
        // the matrix size will be 3x3 (2+1)
        $matrix[0][0] = sizeOf($ordinat);
        for($i=1;$i<=$order;$i++) {
			for($j=1;$j<=$order;$j++) {
				$matrix[$i][$j] = 0;
			}
		}
        
        // simetrical amtrix always have same value even if you flip it away, it's menas that matrx[i][j] 
        // always the same as matrix[j][i] and matrix[1][1] =  matrix[0][1]*matrix[1][0]
        for($i=0;$i<=$order;$i++) {
			for($j=0;$j<=$order;$j++) {
				// hitung jumlah dengan melihat pada i dan j
				if ($i+$j != 0) {
					$pangkat = $i + $j;
					for ($k=0;$k<sizeOf($axis);$k++) {
						$matrix[$i][$j]		+= exp($pangkat*log($axis[$k]));
					}
				}
			}
		}
        
        // set default value for result
        for($i=0;$i<=$order;$i++) {
			$matrix_result[$i] = 0;
		}
        
		for($i=0;$i<=$order;$i++) {
			if ($i==0) {
				for ($k=0;$k<sizeOf($ordinat);$k++) {
					$matrix_result[$i] +=$ordinat[$k];	
				}
			} else {
				for ($k=0;$k<sizeOf($ordinat);$k++) {
					$matrix_result[$i] += $ordinat[$k]*exp($i*log($axis[$k]));	
				}				
			}
		}	
        
        foreach($matrix as $matrix_id => $mat_id) {
			ksort($matrix[$matrix_id]);
		}
		ksort($matrix_result);
        
        
        
        return $this->forecast_result;
     }
     
    /**
     * getResultFromEquation(): function to calculate value for centain equation formula
     * @param  array $target, one dimensional array target
     * @param  array $equation, aquation type such as "linear_regresion"
     * @return array $result, array of number
     */ 
     function getResultFromEquation($target, $equation = null) {
        if (!empty($equation) && $equation !='') {
            $this->equation_type = $equation;
        }
        $this->forecast_result = array();
        if ($this->equation_type=='linear_regresion') {
            if (!empty($target)) {
                foreach ($target as $targ_id => $targ) {
                    $this->forecast_result[] = $this->equation_params[0]*$targ + $this->equation_params[1];
                }
                
                return $this->forecast_result;
            }
        } else if ($this->equation_type=='exponential_interpolation') {
            if (!empty($target)) {
                foreach ($target as $targ_id => $targ) {
                    $this->forecast_result[] =  $this->equation_params[0]*(exp($targ*log($this->equation_params[0]))); 
                }
            }
        }
        
        return $this->forecast_result;
     }
     
     
    
    
}

?>