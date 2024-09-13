<?php

namespace App\Repositories;

class TestRepository extends QueryFilter
{
    public function beforeDate($date)
    {
        return $this->builder->whereDate('created_at', '<', $date);
    }

    public function afterDate($date)
    {
        return $this->builder->whereDate('created_at', '>', $date);
    }
}
