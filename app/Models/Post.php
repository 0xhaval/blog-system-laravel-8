<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description', 
        'content', 
        'image',
        'published_at',
        'category_id'
    ];


    /**
     * Delete Post Image from stroage
     * 
     * @return void
     */
    public function deleteImage()
    {
        Storage::delete($this->image);
    }

    /**
     * Relation with crtegory class
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Relation with tag class
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    /**
     * Check the post if has Id 
     * @return bool
     */
    public function hasTag($tagId)
    {
        return in_array($tagId, $this->tags->pluck('id')->toArray());
    }
}
