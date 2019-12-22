<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Slogan
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Comment[] $comments
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Tag[] $tags
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Slogan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Slogan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Slogan query()
 * @mixin \Eloquent
 * @property int $id
 * @property string $phrase
 * @property string $writer
 * @property string $source
 * @property string $supplement
 * @property int $rating
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Slogan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Slogan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Slogan wherePhrase($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Slogan whereSource($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Slogan whereSupplement($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Slogan whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Slogan whereWriter($value)
 */
class Slogan extends Model
{
    protected $fillable = ['phrase', 'writer','source','supplement','rating'];

    protected $attributes = array(
        'rating' => 0,
    );

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}
