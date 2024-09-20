<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;
        
    protected $guarded=[];

    public function folder()
    {
        return $this->belongsTo(Folder::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sharedUsers()
    {
        return $this->belongsToMany(User::class, 'file_shares'); // Assuming you have a file_shares pivot table
    }
    
}
