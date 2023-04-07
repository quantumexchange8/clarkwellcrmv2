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
    private $not_admin;

    public function __construct($query, $status=false)
    {
        $this->query = $query;
        $this->not_admin = $status;
    }

    public function collection()
    {
        $records = $this->query;
        if ($this->not_admin) {
            foreach($records as $user) {
                $this->result[] = array(
                    'name' => $user->name,
                    'email' => $user->email,
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
        } else {
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
        }

        return collect($this->result);
    }

    public function getChildren($children)
    {
        if ($this->not_admin) {
            foreach ($children as $child) {
                $this->result[] = array(
                    'name' => $child->name,
                    'email' => $child->email,
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
        } else {
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


    }

    public function headings(): array
    {
        if ($this->not_admin) {
            return [
                'User Name',
                'User Email',
                'User Rank',
                'Wallet Balance',
                'Personal Deposit',
                'Group Deposit',
                'Direct Downlines',
            ];
        } else {
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
}
