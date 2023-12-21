<?php

namespace App\Models;

use App\Models\Role;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Users extends Model
{
    use HasFactory;
    protected $table = 'user';
    protected $primaryKey = 'user_id';
    protected $keyType = 'string';
    protected $guarded = 'user_id';
    protected $fillable = [
        'role_id',
        'api_token_petugas',
        'username',
        'email',
        'password',
    ];

    protected static function boot(){
        parent::boot();

        static::creating(function ($model) {
            $model->{$model->getKeyName()} = Str::uuid()->toString();
        });
        static::creating( function($users){
            $users->password = Hash::make($users->password);
        });

        static::updating( function(Users $users){
            if($users->isDirty(["password"])){
                $users->password = Hash::make($users->password);
            }
        });
    }
    public function role() : HasOne
    {
        return $this->hasOne(Role::class);
    }
}
