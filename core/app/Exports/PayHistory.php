<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use App\Models\PayLoanHistory;
use App\Models\Loan;
use Illuminate\Contracts\View\View;

class PayHistory implements FromView
{
    protected $id;
    
    public function __construct($id)
    {
        // parent::__construct();
        $this->id = $id;
    }
    


    public function view(): View
    {
        $data['pay_loan'] = PayLoanHistory::where([
            ['id_loan', $this->id]
        ])->orderBy('created_at', 'ASC')->get();

        $data['loan_payed'] = PayLoanHistory::selectRaw('SUM(amount) as total')->where([
            ['id_loan', $this->id]
        ])->first();
        
        $data['loan'] = Loan::whereId($this->id)->first();
        return view('admin/loan/print_monitoring', $data);
    }
}
