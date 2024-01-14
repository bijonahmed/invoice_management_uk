<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use AuthorizesRequests;
use DB;

class Profile extends Authenticatable
{
    public static function country()
    {
        $rows = DB::table('countries')->orderBy('countries.id', 'desc')->get();
        return $rows;
    }

    public static function companySetting()
    {
        $row = DB::table('company_setting')->first();
        return $row;
    }
    
}
