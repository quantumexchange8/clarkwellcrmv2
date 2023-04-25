<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportWalletLogs implements FromCollection, WithHeadings
{
    private $query;

    public function __construct($query)
    {
        $this->query = $query;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $records = $this->query->get();
        $result = array();
        foreach($records as $record){
            $result[] = array(
                'name' => $record->user->name,
                'email' => $record->user->email,
                'balance' => number_format($record->user->wallet_balance, 2),
                'old_balance' => number_format($record->old_balance, 2),
                'new_balance' => number_format($record->new_balance, 2),
                'remark' => $record->remark,
                'date_submitted' => $record->created_at,
            );
        }

        return collect($result);
    }

    public function headings(): array
    {
        return [
            'Name',
            'Email',
            'Wallet Balance',
            'Old Balance',
            'New Balance',
            'Adjustment Remark',
            'Date Submitted'
        ];
    }
}
