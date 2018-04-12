<?php

/**
 * GT_ExcelHelper
 * 
 * Class used for get parameter to PHPExcel2007
 * 
 * @author Agung Puji Mustofa, agungpm_ti -at- yahoo.com
 * @package general
 * @version $Id: GT_ExcelHelper.class.php 0001 2012-08-18 07:42:00 $
 */
 
class GT_ExcelHelper {
    
        public $column = array (
            '0' => 'A',
            '1' => 'B',
            '2' => 'C',
            '3' => 'D',
            '4' => 'E',
            '5' => 'F',
            '6' => 'G',
            '7' => 'H',
            '8' => 'I',
            '9' => 'J',
            '10' => 'K',
            '11' => 'L',
            '12' => 'M',
            '13' => 'N',
            '14' => 'O',
            '15' => 'P',
            '16' => 'Q',
            '17' => 'R',
            '18' => 'S',
            '19' => 'T',
            '20' => 'U',
            '21' => 'V',
            '22' => 'W',
            '23' => 'X',
            '24' => 'Y',
            '25' => 'Z',
            '26' => 'AA',
            '27' => 'AB',
            '28' => 'AC',
            '29' => 'AD',
            '30' => 'AE',
            '31' => 'AF',
            '32' => 'AG',
            '33' => 'AH',
            '34' => 'AI',
            '35' => 'AJ',
            '36' => 'AK',
            '37' => 'AL',
            '38' => 'AM',
            '39' => 'AN',
            '40' => 'AO',
            '41' => 'AP',
            '42' => 'AQ',
            '43' => 'AR',
            '44' => 'AS',
            '45' => 'AT',
            '46' => 'AU',
            '47' => 'AV',
            '48' => 'AW',
            '49' => 'AX',
            '50' => 'AY',
            '51' => 'AZ'
        );
        
    public $format_title = array (
			'borders' => array(
			
			),
			'font'    => array(
				'bold'      => true,
				'size'		=> 13,
                'name'      => 'Arial'
			),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP
			)		
    );
    
    public $format_title_child = 	array(
        'borders' => array(
			
        ),
        'font' => array(
            'bold'      => false,
			'size'		=> 9,
            'name'      => 'Arial'
        ),
        'alignment' => array(
			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP
        )					
    );

    
    public $format_header = array(
        'borders' => array(
			'right'     => array(
			     'style' => PHPExcel_Style_Border::BORDER_THIN
 		     ),
 		     'top'     => array(
			     'style' => PHPExcel_Style_Border::BORDER_THIN
             ),
             'left'     => array(
			     'style' => PHPExcel_Style_Border::BORDER_THIN
             ),
             'bottom'     => array(
			     'style' => PHPExcel_Style_Border::BORDER_THIN
			)
        ),
        'font'    => array(
            'bold'      => false,
            'size'		=> 9,
            'name'      => 'Arial'
        ),
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
        )					
    );
    
    public $format_left = 	array(
        'borders' => array(
            'right'     => array(
				'style' => PHPExcel_Style_Border::BORDER_THIN
			),
			'top'     => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN
            ),
            'left'     => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN
            ),
            'bottom'     => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN
            )
        ),
        'font'    => array(
            'bold'      => false,
			'size'		=> 9,
            'name'      => 'Arial'
        ),
        'alignment' => array(
			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP
        )					
    );
		
    public $format_center = 	array(
		'borders' => array(
            'right'     => array(
		          'style' => PHPExcel_Style_Border::BORDER_THIN
            ),
            'top'     => array(
		          'style' => PHPExcel_Style_Border::BORDER_THIN
            ),
            'left'     => array(
		          'style' => PHPExcel_Style_Border::BORDER_THIN
            ),
            'bottom'     => array(
		          'style' => PHPExcel_Style_Border::BORDER_THIN
            )
		),
		'font'  => array(
		      'bold'      => false,
		      'size'		=> 9,
              'name'      => 'Arial'
		),
		'alignment' => array(
		      'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
              'vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP
		)					
    );
		
    public $format_right = 	array(
        'borders' => array(
            'right'     => array(
				'style' => PHPExcel_Style_Border::BORDER_THIN
            ),
            'top'     => array(
	 		    'style' => PHPExcel_Style_Border::BORDER_THIN
		 	),
		 	'left'     => array(
	 		    'style' => PHPExcel_Style_Border::BORDER_THIN
		 	),
		 	'bottom'     => array(
	 		    'style' => PHPExcel_Style_Border::BORDER_THIN
		 	)
		),
		'font'    => array(
            'bold'      => false,
            'size'		=> 9,
            'name'      => 'Arial'
		),
		'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP
		)					
    );
    
    public $format_head = array(
        'font' => array(
            'bold' => false,
            'size' => 9,
            'name' => 'Arial'
        ),
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP
        )
    );
    
    public $format_head_center = array(
        'font' => array(
            'bold' => false,
            'size' => 9,
            'name' => 'Arial'
        ),
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP
        )
    );
    
    
    public $dimension_style = array ();
    
    /**
     * getFormat(): function to get excel format syntaks based on array paramater
     *
     * @param  array $params contain many paramater such as left, center, right, title, title_child, bold, italic, strike
     * @return array $result contain style array
     */
    
    function getFormat($params) {
        $result = array();
        if (empty($params)) {
            return array();
        } else if (!is_array($params)) {
            return array();
        } else {
            foreach ($params as $par_id => $par) {
               if ($par=='left') {
                    $result = $this->format_left;
               } else if ($par=='center') {
                    $result = $this->format_center;
               } else if ($par=='right') {
                    $result = $this->format_right;
               } else if ($par=='title') {
                    $result = $this->format_title;
               } else if ($par=='title_child') {
                    $result = $this->format_title_child;
               } else if ($par=='bold') {
                    $result['font']['bold'] = true;
               }
            }
            
            return $result;
        }
    }
    
    /**
     * setDimensionStyle(): function to set style in column to avoid set it at each cell
     *
     * @param  integer $column_number refer to number of column in excel, usually start from 0
     * @params $style array of many paramater such as left, center, right, title, title_child, bold, italic, strike
     * @return null
     */
    
    function setDimensionStyle($column_number,$style) {
        
        
        return null;
    }
    
    
        
    
    /**
     * __construct(): constructor function
     *
     */
     
    function __construct()
    {
        // no nothings
    }
    
}
 
 
?>