<?php

namespace App\Exports;

use App\Models\Deposits;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

/**
    * @return \Illuminate\Support\Collection
    */
class ExportDeposits implements FromCollection, WithHeadings {
    private $query;

    public function __construct($query)
    {
        $this->query = $query;
    }
    public function collection()
    {

        $records = $this->query->get();
        $result = array();
        foreach($records as $deposits){
            $result[] = array(
                'name' => $deposits->user->name,
                'email' => $deposits->user->email,
                'upline_email' => $deposits->user->parent ? $deposits->user->parent->email : null,
                'broker' => $deposits->broker->name,
                'transaction_date' => Carbon::parse($deposits->transaction_at)->format('Y-m-d'),
                'amount' =>  number_format((float)$deposits->amount, 2, '.', ''),
                'type' => $deposits->type == Deposits::TYPE_DEPOSIT ? 'Deposit' : 'Withdrawal',
                'upload_date' => Carbon::parse($deposits->created_at)->format('Y-m-d'),
            );
        }

        return collect($result);

    }

    public function headings(): array
    {
        return [
            'Client Name',
            'Client Email',
            'Upline Email',
            'Broker',
            'Transaction Date',
            'Amount',
            'Type',
            'Uploaded Date',
        ];
    }
}
