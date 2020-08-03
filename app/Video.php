<?php

namespace Emotionally;

use Emotionally\Http\Controllers\ReportController;
use Illuminate\Database\Eloquent\Model;
use function MongoDB\BSON\toJSON;

class Video extends Model
{
    protected $appends = ["thumbnail"];

    /**
     * This function use to view user who uploaded video.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo('Emotionally\User', 'user_id');
    }

    /**
     * This function use to view video's father project.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function project()
    {
        return $this->belongsTo('Emotionally\Project');
    }

    /**
     * Get the thumbnail of a video.
     * @return string The thumbnail.
     */
    public function getThumbnailAttribute()
    {
        return 'https://picsum.photos/848/480';
    }

    public function getAverageReportAttribute()
    {
        return ReportController::getEmotionValues(ReportController::average($this->report));
    }
}
