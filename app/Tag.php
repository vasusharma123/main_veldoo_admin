<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Spatie\Tags\Tag as SpatieTag;
class Tag extends SpatieTag
{
    public function topics()
    {
        return $this->morphedByMany(Topic::class, 'taggable');
    }
    public function users()
    {
        return $this->morphedByMany(User::class, 'taggable');
    }
}