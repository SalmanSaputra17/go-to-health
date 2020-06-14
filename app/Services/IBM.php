<?php

namespace App\Services;

class IBM
{
	private $height;
	private $weight;

	public function setHeight($height = 0)
	{
		$this->height = $height;

		return $this;
	}

	public function setWeight($weight = 0)
	{
		$this->weight = $weight;

		return $this;
	}

	public function calculate()
	{
		$toMeter = $this->height / 100;
        $IBM = round($this->weight / ($toMeter * $toMeter), 2);
    
        return [
        	"IBM" => $IBM,
        	"category" => $this->mapCategory($IBM)
        ];
	}

	private function mapCategory($param)
	{
		$category = "";

		switch ($param) {
            case $param < 18.50:
                $category = "KURUS";  
                break;

            case $param >= 18.50 && $param <= 22.99:
                $category = "NORMAL";  
                break;

            case $param >= 23.00 && $param <= 24.99:
                $category = "OVERWEIGHT";  
                break;

            case $param >= 25.00:
                $category = "OBESITAS";  
                break;

            default:
                $category = "UNCATEGORIZED";
                break;
        }

        return $category;
	}
}