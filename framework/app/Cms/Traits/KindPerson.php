<?php

namespace App\Cms\Traits;

trait KindPerson
{

    protected $ADMIN = 1;
    protected $MASTER = 2;
    protected $BARBER = 3;
    protected $CUSTOMER = 4;
    protected $EXECUTIVE = 5;


    public function scopeAdmin($query)
    {
        return $query->where('role_id', $this->ADMIN);
    }

    public function scopeMaster($query)
    {
        return $query->where('role_id', $this->MASTER);
    }

    public function scopeBarber($query)
    {
        return $query->where('role_id', $this->BARBER);
    }

    public function scopeCustomer($query)
    {
        return $query->where('role_id', $this->CUSTOMER);
    }

    public function scopeExecutive($query)
    {
        return $query->where('role_id', $this->EXECUTIVE);
    }
}
