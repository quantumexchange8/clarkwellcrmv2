<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'events';

    protected $primaryKey = 'id';

    protected $fillable = [
        'event_title', 'event_image', 'visibility', 'pop_up_status', 'user_id', 'deleted_at'
    ];

    public static function get_record($search, $perpage)
    {
        $query = Event::where('deleted_at', null);

        $search_text = @$search['freetext'] ?? NULL;
        $freetext = explode(' ', $search_text);

        if($search_text){
            foreach($freetext as $freetexts) {
                $query->where(function ($q) use ($freetexts) {
                    $q->where('title', 'like', '%' . $freetexts . '%');
                });
            }
        }

        return $query->orderby('created_at', 'desc')->paginate($perpage);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

}
