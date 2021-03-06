<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Wilaya;
use App\Models\Category;
use App\Models\User;

class Reports extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function wilaya(){
        return $this->belongsTo(Wilaya::class);
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function user(){
        return $this->belongsTo(User::class)->latest();

    }
}
