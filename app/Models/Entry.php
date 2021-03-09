<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entry extends Model
{
    use HasFactory;
    protected $fillable = [
        'title_id',
        'entry'
    ];
    public function suser(){
        return $this->belongsTo(Suser::class, 'user_id', 'ID');
    }
}
