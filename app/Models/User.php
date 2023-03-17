<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Kyslik\ColumnSortable\Sortable;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable, SoftDeletes, Sortable;

    //use status section
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 2;
    const STATUS_SUSPENDED = 3;
    //user role section
    const ROLE_MEMBER = 1;
    const ROLE_ADMIN = 2;
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public $sortable = [
        'name',
        'email',
        'contact_number',
        'country',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'wallet_balance' => 'decimal:2',
        'auto_rank_up' => 'boolean',
    ];

    public function setReferralId()
    {
        $temp_code = substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVXYZabcdefghijklmnopqrstuvwxyz"), 0, 10 - strlen((string)$this->id));
        $this->referral_id = $temp_code. $this->id;
        $this->save();
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }


    public static function getActiveUsersCount()
    {
        $count = self::where('status', self::STATUS_ACTIVE)->where('role', self::ROLE_MEMBER)->count();

        return $count;
    }

    /**
     *   Return list of status codes and labels
     * @return array
     */
    public static function listUserStatus()
    {
        return [
            self::STATUS_ACTIVE => 'Active',
            self::STATUS_INACTIVE => 'Inactive',
            self::STATUS_SUSPENDED => 'Suspended'
        ];
    }

    /**
     *   Return list of status codes and labels
     * @return array
     */
    public static function listRole()
    {
        return [
            self::ROLE_MEMBER    => 'member',
            self::ROLE_ADMIN => 'Admin',
        ];
    }

    public static function get_record($search, $perpage)
    {
        $query = User::sortable()->where('role', 1);

        $search_text = @$search['freetext'] ?? NULL;
        $freetext = explode(' ', $search_text);

        if($search_text){
            foreach($freetext as $freetexts) {
                $query->where(function ($q) use ($freetexts) {
                    $q->where('email', 'like', '%' . $freetexts . '%');
                });
            }
        }

        if (@$search['created_start'] && @$search['created_end']) {
            $start_date = Carbon::parse(@$search['created_start'])->startOfDay()->format('Y-m-d H:i:s');
            $end_date = Carbon::parse(@$search['created_end'])->endOfDay()->format('Y-m-d H:i:s');
            $query->whereBetween('created_at', [$start_date, $end_date]);
        }

        return $query->orderbyDesc('created_at')->paginate($perpage);
    }

    public function getClientsCount()
    {
        $clients = $this->children()->count();

        return $clients;
    }

    public function getDownlinesCount()
    {
        $downlines = count($this->getChildrenIds());

        return $downlines;
    }

    public function getChildrenIds()
    {
        $users = User::query()->where('hierarchyList', 'like', '%-' . $this->id . '-%')
            ->where('status', self::STATUS_ACTIVE)
            ->pluck('id')->toArray();

        return $users;
    }

    public function groupTotalDeposit()
    {
        $users =$this->getChildrenIds();
        $group_deposit = Deposits::whereIn('userId', $users)->where('type', Deposits::TYPE_DEPOSIT)->sum('amount');
        $group_deposit_with= Deposits::whereIn('userId', $users)->where('type', Deposits::TYPE_WITHDRAW)
            ->where('status', Deposits::STATUS_APPROVED)
            ->sum('amount');
        $underlineTotal = $group_deposit - $group_deposit_with;
        $result = $underlineTotal + $this->personalDeposits();
        return $result;
    }
    public function groupDepositsByBrokers()
    {
        $users = User::query()->where('hierarchyList', 'like', '%-' . $this->id . '-%')->get();
        for ($i = 0; $i < count($users); $i++) {
            $users[$i]->total = $users[$i]->personalDeposits();
            $users[$i]->deposits = $users[$i]->personalDepositsByBrokers()->toArray();
        }
        return $users->sortBy('total', SORT_REGULAR, true);
    }
    public function personalDepositsByBrokers()
    {
        $dep_type = Deposits::TYPE_DEPOSIT;
        $with_type = Deposits::TYPE_WITHDRAW;
        $status = Deposits::STATUS_APPROVED;
        $brokers = $this->deposits()->with('broker')
            ->select('brokersId',
                DB::raw("sum(CASE WHEN type = $dep_type THEN amount END) as dep_amount"),
                DB::raw("sum(CASE WHEN type = $with_type AND status = $status THEN amount END) as with_total"),
            )
            ->groupBy('brokersId')->get();
        foreach($brokers as $broker) {
            $broker->amount = $broker->dep_amount - $broker->with_total;
        }
        return $brokers->sortBy('amount', SORT_REGULAR, true);
    }
    public function personalDeposits()
    {
        $personal_deposit = $this->deposits()->where('type', Deposits::TYPE_DEPOSIT)->sum('amount');
        $personal_withdrawed_deposit = $this->deposits()
            ->where('type', Deposits::TYPE_WITHDRAW)
            ->where('status', Deposits::STATUS_APPROVED)
            ->sum('amount');

        return $personal_deposit - $personal_withdrawed_deposit;
    }


    public function personalCommissions()
    {
        return $this->commissions()->sum('commissions_amount');
    }

    public function groupTotalCommissions()
    {
        $users = $this->getChildrenIds();
        $underlineTotal = Commissions::whereIn('userId', $users)->sum('commissions_amount');
        $result = $underlineTotal + $this->personalCommissions();
        return $result;
    }

    public function getRole()
    {
        $temp_role = self::listRole();
        return $temp_role[$this->role];
    }

    public static function getUserStatus($status)
    {
        switch( $status) {
            case self::STATUS_ACTIVE:
                return 'Active';
            case self::STATUS_INACTIVE:
                return 'Inactive';
            case self::STATUS_SUSPENDED:
                return 'Suspended';

            default:
                return 'Invalid Status';
        }
    }


    public function rank()
    {
        return $this->hasOne(Rankings::class, 'id', 'rankId');
    }

    public function deposits(): HasMany
    {
        return $this->hasMany(Deposits::class, 'userId', 'id');
    }

    public function commissions(): HasMany
    {
        return $this->hasMany(Commissions::class, 'userId', 'id');
    }

    public function children()
    {
        return $this->hasMany(User::class, 'upline_referral_id');
    }
    public function parent()
    {
        return $this->belongsTo(User::class, 'upline_referral_id');
    }

}
