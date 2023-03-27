<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class NetworkExport implements FromCollection, WithHeadings
{
    private $filterUser;
    private $searchText;
    private $result = array();

    public function __construct($userId=null, $searchText=null)
    {
        $this->filterUser = $userId;
        $this->searchText = $searchText;
    }

    public function collection()
    {
        $query = User::query();

        if ($this->filterUser) {

            $searchTerms = $this->searchText ?? NULL;
            $freetext = explode(' ', $searchTerms);
            if ($searchTerms) {
                $user = User::find($this->filterUser);
                foreach ($freetext as $freetexts) {
                    $query->where('email', 'like', '%' . $freetexts . '%')
                        ->orWhere('name', 'like', '%' . $freetexts . '%');
                }
                $query->whereIn('id', $user->getChildrenIds())
                    ->take(1);
            } else {
                $query->where('id', '=', $this->filterUser);
            }

        } else {
            $query->where('role', User::ROLE_MEMBER);

            $searchTerms = $this->searchText ?? NULL;
            $freetext = explode(' ', $searchTerms);
            if ($searchTerms) {
                foreach ($freetext as $freetexts) {
                    $query->where('email', 'like', '%' . $freetexts . '%')
                        ->orWhere('name', 'like', '%' . $freetexts . '%');
                }
                $query->take(1);
            } else {
                $query->where('hierarchyList', NULL);
            }
        }

        $records = $query->get();
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
