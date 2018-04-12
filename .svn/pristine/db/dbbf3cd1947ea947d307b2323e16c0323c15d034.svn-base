<?php
/**
 * @author Prima Noor 
 */
   
class ViewExcelChart extends HtmlResponse
{
   
    function ProcessRequest()
    {   
        // $ObjReservation = GtfwDispt()->load->business('RepReservation', 'taxi.rep.reservation');
        Dispatcher::Instance()->load->helper('date');
        
        // $msg = Messenger::Instance()->Receive(__FILE__);
        
        // $filter = isset($msg[count($msg)-1][0]) ? $msg[count($msg)-1][0] : NULL;
        // Messenger::Instance()->Send(Dispatcher::Instance()->mModule, 'excelYearly', Dispatcher::Instance()->mAction, Dispatcher::Instance()->mType, array($filter), Messenger::NextRequest);
        // if (!empty($filter['display'])) unset($filter['display']);

        // $data = $ObjReservation->getRecap($filter);
        $data = array(
            array(
                    'year' => '2008',
                    'col1' => '100',
                    'col2' => '110'
                ),
            array(
                    'year' => '2009',
                    'col1' => '120',
                    'col2' => '90'
                ),
            array(
                    'year' => '2010',
                    'col1' => '145',
                    'col2' => '120'
                ),
            array(
                    'year' => '2011',
                    'col1' => '110',
                    'col2' => '110'
                ),
            array(
                    'year' => '2012',
                    'col1' => '200',
                    'col2' => '180'
                ),
            array(
                    'year' => '2013',
                    'col1' => '160',
                    'col2' => '190'
                )
        );

        if (!empty($data)) {
            #============== PHP EXCEL ============
            Dispatcher::Instance()->load->helper('excel');
            $ObjPHPExcel = Dispatcher::Instance()->load->library('PHPExcel');
            $sheet = $ObjPHPExcel->setActiveSheetIndex(0);
    
            $cols = array(
                array(
                    'name' => 'No',
                    'data' => 'no',
                    'size' => 5,
                    'align' => 'center'),
                array(
                    'name' => GtfwLangText('year'),
                    'data' => 'year',
                    'size' => 20),
                array(
                    'name' => 'Column 1',
                    'data' => 'col1',
                    'size' => 30),
                array(
                    'name' => 'Column 2',
                    'data' => 'col2',
                    'size' => 30),
                    );
    
            $sheet->setTitle('Data');
            $last_col_string = getColumnString(count($cols) - 1);
            $sheet->mergeCells('A1:' . $last_col_string . '1')->setCellValue('A1', 'Statistik Data Pemesanan Taxi')->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            // $sheet->mergeCells('A2:' . $last_col_string . '2')->setCellValue('A2', 'Tanggal : '.date('Y', strtotime($filter['year_start'])).' - '.date('Y', strtotime($filter['year_end'])))->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('A1')->getFont()->setBold(true);
    
            $first_row = 4;
            $last_row = $first_row;
            // set table header
            $last_col = 0;
            foreach ($cols as $col) {
                $sheet->getStyleByColumnAndRow($last_col, $last_row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                $sheet->setCellValueByColumnAndRow($last_col, $last_row, $col['name']);
                if ($col['size'])
                    $sheet->getColumnDimension(getColumnString($last_col))->setWidth($col['size']);
                $sheet->getStyleByColumnAndRow($last_col, $last_row)->getAlignment()->setWrapText(true)->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $sheet->getStyleByColumnAndRow($last_col, $last_row)->getFont()->setBold(true);
                $last_col++;
            }
    
            // set table data
            $first_row_data = $last_row + 1;
            $no = 1;
            if (!empty($data)) {
                foreach ($data as $rows) {
                    $last_row++;
                    // pre processing each data
                    $rows['no'] = $no;
                    
                    $last_col = 0;                
                    // parsing data
                    foreach ($cols as $col) {
                        $sheet->getStyleByColumnAndRow($last_col, $last_row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
                        if (!empty($col['type']) AND $col['type'] == 'string')
                            $sheet->setCellValueExplicitByColumnAndRow($last_col, $last_row, $rows[$col['data']]);
                        else 
                            $sheet->setCellValueByColumnAndRow($last_col, $last_row, $rows[$col['data']]);
                        if (!empty($col['align'])) {
                            switch ($col['align']) {
                                case 'center':
                                    $align = PHPExcel_Style_Alignment::HORIZONTAL_CENTER;
                                    break;
                                case 'left':
                                    $align = PHPExcel_Style_Alignment::HORIZONTAL_LEFT;
                                    break;
                                case 'right':
                                    $align = PHPExcel_Style_Alignment::HORIZONTAL_RIGHT;
                                    break;
                                case 'justify':
                                    $align = PHPExcel_Style_Alignment::HORIZONTAL_JUSTIFY;
                                    break;
                            }
                            $sheet->getStyleByColumnAndRow($last_col, $last_row)->getAlignment()->setHorizontal($align);
                        }
                        if (!empty($col['wrap']) AND $col['wrap'] == true) {
                            $sheet->getStyleByColumnAndRow($last_col, $last_row)->getAlignment()->setWrapText(true);
                        }
                        $last_col++;
                    }
                    $no++;
                }
                $last_row_data = $last_row;
            }
    
            $border = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
    
            $sheet->getStyle('A' . $first_row . ':' . (getColumnString(count($cols) - 1)) . ($first_row + count($data)))->applyFromArray($border);

            $ObjPHPExcel->createSheet(1);
            $sheet = $ObjPHPExcel->setActiveSheetIndex(1);
            $sheet->setTitle('Chart');
            $sheet->getPageMargins()->setTop(0.6);
            $sheet->getPageMargins()->setBottom(0.6);
            $sheet->getPageMargins()->setHeader(0.4);
            $sheet->getPageMargins()->setFooter(0.4);
            $sheet->getPageMargins()->setLeft(0.4);
            $sheet->getPageMargins()->setRight(0.4);

            $x_axis = new PHPExcel_Chart_DataSeriesValues('String', 'Data!$B$'.$first_row_data.':$B$'.$last_row_data);

            $values = array(
                new PHPExcel_Chart_DataSeriesValues('Number', 'Data!$C$'.$first_row_data.':$C$'.$last_row_data),
                new PHPExcel_Chart_DataSeriesValues('Number', 'Data!$D$'.$first_row_data.':$D$'.$last_row_data)
            );

            $labels = array( 
                new PHPExcel_Chart_DataSeriesValues('String', 'Data!$C$'.($first_row_data-1), null, 1), 
                new PHPExcel_Chart_DataSeriesValues('String', 'Data!$D$'.($first_row_data-1), null, 1),
            );

            $series = new PHPExcel_Chart_DataSeries(
                PHPExcel_Chart_DataSeries::TYPE_BARCHART,       // plotType
                PHPExcel_Chart_DataSeries::GROUPING_CLUSTERED,  // plotGrouping
                range(0,count($values)-1),                                       // plotOrder
                $labels,                                        // plotLabel
                array($x_axis),                                 // plotCategory
                $values                                         // plotValues
            );
            $series->setPlotDirection(PHPExcel_Chart_DataSeries::DIRECTION_COL);

            $layout = new PHPExcel_Chart_Layout();
            $plotarea = new PHPExcel_Chart_PlotArea($layout, array($series));
            $title = new PHPExcel_Chart_Title('Title');
            $legend = new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_RIGHT, null, false);
            $xAxisLabel = new PHPExcel_Chart_Title('x label');
            $yAxisLabel = new PHPExcel_Chart_Title('y label');

            $chart = new PHPExcel_Chart('Chart', $title, $legend, $plotarea, true, "0", $xAxisLabel, $yAxisLabel);

            $chart->setTopLeftPosition('B2');
            $chart->setBottomRightPosition('L16');

            $sheet->addChart($chart);
            
            $ObjPHPExcel->SetChart();

            $ObjPHPExcel->setActiveSheetIndex(0);

            $filename = 'Laporan Tahunan.xlsx';
            $ObjPHPExcel->SetFileName($filename);
            
            $ObjPHPExcel->Save();    
            #============== END PHP EXCEL ========
            exit;

        } else {
            exit('Gagal export data!');
        }
    }
}
?>