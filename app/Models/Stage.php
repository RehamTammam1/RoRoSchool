<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Stage extends Model 
{   
    use HasTranslations;
    public $translatable = ['name']; 
    protected $fillable = ['name','grade_id'];

    protected $table = 'Stages';
    public $timestamps = true;

    public function grade()
    {
        return $this->belongsTo(\App\Models\Grade::class);
    }

}