<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{

    public $timestamps = false;

    public function trainings(){
        return $this->hasMany(Training::class);
    }

    public function ratings(){
        return $this->belongsToMany(Rating::class)->withPivot('required_vatsim_rating', 'allow_mae_bundling', 'queue_length_low', 'queue_length_high');
    }

    public function permissions(){
        return $this->belongsToMany(Group::class, 'permissions')->withPivot('area_id')->withTimestamps();
    }

    public function mentors()
    {
        return $this->belongsToMany(User::class, 'permissions')->withPivot('group_id')->withTimestamps()->where('group_id', 3);
    }

    public function examiners()
    {
        return $this->belongsToMany(User::class, 'permissions')->withPivot('group_id')->withTimestamps()->where('group_id', 4);
    }

    public function positions(){
        return $this->hasMany(Position::class, 'area');
    }
}


