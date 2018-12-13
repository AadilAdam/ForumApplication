<?php

namespace App;

/**
 * RecordsActivity.
 */
trait RecordsActivity
{
    /**
     * Boot the trait.
     * 
     * @return
     */
    protected static function bootRecordsActivity()
    {
        if (auth()->guest()) return;

        foreach (static::getActivitiesToRecord() as $event) {
            static::$event(function ($model) use ($event) {
                $model->recordActivity($event);
            });
        }
        /**
         * When we are deleting any thread, 
         * we need to delete its activity in the process.also.
         * Thread uses trait, so it uses the trait.
         * reply uses it and while deleting the thread, it also deletes it replies.
         * so ideally reply.php should use the trait.
         */
        static::deleting(function ($model) {
            $model->activity()->delete();
        });
    }
    /**
     * Fetch all model events that require activity recording.
     *
     * @return array
     */
    protected static function getActivitiesToRecord(): array
    {
        return ['created'];
    }
    
    /**
     * 
     * 
     */
    protected function recordActivity($event)
    {
        $this->activity()
            ->create(
                [
                    'user_id' => auth()->id(),
                    'type' => $this->getActivityType($event),
                ]
            );
    }

    /**
     * Fetch the activity relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    protected function activity()
    {
        return $this->morphMany('App\Activity', 'subject');
    }

    /**
     * Determine the activity type.
     *
     * @param  string $event
     * @return string
     */
    protected function getActivityType($event) :string
    {
        $type = strtolower((new \ReflectionClass($this))->getShortName());

        return "{$event}_{$type}";
    }

}