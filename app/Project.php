<?php

namespace Emotionally;

use Emotionally\Http\Controllers\ReportController;
use Exception;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{

    protected $appends = ['number_of_subprojects', 'number_of_videos', 'average_emotion'];

    /**
     * This function use to view users of the project.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany('Emotionally\User')
            ->withPivot(['read', 'modify', 'add', 'remove'])
            ->withTimestamps();
    }

    /**
     * This function use to view project's author.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo('Emotionally\User', 'user_id');
    }

    /**
     * This function use to view project's videos.
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function videos()
    {
        return $this->hasMany('Emotionally\Video');
    }

    /**
     * This function use to view project's sub projects.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sub_projects()
    {
        return $this->hasMany('Emotionally\Project', 'father_id');
    }

    /**
     * This function use to view a sub project's father project.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function father_project()
    {
        return $this->belongsTo('Emotionally\Project', 'father_id');
    }

    /**
     * Get the number of subprojects of the project.
     * @return int The number of subprojects.
     */
    public function getNumberOfSubprojectsAttribute()
    {
        return Project::where('father_id', $this->id)->count();
    }

    /**
     * Get the number of videos in the project.
     * @return int The number of videos.
     */
    public function getNumberOfVideosAttribute()
    {
        return $this->videos()->count();
    }

    public function getReportAttribute()
    {
        $REPORTS = $this->videos()->get()->map(function (Video $element) {
            return json_decode($element->report, true) ?? array();
        })->toArray();
        $SUB_REPORTS = $this->sub_projects()->get()->map(function (Project $sub_project) {
            return $sub_project->report ?? array();
        })->toArray();
        return ReportController::average(array_merge($REPORTS, $SUB_REPORTS));
    }

    /**
     * Get the average emotion of the project.
     * @return string The average emotion.
     */
    public function getAverageEmotionAttribute()
    {
        return ReportController::highestEmotion($this->report);
    }

}
