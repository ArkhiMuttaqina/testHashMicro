<?php

namespace App\Helpers;

use Carbon\Carbon;
use DateTime;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;

class generalHelpers
{

    public static function formatRupiah($angka)
    {

        if ($angka != null || $angka != 0) {

            $rupiah = number_format($angka, 0, ',', '.');
            return "Rp $rupiah";
        } else {
            $rupiah = 0;
            return "Rp $rupiah";
        }
    }


    public static function RPtoNumber($stringRp)
    {

        try {
            $cleanString = str_replace(["Rp", "."], "", $stringRp);
            $angka = intval($cleanString);
            //$angka = floatval($cleanString);
        } catch (\Exception $e) {
            return false;
        }
        return $angka;
    }



    public static  function clearNumber($string)
    {
        $string = str_replace("Rp", "", $string);
        $string = str_replace(" ", "", $string);
        $string = str_replace(".", "", $string);
        $string = str_replace(" ", "", $string);
        $string = preg_replace('/[^0-9\+]/', '', $string);
        return $string;
    }


    public static  function encrypt($data)
    {
        $secret_key = $_ENV['APP_PASSPHRASE'];
        $base64_data = base64_encode($data);
        $reversed_data = strrev($base64_data);
        $encrypted_data = $secret_key . $reversed_data . $secret_key;
        return base64_encode($encrypted_data);
    }


    public static  function difMonth($date)
    {
        $tanggalAwal = Carbon::parse($date);
        $tanggalSekarang = Carbon::now();
        $selisihBulan = $tanggalAwal->diffInMonths($tanggalSekarang);
        return $selisihBulan;
    }

    public static  function leaveQuota($date)
    {
        $totalmonthsOfwork = self::difMonth($date);

        if ($totalmonthsOfwork >= 12) {
            $quotaLeave = 12;
        } else if ($totalmonthsOfwork > 6 && $totalmonthsOfwork < 12) {
            $quotaLeave = 6;
        } else {
            $quotaLeave = 0;
        }
        return $quotaLeave;
    }


    public static  function calculateDaysBetweenID($startDate, $endDate)
    {
        //REMAP
        $bulanIndoToEng = [
            'Januari' => 'January',
            'Februari' => 'February',
            'Maret' => 'March',
            'April' => 'April',
            'Mei' => 'May',
            'Juni' => 'June',
            'Juli' => 'July',
            'Agustus' => 'August',
            'September' => 'September',
            'Oktober' => 'October',
            'November' => 'November',
            'Desember' => 'December',
        ];
        foreach ($bulanIndoToEng as $indo => $eng) {
            $startDate = str_replace($indo, $eng, $startDate);
            $endDate = str_replace($indo, $eng, $endDate);
        }

        $start = Carbon::createFromFormat('d F Y', $startDate);
        $end = Carbon::createFromFormat('d F Y', $endDate);



        $selisihHari = $start->diffInDays($end) + 1;
        return $selisihHari;
    }

    public static function dateIDtoISO($dateString)
    {

        try {
            $mapping = [
                'Januari' => '01',
                'Februari' => '02',
                'Maret' => '03',
                'April' => '04',
                'Mei' => '05',
                'Juni' => '06',
                'Juli' => '07',
                'Agustus' => '08',
                'September' => '09',
                'Oktober' => '10',
                'November' => '11',
                'Desember' => '12',
            ];
            list($date, $monthName, $year) = explode(' ', $dateString);
            $month = $mapping[$monthName];
            $newDateString = "$year-$month-$date 00:00:00";
        } catch (\Exception $e) {
            return false;
        }
        return $newDateString;
    }


    public static function dMY_converter($tanggal)
    {
        try {
            $formattedDate = '-';
            $bulan = array(
                '01' => 'Jan',
                '02' => 'Feb',
                '03' => 'Mar',
                '04' => 'Apr',
                '05' => 'Mei',
                '06' => 'Jun',
                '07' => 'Jul',
                '08' => 'Agu',
                '09' => 'Sep',
                '10' => 'Okt',
                '11' => 'Nov',
                '12' => 'Des'
            );
            $dateObj = new DateTime($tanggal);
            $tanggal = $dateObj->format('d');
            $bulanIndex = $dateObj->format('m');
            $tahun = $dateObj->format('Y');
            $bulanString = $bulan[$bulanIndex];
            $formattedDate = $tanggal . ' ' . $bulanString . ' ' . $tahun;
            return $formattedDate;
        } catch (\Exception $e) {

            return '-';
        }
    }


}
