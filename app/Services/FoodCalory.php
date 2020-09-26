<?php

namespace App\Services;

use App\Models\Food;

class FoodCalory
{
    /**
     * @var
     */
    private $foods;

    /**
     * @param array $foods
     * @return $this
     */
    public function setFoods($foods = [])
    {
        $this->foods = $foods;

        return $this;
    }

    /**
     * @return float|int
     */
    public function calculate()
    {
        $foods = Food::select('calory')->whereIn('id', $this->foods)->get()->toArray();

        $total = array_sum(\Arr::flatten($foods));

        return $total;
    }
}
