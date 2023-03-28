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
class ExportPerformanceBonus implements FromCollection, WithHeadings {
    private $query;

    public function __construct($query)
    {
        $this->query = $query;
    }
    public function collection()
    {

        $records = $this->query->get();
        $result = array();
        foreach($records as $record){
            $result[] = array(
                'user_name' => $record->downline->name,
                'user_rank' => $record->downline->rank->name,
                'upline_name' => $record->upline->name,
                'upline_rank' => $record->upline->rank->name,
                'commission_amount' => $record->commission_amount,
                'bonus' => $record->bonus_percentage,
                'bonus_amount' => $record->bonus_amount,
                'status' => $record->is_claimed,
                'date_submitted' => $record->created_at,
            );
        }

        return collect($result);

    }

    public function headings(): array
    {
        return [
            'Client Name',
            'Client Rank',
            'Upline Name',
            'Upline Rank',
            'Commission Amount',
            'Bonus (%)',
            'Bonus Amount',
            'Status',
            'Date Submitted',
        ];
    }
}
