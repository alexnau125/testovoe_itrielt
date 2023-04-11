<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventAgent extends Model
{
    use HasFactory;
    protected $table = 'event_agents';

    protected $fillable = ['user_id', 'event_id', 'code', 'status'];
}
