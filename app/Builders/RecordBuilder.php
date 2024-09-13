<?php

namespace App\Builders;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Models\Activity;

class RecordBuilder
{
    protected string $logName;

    protected string $event;

    protected string $description = '';

    protected ?Model $consultant = null;

    protected ?Model $model = null;

    // public function __construct(string $logName, string $event)
    // {
    //     $this->logName = $logName;
    //     $this->event = $event;
    // }

    public function setLogName(string $logName): static
    {
        $this->logName = $logName;

        return $this;
    }

    public function setEvent(string $event): static
    {
        $this->event = $event;

        return $this;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function setConsultant(Model $consultant): static
    {
        $this->consultant = $consultant;

        return $this;
    }

    public function setModel(Model $model): static
    {
        $this->model = $model;

        return $this;
    }

    public function record(): void
    {
        activity()
            ->useLog($this->logName)
            ->event($this->event)
            ->when($this->model, function ($activity) {
                $activity->performedOn($this->model);
            })
            ->when($this->consultant, function ($activity) {
                $activity->causedBy($this->consultant);
            })
            ->tap(function (Activity $activity) {
                $activity->ip = request()->getClientIp();
            })
            ->log($this->description);
    }
}
