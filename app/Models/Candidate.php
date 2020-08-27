<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    /**
     * candidateを持つuser participantを取得
     */
    public function users()
    {
        return $this->belongsToMany('App\Models\Users');
    }
}
