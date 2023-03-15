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
    private $filterUser;
    private $searchText;
    private $startDate;
    private $filterBroker;
    private $filterChildren;

    private $endDate;

    public function __construct($userId=[], $searchText=null,  $startDate=null, $filterBroker=null, $filterChildren=null, $endDate=null)
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
        $query = DB::table('deposits')->addSelect('deposits.*')
            ->leftjoin('users','users.id','=','deposits.userId') ->addSelect('users.email as userEmail')
            ->leftjoin('brokers','brokers.id','=','deposits.brokersId')->addSelect('brokers.name as brokerName');
        if ($this->filterUser) {
            $query->whereIn('deposits.userId', $this->filterUser);
        }
        if ($this->filterBroker && $this->filterBroker != 'all') {
            $query->where('deposits.brokersId', $this->filterBroker);
        }

        if ($this->startDate && $this->endDate) {
            $start_date = Carbon::parse($this->startDate)->startOfDay()->format('Y-m-d H:i:s');
            $end_date = Carbon::parse($this->endDate)->endOfDay()->format('Y-m-d H:i:s');
            $query->whereBetween('deposits.transaction_at', [$start_date, $end_date]);
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

            $query->whereIn('deposits.userId', $users_id);
        }

        $records = $query->whereNull('deposits.deleted_at')->orderBy('deposits.transaction_at', 'DESC')->get();

        $result = array();
        foreach($records as $deposits){
            $result[] = array(
                'transaction_date' => Carbon::parse($deposits->transaction_at)->format('Y-m-d H:i:s'),
                'amount' =>  number_format((float)$deposits->amount, 2, '.', ''),
                'email' => $deposits->userEmail,
                'broker' => $deposits->brokerName,
                'upload_date' => Carbon::parse($deposits->created_at)->format('Y-m-d H:i:s'),
            );
        }

        return collect($result);

    }

    public function headings(): array
    {
        return [
            'Transaction Date',
            'Amount',
            'Client Email',
            'Broker',
            'Uploaded Date',
        ];
    }
}
