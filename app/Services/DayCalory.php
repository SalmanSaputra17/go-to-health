<?php

namespace App\Services;

class DayCalory
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
     * @var
     */
    private $gender;

    /**
     * @var
     */
    private $dateOfBirth;

    /**
     * @var
     */
    private $activityLevel;

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
     * @param string $gender
     * @return $this
     */
    public function setGender($gender = "")
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * @param null $dateOfBirth
     * @return $this
     */
    public function setDateOfBirth($dateOfBirth = null)
    {
        $this->dateOfBirth = $dateOfBirth;

        return $this;
    }

    /**
     * @param string $activityLevel
     * @return $this
     */
    public function setActivityLevel($activityLevel = "")
    {
        $this->activityLevel = $activityLevel;

        return $this;
    }

    /**
     * @return float|int
     */
    public function calculate()
    {
        $age = $this->howOld($this->dateOfBirth);
        $BMR = 0;

        if ($age == 0) {
            return 0;
        }

        if ($this->gender == "Laki-laki") {
            $BMR = 66.4730 + (13.7516 * $this->weight) + (5.0033 * $this->height) - (6.7550 * $age);
        } elseif ($this->gender == "Perempuan") {
            $BMR = 655.0955 + (9.5634 * $this->weight) + (1.8496 * $this->height) - (4.6756 * $age);
        }

        $result = $this->mapResult($BMR, $this->activityLevel);

        return $result;
    }

    /**
     * @param $date
     * @return false|int|mixed|string
     */
    private function howOld($date)
    {
        [$year, $month, $day] = explode('-', $date);

        $yearDiff = date("Y") - $year;
        $monthDiff = date("m") - $month;
        $dayDiff = date("d") - $day;

        if ($monthDiff < 0) {
            $yearDiff--;
        } elseif (($monthDiff == 0) && ($dayDiff < 0)) {
            $yearDiff--;
        }

        return $yearDiff;
    }

    /**
     * @param $BMR
     * @param $activityLevel
     * @return float
     */
    private function mapResult($BMR, $activityLevel)
    {
        $result = 0;

        switch ($activityLevel) {
            case 'Tidak Aktif':
                $result = $BMR * 1.2;
                break;

            case 'Ringan':
                $result = $BMR * 1.375;
                break;

            case 'Sedang':
                $result = $BMR * 1.55;
                break;

            case 'Berat':
                $result = $BMR * 1.725;
                break;

            case 'Sangat Berat':
                $result = $BMR * 1.9;
                break;
        }

        return round($result);
    }
}
