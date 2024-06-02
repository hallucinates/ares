<?php

namespace App;

use Cache;
use Arr;
use Jenssegers\Agent\Agent;
  
class Helper 
{
    public static function pengaturan($key)
    {
        static $pengaturan;

        if (is_null($pengaturan))
        {
            $pengaturan = Cache::remember('pengaturan', 24*60, function() {
                return Arr::pluck(\DB::table('pengaturan')->get()->toArray(), 'value', 'key');
            });
        }

        return (is_array($key)) ? array_only($pengaturan, $key) : $pengaturan[$key];
    }

    public static function isDevice()
    {
        $agent = new Agent();
        if ($agent->isMobile()) {
            return 'Mobile';
        } else if ($agent->isDesktop()) {
            return 'Desktop';
        } else {
            return 'unknown';
        }
    }

    public static function generatePesananKode()
    {
        return 'AP' . date('ymd') . mt_rand(100000, 999999);
    }

    public static function currency($angka) { 
        return 'Rp. '.number_format($angka, 0, ', ', '.');
    }

    public static function noWA($no_wa) {
        if (!preg_match("/[^+0-9]/",trim($no_wa))) {
            // cek apakah no hp karakter ke 1 dan 2 adalah angka 62
            if (substr(trim($no_wa), 0, 2) == '62') {
                $no_wa = trim($no_wa);
            }
            // cek apakah no hp karakter ke 1, 2 dan 3 adalah angka +62
            else if (substr(trim($no_wa), 0, 3) == '+62') {
                $no_wa = substr(trim($no_wa), 1);
            }
            // cek apakah no hp karakter ke 1 adalah angka 0
            else if (substr(trim($no_wa), 0, 1) == '0') {
                $no_wa = '62'.substr(trim($no_wa), 1);
            } else {
                $no_wa = '62'.trim($no_wa);
            }
        }
        
        return $no_wa;
    }

    public static function statusLayanan($value) { 
        switch ($value) {
            case 0:
                return '<span class="text-danger">Gangguan</span>';
                break;

            case 1:
                return '<span class="text-success">Normal</span>';
                break;
    
            default:
                return '<span class="text-dark">unknown</span>';
                break;
        }
    }

    public static function statusPesanan($status) { 
        switch ($status) {
            case 1:
                $data = [
                    'color'  => 'txt-primary',
                    'status' => 'Pending',
                    'icon'   => 'images/icon/pending.svg',
                    'ket'    => 'Menunggu Pembayaran',
                    'tr'     => 'Menunggu Pembayaran',
                    'note'   => 'Anda belum melakukan pembayaran, silahkan melakukan pembayaran untuk menyelesaikan transaksi, untuk pertanyaan, kritik atau saran bisa di sampaikan langsung melalui halaman kontak kami.',
                ];
                return $data;
                break;

            case 2:
                $data = [
                    'color'  => 'text-danger',
                    'status' => 'Canceled',
                    'icon'   => 'images/icon/cancel.svg',
                    'ket'    => 'Tidak Melakukan Pembayaran',
                    'tr'     => 'Transaksi Gagal',
                ];
                return $data;
                break;

            case 3:
                $data = [
                    'color'  => 'text-danger',
                    'status' => 'Canceled',
                    'icon'   => 'images/icon/cancel.svg',
                    'ket'    => 'Dibatalkan Oleh Sistem',
                    'tr'     => 'Transaksi Gagal',
                ];
                return $data;
                break;
            case 4:
                $data = [
                    'color'  => 'text-warning',
                    'status' => 'Processing',
                    'icon'   => 'images/icon/processing.svg',
                    'ket'    => 'Sudah Dibayarkan',
                    'tr'     => 'Transaksi Dibayar',
                ];
                return $data;
                break;

            case 5:
                $data = [
                    'color'  => 'text-warning',
                    'status' => 'Processing',
                    'icon'   => 'images/icon/processing.svg',
                    'ket'    => 'Pesanan Sedang Diproses',
                    'tr'     => 'Transaksi Diproses',
                ];
                return $data;
                break;

            case 6:
                $data = [
                    'color'  => 'text-success',
                    'status' => 'Success',
                    'icon'   => 'images/icon/success.svg',
                    'ket'    => 'Pesanan Berhasil',
                    'tr'     => 'Transaksi Berhasil',
                    'note'   => 'Terimakasih telah melakukan transaksi di '.Helper::pengaturan('nama').'.',
                ];
                return $data;
                break;

            case 7:
                $data = [
                    'color'  => 'text-success',
                    'status' => 'Success (Partial)',
                    'icon'   => 'images/icon/success.svg',
                    'ket'    => 'Pesanan Berhasil (Sebagian)',
                    'tr'     => 'Transaksi Berhasil (Sebagian)',
                    'note'   => 'Terimakasih telah melakukan transaksi di '.Helper::pengaturan('nama').'.',
                ];
                return $data;
                break;

            default:
                $data = [
                    'color'  => 'text-dark',
                    'status' => 'unknown',
                    'icon'   => 'images/icon/unknown.svg',
                    'ket'    => 'unknown',
                    'tr'     => 'unknown',
                    'note'   => 'unknown',
                ];
                return $data;
                break;
        }
    }

    public static function number($angka) { 
        return number_format($angka, 0, ',', '.');
    }

    public static function stringToSecret($string) { 
        if (!$string) {
            return NULL;
        }
        $length = strlen($string);
        $visibleCount = (int) round($length / 6);
        $hiddenCount = $length - ($visibleCount * 2);
        return substr($string, 0, $visibleCount) . str_repeat('*', $hiddenCount) . substr($string, ($visibleCount * -1), $visibleCount);
    }

    public static function tanggalIndo($tanggal, $cetak_hari = 0) {
        $tanggal = substr($tanggal, 0, 10);

        $hari = array( 
            1 => 'Senin',
            'Selasa',
            'Rabu',
            'Kamis',
            'Jum`at',
            'Sabtu',
            'Minggu'
        );
                
        $bulan = array(
            1 => 'Jan',
            'Feb',
            'Mar',
            'Apr',
            'Mei',
            'Jun',
            'Jul',
            'Agu',
            'Sep',
            'Okt',
            'Nov',
            'Des'
        );

        $split    = explode('-', $tanggal);
        $tgl_indo = $split[2] . ' ' . $bulan[ (int)$split[1] ] . ' ' . substr($split[0], 2, 2);
        
        if ($cetak_hari == 1) {
            $num = date('N', strtotime($tanggal));
            return $hari[$num] . ', ' . $tgl_indo;
        } else if ($cetak_hari == 2) {
            $num = date('N', strtotime($tanggal));
            return $hari[$num];
        }

        return $tgl_indo;
    }

    public static function tanggalIndoWithJam($tanggal) {
        $jam     = substr($tanggal, 11, 8);
        $tanggal = substr($tanggal, 0, 10);
                
        $bulan = array(
            1 => 'Jan',
            'Feb',
            'Mar',
            'Apr',
            'Mei',
            'Jun',
            'Jul',
            'Agu',
            'Sep',
            'Okt',
            'Nov',
            'Des'
        );

        $split    = explode('-', $tanggal);
        $tgl_indo = $split[2] . ' ' . $bulan[ (int)$split[1] ] . ' ' . substr($split[0], 2, 2) . ' ' . $jam;

        return $tgl_indo;
    }
}