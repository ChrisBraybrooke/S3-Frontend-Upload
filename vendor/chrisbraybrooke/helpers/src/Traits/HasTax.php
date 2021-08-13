<?php

namespace ChrisBraybrooke\Helpers\Traits;

trait HasTax
{
    /**
     * The total price.
     *
     * @return float
     */
    public function price(): float
    {
        return $this->price;
    }

    /**
     * The amount of tax.
     *
     * @return float
     */
    public function taxRate(): float
    {
        return 0.2;
    }

    /**
     * Calculate the amount of tax on this service.
     *
     * @return float
     */
    public function getTaxAmountAttribute()
    {
        if ($this->taxIncluded()) {
            return number_format($this->price() - ($this->price() / (1 + $this->taxRate())), 2);
        } else {
            return number_format($this->price() * $this->taxRate());
        }
    }
}