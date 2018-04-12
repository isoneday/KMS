<?php

/**
 * GT_Formater
 * 
 * Class used for manipulating view for an input such as date, number based on setting  
 * 
 * @author Agung Puji Mustofa, agungpm_ti -at- yahoo.com
 * @package general
 * @version $Id: GT_Formater.class.php 0001 2012-06-12 12:22:00 $
 */
class GT_Formater {

    /**
     * __construct(): constructor function
     *
     */
    function __construct() {
        // no nothings
    }

    /**
     * formatNumber(): function to format number if decimal means there will be 2 digit coma
     *
     * @param  integer/float input number can be integer or float value
     * @param  string define format, it based on language such as id (indonesian), us (united state)
     * @param  boolean 1 = integer value, 0 = float value
     * @return string $result
     */
    function formatNumber($number, $format, $is_integer = 0) {
        if ($is_integer == 1) {
            switch ($format) {
                case 'id' :
                    $result = number_format($number, 0, ',', '.');
                    break;
                case 'en' :
                    $result = number_format($number, 0, '.', ',');
                    break;
            }
        } else {
            switch ($format) {
                case 'id' :
                    $result = number_format($number, 2, ',', '.');
                    break;
                case 'en' :
                    $result = number_format($number, 2, '.', ',');
                    break;
            }
        }

        return $result;
    }

    /**
     * formatNumberThousand(): function to format number if decimal means there will be 2 digit coma
     * Nominal / 1000
     * @param  integer/float input number can be integer or float value
     * @param  string define format, it based on language such as id (indonesian), us (united state)
     * @param  boolean 1 = integer value, 0 = float value
     * @return string $result
     */
    function formatNumberThousand($number, $format, $is_integer = 0) {
        if ($number) {
            $number = round(($number / 1000), 0, PHP_ROUND_HALF_UP);
        }
        if ($is_integer == 1) {
            switch ($format) {
                case 'id' :
                    $result = number_format($number, 0, ',', '.');
                    break;
                case 'en' :
                    $result = number_format($number, 0, '.', ',');
                    break;
            }
        } else {
            switch ($format) {
                case 'id' :
                    $result = number_format($number, 2, ',', '.');
                    break;
                case 'en' :
                    $result = number_format($number, 2, '.', ',');
                    break;
            }
        }

        return $result;
    }

    /**
     * formatNumberThousandExcel(): function to format number if decimal means there will be 2 digit coma
     * Nominal / 1000
     * @param  integer/float input number can be integer or float value
     * @param  string define format, it based on language such as id (indonesian), us (united state)
     * @param  boolean 1 = integer value, 0 = float value
     * @return string $result
     */
    function formatNumberThousandExcel($number, $format = 1000) {
        if ($number) {
            $number = round(($number / $format), 0, PHP_ROUND_HALF_UP);
        }

        return $number;
    }

    /**
     * unformatNumber(): function to unformat formated number
     *
     * @param  integer/float input number can be integer or float value
     * @param string define format, it based on language such as id (indonesian), us (united state)
     * @return string $result
     */
    function unformatNumber($number, $format) {
        switch ($format) {
            case 'id' :
                $result = str_replace(',', '.', str_replace('.', '', $number));
                break;
            case 'en':
                $result = str_replace(',', '', $number);
                break;
        }

        return $result;
    }

    /**
     * getThousandSeparator(): function to get separator between 3 digit on number, example : 1.000.000 or 1,000,000
     *
     * @param string define format, it based on language such as id (indonesian), us (united state)
     * @return string $result
     */
    function getThousandSeparator($format) {
        switch ($format) {
            case 'id' :
                $result = '.';
                break;
            case 'en' :
                $result = ',';
                break;
        }

        return $result;
    }

    /**
     * getDecimalSeparator(): function to get decimal separator on last number ex: 1.000,00 or 1,000.00
     *
     * @params string define format, it based on language such as id (indonesian), us (united state)
     * @return string $result
     */
    function getDecimalSeparator($format) {
        switch ($format) {
            case 'id' :
                $result = ',00';
                break;
            case 'en' :
                $result = '.00';
                break;
        }

        return $result;
    }

    /**
     * dateFormat(): function to format date to user prespective view
     *
     * @param  string input date value, default input YYYY-MM-DD
     * @params string define format, it based on language such as id (indonesian), en (united state), ue = europa
     * @return string $result
     */
    function dateFormat($date, $format, $default = 'YYYY-MM-DD') {
        switch ($default) {
            case 'YYYY-MM-DD' :
                $arr_date = explode('-', $date);
                break;
            case 'DD-MM-YYYY':
                $date = explode('-', $date);
                $arr_date = $date;
                $arr_date[2] = $date[0];
                $arr_date[0] = $date[2];
                break;
            case 'YYYY/MM/DD':
                $arr_date = explode('/', $date);
                break;
            case 'DD/MM/YYYY':
                $date = explode('/', $date);
                $arr_date = $date;
                $arr_date[2] = $date[0];
                $arr_date[0] = $date[2];
                break;
        }

        if ($format == 'id') {
            $month = array(
                '00' => '',
                '01' => 'Januari',
                '02' => 'Februari',
                '03' => 'Maret',
                '04' => 'April',
                '05' => 'Mei',
                '06' => 'Juni',
                '07' => 'Juli',
                '08' => 'Agustus',
                '09' => 'September',
                '10' => 'Oktober',
                '11' => 'November',
                '12' => 'Desember'
            );

            $result = $arr_date[2] . ' ' . $month[$arr_date[1]] . ' ' . $arr_date[0];
        } else if ($format == 'en') {
            $month = array(
                '00' => '',
                '01' => 'January',
                '02' => 'February',
                '03' => 'March',
                '04' => 'April',
                '05' => 'May',
                '06' => 'June',
                '07' => 'July',
                '08' => 'August',
                '09' => 'September',
                '10' => 'October',
                '11' => 'November',
                '12' => 'December'
            );

            $result = $month[$arr_date[1]] . ' ' . $arr_date[2] . 'th ' . $arr_date[0];
        } else {
            $month = array(
                '00' => '',
                '01' => 'January',
                '02' => 'February',
                '03' => 'March',
                '04' => 'April',
                '05' => 'May',
                '06' => 'June',
                '07' => 'July',
                '08' => 'August',
                '09' => 'September',
                '10' => 'October',
                '11' => 'November',
                '12' => 'December'
            );

            $result = $arr_date[2] . ' ' . $month[$arr_date[1]] . ' ' . $arr_date[0];
        }

        return $result;
    }

    function getMonthCombo() {
        $month = array(
            0 => array(
                'id' => '1',
                'name' => GtfwLangText('January')
            ),
            1 => array(
                'id' => '2',
                'name' => GtfwLangText('February')
            ),
            2 => array(
                'id' => '3',
                'name' => GtfwLangText('March')
            ),
            3 => array(
                'id' => '4',
                'name' => GtfwLangText('April')
            ),
            4 => array(
                'id' => '5',
                'name' => GtfwLangText('May')
            ),
            5 => array(
                'id' => '6',
                'name' => GtfwLangText('June')
            ),
            6 => array(
                'id' => '7',
                'name' => GtfwLangText('July')
            ),
            7 => array(
                'id' => '8',
                'name' => GtfwLangText('August')
            ),
            8 => array(
                'id' => '9',
                'name' => GtfwLangText('September')
            ),
            9 => array(
                'id' => '10',
                'name' => GtfwLangText('October')
            ),
            10 => array(
                'id' => '11',
                'name' => GtfwLangText('November')
            ),
            11 => array(
                'id' => '12',
                'name' => GtfwLangText('December')
            ),
        );

        return $month;
    }

    function getYearCombo($start, $end) {
        $year = array();
        $j = 0;
        for ($i = $start; $i <= $end; $i++) {
            $year[$j] = array(
                'id' => $i,
                'name' => $i
            );
            $j++;
        }
        return $year;
    }

    function getWeekCombo() {
        $week = array(
            0 => array(
                'id' => 1,
                'name' => 1
            ),
            1 => array(
                'id' => 2,
                'name' => 2
            ),
            2 => array(
                'id' => 3,
                'name' => 3
            ),
            3 => array(
                'id' => 4,
                'name' => 4
            ),
            4 => array(
                'id' => 5,
                'name' => 5
            )
        );

        return $week;
    }

    function dateShortFormat($date, $format, $default = 'YYYY-MM-DD') {
        switch ($default) {
            case 'YYYY-MM-DD' :
                $arr_date = explode('-', $date);
                break;
            case 'DD-MM-YYYY':
                $date = explode('-', $date);
                $arr_date = $date;
                $arr_date[2] = $date[0];
                $arr_date[0] = $date[2];
                break;
            case 'YYYY/MM/DD':
                $arr_date = explode('/', $date);
                break;
            case 'DD/MM/YYYY':
                $date = explode('/', $date);
                $arr_date = $date;
                $arr_date[2] = $date[0];
                $arr_date[0] = $date[2];
                break;
        }

        if ($format == 'id') {
            $month = array(
                '00' => '',
                '01' => '01',
                '02' => '02',
                '03' => '03',
                '04' => '04',
                '05' => '05',
                '06' => '06',
                '07' => '07',
                '08' => '08',
                '09' => '09',
                '10' => '10',
                '11' => '11',
                '12' => '12'
            );

            $result = $arr_date[2] . '-' . $month[$arr_date[1]] . '-' . $arr_date[0];
        } else if ($format == 'en') {
            $month = array(
                '00' => '',
                '01' => '01',
                '02' => '02',
                '03' => '03',
                '04' => '04',
                '05' => '05',
                '06' => '06',
                '07' => '07',
                '08' => '08',
                '09' => '09',
                '10' => '10',
                '11' => '11',
                '12' => '12'
            );

            $result = $month[$arr_date[1]] . '-' . $arr_date[2] . '-' . $arr_date[0];
        } else {
            $month = array(
                '00' => '',
                '01' => '01',
                '02' => '02',
                '03' => '03',
                '04' => '04',
                '05' => '05',
                '06' => '06',
                '07' => '07',
                '08' => '08',
                '09' => '09',
                '10' => '10',
                '11' => '11',
                '12' => '12'
            );

            $result = $arr_date[2] . '-' . $month[$arr_date[1]] . '-' . $arr_date[0];
        }

        return $result;
    }

}

?>