<?php

namespace App\Exports;

use App\Models\Commissions;
use App\Models\Deposits;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportCommissions implements FromCollection, WithHeadings
{
    private $filterUser;
    private $searchText;

    private $startDate;
    private $filterBroker;
    private $filterChildren;

    private $endDate;


    public function __construct($userId=[], $searchText=null, $startDate=null, $filterBroker=null, $filterChildren=null, $endDate=null)
    {
        $this->filterUser = $userId;
        $this->searchText = $searchText;
        $this->startDate = $startDate;
        $this->filterBroker = $filterBroker;
        $this->filterChildren =  $filterChildren;
        $this->endDate = $endDate;
    }
    public function collection()
    {
        $query = DB::table('commissions')->addSelect('commissions.*')
            ->leftjoin('users','users.id','=','commissions.userId') ->addSelect('users.email as userEmail')
            ->leftjoin('brokers','brokers.id','=','commissions.brokersId')->addSelect('brokers.name as brokerName');

        if ($this->filterUser) {
            $query->whereIn('commissions.userId', $this->filterUser);
        }

        if ($this->filterBroker && $this->filterBroker != 'all') {
            $query->where('commissions.brokersId', $this->filterBroker);
        }

        if ($this->startDate && $this->endDate) {
            $start_date = Carbon::parse($this->startDate)->startOfDay()->format('Y-m-d H:i:s');
            $end_date = Carbon::parse($this->endDate)->endOfDay()->format('Y-m-d H:i:s');
            $query->whereBetween('commissions.transaction_at', [$start_date, $end_date]);
        }


        $search_text = $this->searchText ?? NULL;
        $freetext = explode(' ', $search_text);

        if($search_text){
            foreach($freetext as $freetexts) {
                $query->where('users.email', 'like', '%' . $freetexts . '%');
            }
        }

        if ($this->filterChildren) {
            $users = User::find($this->filterChildren);
            $users_id = [];
            if ($users) {
                $users_id[] = $users->id;
                $users_id = array_merge($users->getChildrenIds(), $users_id);
            }

            $query->whereIn('commissions.userId', $users_id);
        }


        $records = $query->whereNull('commissions.deleted_at')->orderBy('commissions.transaction_at', 'DESC')->get();

        $result = array();
        foreach($records as $commission){
            $result[] = array(
                'transaction_date' => Carbon::parse($commission->transaction_at)->format('Y-m-d H:i:s'),
                'lot_size' =>  number_format((float)$commission->lot_size, 2, '.', ''),
                'commissions' =>  number_format((float)$commission->commissions_amount, 2, '.', ''),
                'email' => $commission->userEmail,
                'broker' => $commission->brokerName,
                'upload_date' => Carbon::parse($commission->created_at)->format('Y-m-d H:i:s'),
            );
        }

        return collect($result);

    }

    public function headings(): array
    {
        return [
            'Transaction Date',
            'Lot Size',
            'Commissions Amount',
            'Client Email',
            'Broker',
            'Uploaded Date',
        ];
    }
}
