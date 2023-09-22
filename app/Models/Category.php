<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    public $with = ['user'];

    protected $guarded = [];


    public function user(){
        return $this->belongsTo(User::class);
    }

    public function sub_categories(){
        return $this->hasMany(SubCategory::class);
    }
}
