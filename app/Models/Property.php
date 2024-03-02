<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function propertyType()
    {
        // Define the relationship using the belongsTo method
        // 'PropertyType::class' is the related model class
        // 'propertyType_id' is the foreign key in the current model
        // 'id' is the primary key in the related model
        return $this->belongsTo(PropertyType::class, 'propertyType_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'agent_id', 'id');
    }

    public function propertyState()
    {
        return $this->belongsTo(State::class, 'state', 'id');
    }
}
