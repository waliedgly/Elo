<?php

/**
 * Elo - Implementasi Algoritma Elo-rating pada PHP.
 * 
 * @author    Walied Ghaly Damiri (waliedgly) <waliedgly@gmail.com>
 * @copyright 2017 - 2022 Walied Ghaly Damiri
 * @license   http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License
 * @note      This program is distributed in the hope that it will be useful - WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 * FITNESS FOR A PARTICULAR PURPOSE.
 */
class Elo
{
    const VERSION = 'alpha 2';

    public $Ra = 1400;
    public $Rb = 1400;
    public $Winn = 1;
    public $Draw = 0.5;
    public $Lose = 0;

    public function Init($Number)
    {
        if (preg_match("/^([0-9\.]){1,}$/", $Number) == false) {
            return false;
        }

        return $Number;
    }

    public function Ea($Ra, $Rb)
    {
        return (1 / (pow(10, (($Rb - $Ra) / 400)) + 1));
    }

    public function Eb($Ra, $Rb)
    {
        return (1 / (pow(10, (($Ra - $Rb) / 400)) + 1));
    }

    public function Left($Ra, $Rb)
    {
        return ($this->Winn - $this->Eb($Ra, $Rb));
    }

    public function Right($Ra, $Rb)
    {
        return ($this->Winn - $this->Ea($Ra, $Rb));
    }

    public function USCF($E, $K, $S)
    {
        if ($K > 2400) {
            $H = $K + 16 * ($S - $E);
        }

        if ($K >= 2100) {
            $H = $K + 24 * ($S - $E);
        } else if ($K == 2400) {
            $H = $K + 24 * ($S - $E);
        }

        if ($K < 2100) {
            $H = $K + 32 * ($S - $E);
        }

        if ($H == false) {
            return false;
        }

        return $H;
    }

    public function RPostA($Ra, $Rb)
    {
        return $this->USCF($this->Ea($Ra, $Rb), $Ra, $this->Winn);
    }

    public function RPostB($Ra, $Rb)
    {
        return $this->USCF($this->Eb($Ra, $Rb), $Rb, $this->Lose);
    }

    public function RPost($W, $L, $N, $rOpp)
    {
        return (((($W - $L) * 400) / $N) + $rOpp);
    }

    public function RatingFloors($w, $d = 0, $r)
    {
        return min(array((100 + (4 * $w) + (2 * $d) + (1 * $r)), 150));
    }
}
