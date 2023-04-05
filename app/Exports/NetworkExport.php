<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class NetworkExport implements FromCollection, WithHeadings
{
    private $result = array();
    private $query;

    public function __construct($query)
    {
        $this->query = $query;
    }

    public function collection()
    {
        $records = $this->query;
        foreach($records as $user) {
            $this->result[] = array(
                'name' => $user->name,
                'email' => $user->email,
                'upline' => $user->parent->email ?? NULL,
                'rank' => $user->rank->name,
                'wallet' => $user->wallet_balance,
                'personal_deposit' => number_format($user->personalDeposits(), 2),
                'group_deposit' =>  number_format($user->groupTotalDeposit(), 2),
                'downlines' =>  $user->getClientsCount(),
            );

            $chilren = $user->children;
            if ($chilren) {
                $this->getChildren($chilren);
            }
        }

        return collect($this->result);
    }

    public function getChildren($children)
    {
        foreach ($children as $child) {
            $this->result[] = array(
                'name' => $child->name,
                'email' => $child->email,
                'upline' => $child->parent->email ?? NULL,
                'rank' => $child->rank->name,
                'wallet' => $child->wallet_balance,
                'personal_deposit' => number_format($child->personalDeposits(), 2),
                'group_deposit' =>  number_format($child->groupTotalDeposit(), 2),
                'downlines' =>  $child->getClientsCount(),
            );
            $sub_children = $child->children;
            if ($sub_children) {
                $this->getChildren($sub_children);
            }
        }

    }

    public function headings(): array
    {
        return [
            'User Name',
            'User Email',
            'Upline User Email',
            'User Rank',
            'Wallet Balance',
            'Personal Deposit',
            'Group Deposit',
            'Direct Downlines',
        ];
    }
}
