<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

// class Petugas extends Model
class Petugas extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $table = "petugas";
    protected $primaryKey = 'id_petugas';
    protected $guarded = ['id_petugas'];

    protected $hidden = [
    	'password'
    ];

    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class, 'id_pembayaran');
    }
}
