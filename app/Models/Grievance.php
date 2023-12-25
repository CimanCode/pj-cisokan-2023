<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Grievance extends Model
{
    use HasFactory;
    protected $table = 'grievance';
    protected $primaryKey = 'grievance_id';
    protected $keyType = 'string';
    protected $guarded = 'grievance_id';
    protected $fillable = [
        'user_id',
        'status',
        'grievance_num',
        'lattitude',
        'longitude',
        'issue',
        'category',
        'locations',
        'complainants',
        'kampung',
        'desa',
        'rt_rw',
        'no_telp',
        'no_ktp',
        'jalur_aduan',
        'tindak_lanjut',
        'image_location',
        'image_ttd',
    ];

    protected static function boot(){
        parent::boot();

        static::creating(function ($model) {
            $model->{$model->getKeyName()} = Str::uuid()->toString();
        });

        static::creating(function ($grievance) {
            $number = 1;
            $grievance->grievance_num = '00' . $number++ . '/GRM-CISOKAN/' . '2023';
            // $Grievance_num = Grievance::query()->first();
            // // $number = 1;
            // // if($Grievance_num == null) {
            // //     $grievance->grievance_num = '00' . $number . '/GRM-CISOKAN/' . '2023';
            // // } else {
            // //     $grievance->grievance_num = '00' . $number++ . '/GRM-CISOKAN/' . '2023';
            // // }
            // $grievance->grievance_num = $Grievance_num ? '00' . $Grievance_num->grievance_num + 1 . '/GRM-CISOKAN/' .
            // Carbon::parse($Grievance_num->created_at)->format('y') : '00' . 1 . '/GRM-CISOKAN/' . '2023';
        });

    }

}


