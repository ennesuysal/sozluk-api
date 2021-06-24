<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Title extends Model
{
    use HasFactory;
    protected $fillable = [
        'title'
    ];
    public function entries(){
        return $this->hasMany(Entry::class, 'title_id', 'ID');
    }
}
