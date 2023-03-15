<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettingCountry extends Model
{
    use HasFactory;

    protected $table = 'countries';

    public static function get_country_sel(): array
    {
        $query = SettingCountry::where('id', '>', 1);

        return $query->orderby('id')->get()->pluck('name', 'name')->toArray();
    }}
