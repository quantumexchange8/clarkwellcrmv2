<?php

namespace App\Exports;

use App\Models\User;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportUser implements FromCollection, WithHeadings
{
    private $filterUser;
    private $searchText;
    private $startDate;
    private $endDate;

    public function __construct($userId=null, $searchText=null, $startDate=null, $endDate=null)
    {
        $this->filterUser = $userId;
        $this->searchText = $searchText;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        $query = User::query()->where('role', User::ROLE_MEMBER);

        if ($this->filterUser) {
            $query->where('id', '=', $this->filterUser);
        }

        $search_text = $this->searchText ?? NULL;
        $freetext = explode(' ', $search_text);

        if($search_text){
            foreach($freetext as $freetexts) {
                $query->where(function ($q) use ($freetexts) {
                    $q->where('email', 'like', '%' . $freetexts . '%');
                });
            }
        }

        if ($this->startDate && $this->endDate) {
            $start_date = Carbon::parse($this->startDate)->startOfDay()->format('Y-m-d H:i:s');
            $end_date = Carbon::parse($this->endDate)->endOfDay()->format('Y-m-d H:i:s');
            $query->whereBetween('created_at', [$start_date, $end_date]);
        }

        $records = $query->get();
        $result = array();
        foreach($records as $user){
            $result[] = array(
                'name' => $user->name,
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
            'Rank',
            'Email',
            'Contact',
            'Country',
            'Status',
        ];
    }
}
