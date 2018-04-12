<?php

function IndonesianDate($date) {
    if ($date AND $date !== '0000-00-00' AND $date !== '9999-12-31') {
        $date = date('Y-m-d', strtotime($date));
        $date_data = explode("-", $date);
        $hari = $date_data[2];
        $bulan = $date_data[1];
        $tahun = $date_data[0];

        $bulan_data = array('01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April', '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus', '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember');
        return $hari . ' ' . $bulan_data[$bulan] . ' ' . $tahun;
    }
}

/**
 * get human relative time to current time
 * contoh 1 jam 15 menit 10 detik yang lalu, kemarin, 3 hari yang lalu dsb
 * @param int timestamp
 * @return string teks
 */
function humanRelativeTime($timestamp) {
    $lang = GtfwLang()->GetLangCode();
    $difference = time() - $timestamp;

    $periods = array(
        GtfwLangText("second"),
        GtfwLangText("minute"),
        GtfwLangText("hour"),
        GtfwLangText("day"),
        GtfwLangText("week"),
        GtfwLangText("month"),
        GtfwLangText("year"),
        GtfwLangText("decade"),
    );
    $lengths = array(
        "60",
        "60",
        "24",
        "7",
        "4.35",
        "12",
        "10"
    );

    if ($difference > 0) { // this was in the past
        $mode = 'past';
        $ending = GtfwLangText('ago');
    } else { // this was in the future
        $mode = 'future';
        $difference = -$difference;
        $ending = GtfwLangText('to_go');
    }

    $counter = 1;
    for ($j = 0; $difference >= $lengths[$j]; $j++) {
        $difference /= $lengths[$j];
        $counter++;
    }

    if ($j == 3 and $difference == 1) {
        switch ($mode) {
            case 'past':
                $text = GtfwLangText('yesterday');
                break;
            case 'future':
                $text = GtfwLangText('tomorrow');
                break;
        }
    } else {
        if ($difference != 1 and $lang == 'en')
            $periods[$j] .= "s";
        $text = floor($difference) . " " . $periods[$j];

        $whole = floor($difference);
        $fractions = $difference - $whole;

        switch ($counter) {
            case 3:
                $text .= ' ' . floor($fractions * 60) . ' ' . $periods[1];
                $fractions = ($fractions * 60) - floor($fractions * 60);
            case 2:
                $text .= ' ' . floor($fractions * 60) . ' ' . $periods[0];
                break;
        }

        $text .= ' ' . $ending;
    }
    return $text;
}

/**
 * generate tanggal-tanggal dari tanggal awal sampai akhir
 * 
 * @param string tanggal awal dalam format apapun
 * @param string tanggal akhir dalam format apapun
 * @return array of tanggal
 */
function getDatesBetween($start_date, $end_date, $format = 'Y-m-d') {
    $start_date = is_int($start_date) ? $start_date : strtotime($start_date);
    $end_date = is_int($end_date) ? $end_date : strtotime($end_date);
    if ($end_date > $start_date) {
        $test_date = $start_date;
        $day_incrementer = 1;

        $dates[] = date($format, $start_date);

        do {
            $test_date = $start_date + ($day_incrementer * 60 * 60 * 24);
            $dates[] = date($format, $test_date);
        } while ($test_date < $end_date && ++$day_incrementer);
    } else {
        $dates[] = date($format, $start_date);
    }

    return $dates;
}

/**
 * mendapatkan nama bulan saja
 * 
 */
function getMonthName($month) {
    $month = intval($month);
    switch ($month) {
        case 1:
            $StrResult = "Januari";
            break;
        case 2:
            $StrResult = "Februari";
            break;
        case 3:
            $StrResult = "Maret";
            break;
        case 4:
            $StrResult = "April";
            break;
        case 5:
            $StrResult = "Mei";
            break;
        case 6:
            $StrResult = "Juni";
            break;
        case 7:
            $StrResult = "Juli";
            break;
        case 8:
            $StrResult = "Agustus";
            break;
        case 9:
            $StrResult = "September";
            break;
        case 10:
            $StrResult = "Oktober";
            break;
        case 11:
            $StrResult = "November";
            break;
        case 12:
            $StrResult = "Desember";
            break;
    } //end switch
    return $StrResult;
}