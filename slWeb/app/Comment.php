<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Comment
 *
 * @property int $id
 * @property int $studio_id
 * @property string $contributor_name
 * @property string $text
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Comment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Comment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Comment query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Comment whereContributorName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Comment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Comment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Comment whereStudioId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Comment whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Comment whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int $slogan_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Comment whereSloganId($value)
 */
class Comment extends Model
{
    protected $fillable = [
        'slogan_id',
        'contributor_name',
        'text',
        'rating'
    ];
}
