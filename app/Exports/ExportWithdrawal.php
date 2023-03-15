<?php

namespace App\Exports;

use App\Models\User;
use App\Models\Withdrawals;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportWithdrawal implements FromCollection, WithHeadings
{
    private $filterUser;
    private $filterStatus;
    private $startDate;
    private $filterSearch;
    private $filterChildren;
    private $endDate;

    public function __construct($userId=null, $filterStatus=null, $startDate=null, $filterSearch=null, $filterChildren=null, $endDate=null)
    {
        $this->filterUser = $userId;
        $this->filterStatus = $filterStatus;
        $this->startDate = $startDate;
        $this->filterSearch = $filterSearch;
        $this->filterChildren =  $filterChildren;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        $query = Withdrawals::query();

        if ($this->filterUser) {
            $query->where('requested_by_user', '=', $this->filterUser);
        } else {
            $query->with('user');
        }

        if ($this->filterStatus  && $this->filterStatus != 'all') {
            $query->where('status', '=', $this->filterStatus);
        }

        if ($this->startDate && $this->endDate) {
            $start_date = Carbon::parse($this->startDate)->startOfDay()->format('Y-m-d H:i:s');
            $end_date = Carbon::parse($this->endDate)->endOfDay()->format('Y-m-d H:i:s');
            $query->whereBetween('created_at', [$start_date, $end_date]);
        }

        $searchTerms =  $this->filterSearch ?? NULL;
        $freetext = explode(' ', $searchTerms);

        if($searchTerms){
            foreach($freetext as $freetexts) {
                $query->whereHas('user', function($query) use ($freetexts){
                    $query->where('email','like', '%' . $freetexts . '%');
                });
            }

        }
        if ($this->filterChildren) {
            $users = User::find($this->filterChildren);
            $users_id = [];
            if ($users) {
                $users_id[] = $users->id;
                $users_id = array_merge($users->getChildrenIds(), $users_id);
            }

            $query->whereIn('requested_by_user', $users_id);
        }

        $records = $query->orderBy('created_at', 'DESC')->get();
        $result = array();
        if ($this->filterUser) {
            foreach($records as $withdrawal){
                $result[] = array(
                    'requested_date' => Carbon::parse($withdrawal->created_at)->format('Y-m-d H:i:s'),
                    'wallet_type' =>  $withdrawal->getNetwork(),
                    'address' => $withdrawal->address,
                    'amount' => number_format((float)$withdrawal->amount, 2, '.', ''),
                    'transaction_fee' => $withdrawal->transaction_fee,
                    'status'=> Withdrawals::getApprovalStatus($withdrawal->status),
                );
            }

        } else {
            foreach($records as $withdrawal){
                $result[] = array(
                    'user_name' =>  $withdrawal->user->name,
                    'user_upline_email' =>  $withdrawal->user->parent->email,
                    'user_email' =>  $withdrawal->user->email,
                    'requested_date' => Carbon::parse($withdrawal->created_at)->format('Y-m-d H:i:s'),
                    'amount' => number_format((float)$withdrawal->amount, 2, '.', ''),
                    'wallet_type' =>  $withdrawal->getNetwork(),
                    'status'=> Withdrawals::getApprovalStatus($withdrawal->status),
                );
            }
        }

        return collect($result);
    }

    public function headings(): array
    {
        $heading = array();
        if ($this->filterUser) {
            $heading =   [
                'Requested Date',
                'Wallet Type',
                'Address',
                'Amount',
                'Transaction Fee (%)',
                'Status',
            ];
        }
        else {
            $heading =   [
                'User Name',
                'User Email',
                'Requested Date',
                'Amount',
                'Wallet Type',
                'Status',
            ];

        }
        return  $heading;
    }
}
