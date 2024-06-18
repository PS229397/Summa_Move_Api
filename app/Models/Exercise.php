<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Exercise
 *
 * @property $id
 * @property $exercise_photo_url
 * @property $name
 * @property $description
 * @property $created_at
 * @property $updated_at
 *
 * @property Performance[] $performances
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Exercise extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['exercise_photo_url', 'name', 'description'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function performances()
    {
        return $this->hasMany(\App\Models\Performance::class, 'id', 'exercise_id');
    }
    
}
