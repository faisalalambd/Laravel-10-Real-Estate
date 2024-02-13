<?php

// Define a namespace for the class (App\Models)
namespace App\Models;

// Use the Eloquent HasFactory trait
use Illuminate\Database\Eloquent\Factories\HasFactory;

// Extend the Eloquent Model class
use Illuminate\Database\Eloquent\Model;

// Define the Property class that extends the Eloquent Model
class Property extends Model
{
    // Use the HasFactory trait in the Property class
    use HasFactory;

    // Allow mass assignment for all attributes
    protected $guarded = [];

    // Define a relationship: Property belongs to a PropertyType
    public function propertyType()
    {
        // Define the relationship using the belongsTo method
        // 'PropertyType::class' is the related model class
        // 'propertyType_id' is the foreign key in the current model
        // 'id' is the primary key in the related model
        return $this->belongsTo(PropertyType::class, 'propertyType_id', 'id');
    }

    // Define a relationship: Property belongs to a User
    public function user()
    {
        // Define the relationship using the belongsTo method
        // 'User::class' is the related model class
        // 'agent_id' is the foreign key in the current model
        // 'id' is the primary key in the related model
        return $this->belongsTo(User::class, 'agent_id', 'id');
    }

    public function propertyState()
    {
        return $this->belongsTo(State::class, 'state', 'id');
    }
}
