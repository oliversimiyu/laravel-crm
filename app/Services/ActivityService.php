<?php

namespace App\Services;

use App\Models\Activity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ActivityService
{
    /**
     * Log an activity.
     *
     * @param string $type The type of activity (create, update, delete, etc.)
     * @param string $subject A short description of the activity
     * @param Model $model The model the activity is related to
     * @param string|null $description A longer description (optional)
     * @param array|null $properties Additional data to store (optional)
     * @return Activity
     */
    public function log(
        string $type,
        string $subject,
        Model $model,
        ?string $description = null,
        ?array $properties = null
    ): Activity {
        return Activity::create([
            'user_id' => Auth::id(),
            'type' => $type,
            'subject' => $subject,
            'description' => $description,
            'loggable_type' => get_class($model),
            'loggable_id' => $model->id,
            'properties' => $properties,
        ]);
    }

    /**
     * Get recent activities.
     *
     * @param int $limit The number of activities to retrieve
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getRecent(int $limit = 10)
    {
        return Activity::with(['user', 'loggable'])
            ->latest()
            ->limit($limit)
            ->get();
    }
}
