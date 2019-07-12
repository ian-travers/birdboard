<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;


/**
 * App\Project
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @method static Builder|\App\Project newModelQuery()
 * @method static Builder|\App\Project newQuery()
 * @method static Builder|\App\Project query()
 * @method static Builder|\App\Project whereCreatedAt($value)
 * @method static Builder|\App\Project whereDescription($value)
 * @method static Builder|\App\Project whereId($value)
 * @method static Builder|\App\Project whereTitle($value)
 * @method static Builder|\App\Project whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Project extends Model
{
    protected $guarded = [];
}
