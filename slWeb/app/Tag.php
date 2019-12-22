<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Tag
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Slogan[] $slogans
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Tag newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Tag newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Tag query()
 * @mixin \Eloquent
 * @property int $id
 * @property string $tag_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Tag whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Tag whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Tag whereTagName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Tag whereUpdatedAt($value)
 */
class Tag extends Model
{
    protected $fillable = [
        'tag_name',
        'tag_kana',
    ];

    public function slogans()
    {
        return $this->belongsToMany(Slogan::class)
            ->with('tags')
            ->withCount('comments')
            ->orderByDesc('rating');
    }
}
