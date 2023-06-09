<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class BonusHistories extends Model
{
    use HasFactory, Sortable;

    protected $table = 'bonus_history';
    protected $primaryKey = 'id';

    const CREATED_AT = 'created_at';
    protected $dateFormat = 'Y-m-d H:i:s';

    public $sortable = [
        'commission_lot',
        'bonus_amount',
        'downline_id',
        'brokersId',
        'status',
        'from_commissions_id',
        'created_at'
    ];

    public static function get_record($search)
    {
        $query = BonusHistories::sortable()
            ->with('commission')
            ->with('user')
            ->where('deleted_at', '=', null)
            ->whereHas('user', function ($query) {
                return $query->where('role', 1);
            });

        $search_text = @$search['freetext'] ?? NULL;
        $freetext = explode(' ', $search_text);

        if ($search_text) {
            foreach ($freetext as $freetexts) {
                $query->whereHas('commission', function ($q) use ($freetexts) {
                    $q->whereHas('user', function ($innerQ) use ($freetexts) {
                        $innerQ->where('email', 'like', '%' . $freetexts . '%')
                            ->orWhere('name', 'like', '%' . $freetexts . '%');
                    });
                });
            }
        }

        if (@$search['user_id']) {
            $users = User::find(@$search['user_id']);
            $users_id = $users->getChildrenIds();
            $query->where('upline_id', @$search['user_id'])->whereIn('downline_id', $users_id);
        }

        if (@$search['transaction_start'] && @$search['transaction_end']) {
            $start_date = Carbon::parse(@$search['transaction_start'])->startOfDay()->format('Y-m-d H:i:s');
            $end_date = Carbon::parse(@$search['transaction_end'])->endOfDay()->format('Y-m-d H:i:s');
            $query->whereBetween('created_at', [$start_date, $end_date]);
        }

        return $query->orderByDesc('created_at');
    }

    public static function get_commissions_table($search, $userId)
    {
        $query = BonusHistories::sortable()->with('commission')->with('user')->where('deleted_at', '=', null)->where('upline_id', $userId)->where('downline_id', '!=', $userId);
        $searchTerms = @$search['freetext'] ?? NULL;
        $freetext = explode(' ', $searchTerms);

        if($searchTerms){
            foreach($freetext as $freetexts) {
                $query->whereHas('user', function($query) use ($freetexts){
                    $query->where('email','like', '%' . $freetexts . '%')
                        ->orWhere('name','like', '%' . $freetexts . '%');
                });
            }

        }
        if (@$search['transaction_start'] && @$search['transaction_end']) {
            $start_date = Carbon::parse(@$search['transaction_start'])->startOfDay()->format('Y-m-d H:i:s');
            $end_date = Carbon::parse(@$search['transaction_end'])->endOfDay()->format('Y-m-d H:i:s');
            $query->whereHas('commission', function($q) use ($start_date, $end_date) {
                $q->whereBetween('transaction_at', [$start_date, $end_date]);
            });
        }

        return $query->orderbyDesc('created_at');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'downline_id', 'id')->where('role', 1);
    }
    public function commission()
    {
        return $this->belongsTo(Commissions::class, 'from_commissions_id', 'id');
    }

}
