<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Performance
 *
 * @property $id
 * @property $times_completed
 * @property $times_completed_in_time
 * @property $created_at
 * @property $updated_at
 * @property $user_id
 * @property $exercise_id
 *
 * @property Exercise $exercise
 * @property User $user
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Performance extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['times_completed', 'times_completed_in_time', 'user_id', 'exercise_id'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function exercise()
    {
        return $this->belongsTo(\App\Models\Exercise::class, 'exercise_id', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id');
    }
    
}
