<?php

namespace App\Exports;

use App\Models\User;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportUser implements FromCollection, WithHeadings
{
    private $query;

    public function __construct($query)
    {
        $this->query = $query;
    }

    public function collection()
    {
        $records = $this->query->get();
        $result = array();
        foreach($records as $user){
            $result[] = array(
                'name' => $user->name,
                'upline'=> $user->parent ? $user->parent->email : null,
                'first_leader'=> $user->getLeaders()['first_leader'],
                'top_leader'=> $user->getLeaders()['top_leader'],
                'rank' => $user->rank->name,
                'email' => $user->email,
                'contact' => $user->contact_number,
                'country' => $user->country,
                'status' => User::getUserStatus($user->status),
            );
        }

        return collect($result);

    }

    public function headings(): array
    {
        return [
            'Name',
            'Upline Email',
            'First Leader Email',
            'Top Leader Email',
            'Rank',
            'Email',
            'Contact',
            'Country',
            'Status',
        ];
    }
}
