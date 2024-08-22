<?php

namespace App\Models;

use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Grade extends Model 
{

    use HasTranslations;
    public $translatable = ['Name'];
    protected $fillable = ['Name','Notes'];
    
    protected $table = 'Grades';
    public $timestamps = true;


    public function stages(): HasMany
    {
        return $this->hasMany(Stage::class);
    }

}