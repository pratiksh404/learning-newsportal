<?php

namespace App\Models\Admin;

use App\Models\User;
use App\Models\Admin\Tag;
use App\Models\Admin\Category;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Spatie\Activitylog\Traits\LogsActivity;

class Post extends Model
{
    use LogsActivity, Sluggable;


    protected $guarded = [];

    // Forget cache on updating or saving and deleting
    public static function boot()
    {
        parent::boot();

        static::saving(function () {
            self::cacheKey();
        });

        static::deleting(function () {
            self::cacheKey();
        });
    }

    // Cache Keys
    private static function cacheKey()
    {
        Cache::has('posts') ? Cache::forget('posts') : '';
    }

    // Logs
    protected static $logName = 'post';

    // Casts
    protected $casts = [
        'meta_keywords' => 'array'
    ];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
    // Relation
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
    public function moderator()
    {
        return $this->belongsTo(User::class, 'approve_by');
    }
    public function tags()
    {
        return $this->belongsToMany(Tag::class)->withTimestamps();
    }

    // Accessors
    public function getStatusAttribute($attribute)
    {
        return [
            1 => 'Draft',
            2 => 'Pending',
            3 => 'Published'
        ][$attribute];
    }
}
