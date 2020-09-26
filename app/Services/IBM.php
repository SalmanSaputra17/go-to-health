<?php

namespace App\Services;

class IBM
{
    /**
     * @var
     */
    private $height;

    /**
     * @var
     */
    private $weight;

    /**
     * @param int $height
     * @return $this
     */
    public function setHeight($height = 0)
    {
        $this->height = $height;

        return $this;
    }

    /**
     * @param int $weight
     * @return $this
     */
    public function setWeight($weight = 0)
    {
        $this->weight = $weight;

        return $this;
    }

    /**
     * @return array
     */
    public function calculate()
    {
        $toMeter = $this->height / 100;
        $IBM = round($this->weight / ($toMeter * $toMeter), 2);

        return [
            "IBM"      => $IBM,
            "category" => $this->mapCategory($IBM)
        ];
    }

    /**
     * @param $param
     * @return string
     */
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
                $category = "KELEBIHAN BERAT BADAN";
                break;

            case $param >= 25.00:
                $category = "OBESITAS";
                break;

            default:
                $category = "BELUM TERKATEGORI";
                break;
        }

        return $category;
    }
}
