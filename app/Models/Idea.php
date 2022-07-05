<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use App\Models\Category;

class Idea extends Model
{
    use HasFactory, Sluggable;

    const PAGINATION_COUNT = 5;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function getStatusClasses()
    {
        if($this->status->name === 'Open'){
            return 'bg-gray-200';
        } elseif ($this->status->name === 'Considering'){
            return 'bg-purple text-white';
        } elseif ($this->status->name === 'In Progress'){
            return 'bg-yellow text-white';
        } elseif ($this->status->name === 'Implemented'){
            return 'bg-green text-white';
        } elseif ($this->status->name === 'Closed'){
            return 'bg-red text-white';
        }
        return 'bg-gray-200';
    }
}

