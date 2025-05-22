<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Product extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'price', 'stock', 'comment', 'company_id', 'image_path'];

    public function scopeSearch($query, $keyword)
{
    return $query->when($keyword, function ($q) use ($keyword) {
        return $q->where('name', 'like', "%{$keyword}%")
                 ->orWhereHas('company', function ($q2) use ($keyword) {
                     $q2->where('name', 'like', "%{$keyword}%");
                 });
    });
}


     public function company()
{
    return $this->belongsTo(Company::class);
}


}


