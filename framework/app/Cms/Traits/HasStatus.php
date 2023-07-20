<?php

namespace App\Cms\Traits;

trait HasStatus
{

    protected $ACTIVE = 1;
    protected $INACTIVE = 2;
    protected $RESERVED = 3;

    public function scopeActive($query)
    {
        return $query->where('status_id', $this->ACTIVE);
    }

    public function scopeInactive($query)
    {
        return $query->where('status_id', $this->INACTIVE);
    }

    public function scopeReserved($query)
    {
        return $query->where('status_id', $this->RESERVED);
    }

}
