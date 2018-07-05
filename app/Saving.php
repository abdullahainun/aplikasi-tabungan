<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Saving extends Model
{
    public function student() {
    	return $this->belongsTo('App\Student');
    }

    public function transactions() {
    	return $this->hasMany('App\Transaction');
    }

    public function getTotalMasuk($id) {
        $totalMasuk = DB::table('transactions')
            ->where([
                ['student_id', $id],
                ['type', 1]                
            ])->sum('amount');
        if (empty($totalMasuk)) {
            return 0;
        }
        return $totalMasuk;
    }
    // new gettotalmasuk
    public function getTotalMasukBy($id, $start, $end) {
        $dateStart = base64_decode($start).' 00:00:00'; //need a space after dates.
        $dateEnd = base64_decode($end). ' 23:59:00';

        $totalMasuk = DB::table('transactions')
            ->where([
                ['student_id', $id],
                ['type', 1],
            ])
            ->whereBetween('created_at', array($dateStart, $dateEnd))
            ->sum('amount');
        if (empty($totalMasuk)) {
            return 0;
        }
        return $totalMasuk;
    }

    public function getTotalKeluar($id) {
        $totalKeluar = DB::table('transactions')
            ->where([
                ['student_id', $id],
                ['type', 0],
            ])
            ->sum('amount');
        if (empty($totalKeluar)) {
            return 0;
        }
        return $totalKeluar;
    }

    // get total keluar by
    public function getTotalKeluarBy($id, $start, $end) {
        $dateStart = base64_decode($start).' 00:00:00'; //need a space after dates.
        $dateEnd = base64_decode($end). ' 23:59:00';

        $totalKeluar = DB::table('transactions')
            ->where([
                ['student_id', $id],
                ['type', 0],
            ])
            ->whereBetween('created_at', array($dateStart, $dateEnd))            
            ->sum('amount');
        if (empty($totalKeluar)) {
            return 0;
        }
        return $totalKeluar;
    }

    public function getTotalSaldo($id) {
        $totalSaldo = $this->getTotalMasuk($id) - $this->getTotalKeluar($id);
        if (empty($totalSaldo)) {
            return 0;
        }
        return $totalSaldo;
    }

    // new get total saldo by
    public function getTotalSaldoBy($id, $start, $end) {
        $dateStart = base64_decode($start).' 00:00:00'; //need a space after dates.
        $dateEnd = base64_decode($end) . ' 23:59:00';

        $totalSaldo = $this->getTotalMasukBy($id, $start, $end) - $this->getTotalKeluarBy($id, $start, $end);
        if (empty($totalSaldo)) {
            return 0;
        }
        return $totalSaldo;
    }

    // mencari terakhir transaksi
    public function getLatestTransaction($id){
        $latest = DB::table('transactions')
            ->where('student_id', $id)
            ->latest('updated_at')
            ->first();
        if (empty($latest)) {
            return 0;
        }
        return $latest->updated_at;
    }
}
