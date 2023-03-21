<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Announcements extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'announcements';

    protected $primaryKey = 'id';

    protected $fillable = [
        'title', 'content', 'visibility', 'popup_status', 'userId', 'deleted_at'
    ];

    protected $casts = [
        'visibility' => 'boolean',
    ];

    public static function get_record($search, $perpage)
    {
        $query = Announcements::where('deleted_at', null);

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
}
