<?php

namespace App\Services;

class DayCalory
{
	private $height;
	private $weight;
	private $gender;
	private $dateOfBirth;
	private $activityLevel;

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

	public function setGender($gender = "")
	{
		$this->gender = $gender;

		return $this;
	}

	public function setDateOfBirth($dateOfBirth = null)
	{
		$this->dateOfBirth = $dateOfBirth;

		return $this;
	}

	public function setActivityLevel($activityLevel = "")
	{
		$this->activityLevel = $activityLevel;

		return $this;
	}

	public function calculate()
	{
		$age = $this->howOld($this->dateOfBirth);
		$BMR = 0;

		if ($age == 0) return 0;

		if ($this->gender == "Laki-laki") {
			$BMR = 66.4730 + (13.7516 * $this->weight) + (5.0033 * $this->height) - (6.7550 * $age);
		} elseif ($this->gender == "Perempuan") {
			$BMR = 655.0955 + (9.5634 * $this->weight) + (1.8496 * $this->height) - (4.6756 * $age);
		}

		$result = $this->mapResult($BMR, $this->activityLevel);

		return $result;
	}

	private function howOld($date)
	{
		list($year, $month, $day) = explode('-', $date);

        $yearDiff = date("Y") - $year;
        $monthDiff = date("m") - $month;
        $dayDiff = date("d") - $day;

        if ($monthDiff < 0) $yearDiff--;
            elseif (($monthDiff == 0) && ($dayDiff < 0)) $yearDiff--;

        return $yearDiff;
	}

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