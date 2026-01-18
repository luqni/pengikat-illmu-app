<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;


use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Note extends Model
{
    use HasUuids;
    protected $fillable = ['title', 'content'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}