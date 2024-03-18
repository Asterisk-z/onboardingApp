<?php

namespace App\Observers;

use App\Models\Application;

class ApplicationObserver
{
    /**
     * Handle the Application "creating" event.
     *
     * @param  \App\Models\Application  $application
     * @return void
     */
    public function creating(Application $application)
    {
        $application->uuid = $application->createUuid();
    }

    /**
     * Handle the Application "created" event.
     *
     * @param  \App\Models\Application  $application
     * @return void
     */
    public function created(Application $application)
    {

    }

    /**
     * Handle the Application "updated" event.
     *
     * @param  \App\Models\Application  $application
     * @return void
     */
    public function updated(Application $application)
    {
        //
    }

    /**
     * Handle the Application "deleted" event.
     *
     * @param  \App\Models\Application  $application
     * @return void
     */
    public function deleted(Application $application)
    {
        //
    }

    /**
     * Handle the Application "restored" event.
     *
     * @param  \App\Models\Application  $application
     * @return void
     */
    public function restored(Application $application)
    {
        //
    }

    /**
     * Handle the Application "force deleted" event.
     *
     * @param  \App\Models\Application  $application
     * @return void
     */
    public function forceDeleted(Application $application)
    {
        //
    }

    // 'retrieved', 'creating', 'created', 'updating', 'updated',
    //  'saving', 'saved', 'restoring', 'restored', 'replicating',
    //   'deleting', 'deleted', 'forceDeleted', 'trashed'
}
