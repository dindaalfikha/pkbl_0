<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use App\Models\PayLoanHistory;
use App\Models\Loan;
use App\Models\Unit;
use App\Models\Usaha;
use App\Models\JenisUsaha;
use Illuminate\Contracts\View\View;

class Monitoring implements FromView
{
    // protected $id;
    
    // public function __construct($id)
    // {
    //     // parent::__construct();
    //     $this->id = $id;
    // }

    public function view(): View
    {
        $data['loan'] = Loan::join('users', 'loan.user_id', '=', 'users.id')->groupBy('users.id')->get();
        $data['unit'] = [];
        $unitList = Unit::get();
        $jenisUsaha = JenisUsaha::get();
        $sektorUsaha = Usaha::get();
        foreach ($unitList as $key => $value) {
            $data['unit'][$value->id] = $value->nama;
        }

        foreach ($jenisUsaha as $key => $value) {
            $data['jenis_usaha'][$value->id] = $value->nama;
        }

        foreach ($sektorUsaha as $key => $value) {
            $data['sektor_usaha'][$value->id] = $value->nama;
        }

        return view('admin/user/print_monitoring', $data);
    }
}
