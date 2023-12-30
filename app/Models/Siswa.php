<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

// class Siswa extends Model
class Siswa extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $table = "siswa";
    protected $primaryKey = 'nisn';
    public $incrementing = false;
    protected $dates = ['deleted_at'];

    protected $guarded = []; //fix to fillable property to allow mass assignment on and fillable all
    // protected $fillable = [
    //     'nisn',
    // ];

    protected $hidden = [
    	'password'
    ];

    public function spp()
    {
        return $this->belongsTo(Spp::class, 'id_spp');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas');
    }

    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class, 'id_pembayaran');
    }
}
