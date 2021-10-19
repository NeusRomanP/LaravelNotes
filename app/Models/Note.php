<?php

namespace App\Models;

use App\Http\Controllers\NoteController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Note extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content'
    ];


    public function users($note){
        return $this->belongsToMany(
            User::class,
        )->wherePivot('note_id', $note->id)->withTimestamps();
    }
}
