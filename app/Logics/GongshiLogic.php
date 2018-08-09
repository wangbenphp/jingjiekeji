<?php

namespace App\Logics;

/**
 * 定位计算公式
 * @author wangben
 * @date 20180805
 */
class GongshiLogic extends BaseLogic
{
    public function abc($a, $b, $c, $l = 4)
    {
        $x = ((($l * $l) + ($b * $b) - ($c * $c)) / (2 * $l));
        $y = ((($l * $l) + ($a * $a) - ($b * $b)) / (2 * $l));
        return ['x' => $x, 'y' => $y];
    }

    public function bcd($b, $c, $d, $l = 4)
    {
        $x = ((($l * $l) + ($b * $b) - ($c * $c)) / (2 * $l));
        $y = ((($l * $l) + ($d * $d) - ($c * $c)) / (2 * $l));
        return ['x' => $x, 'y' => $y];
    }

    public function cda($c, $d, $a, $l = 4)
    {
        $x = ((($l * $l) + ($a * $a) - ($d * $d)) / (2 * $l));
        $y = ((($l * $l) + ($d * $d) - ($c * $c)) / (2 * $l));
        return ['x' => $x, 'y' => $y];
    }

    public function dab($d, $a, $b, $l = 4)
    {
        $x = ((($l * $l) + ($a * $a) - ($d * $d)) / (2 * $l));
        $y = ((($l * $l) + ($a * $a) - ($b * $b)) / (2 * $l));
        return ['x' => $x, 'y' => $y];
    }

    /**
     * 四位定点坐标
     */
    public function four($ax, $ay, $bx, $by, $cx, $cy, $dx, $dy, $a, $b, $c, $d)
    {
        $A = $this->A4($ax, $ay, $bx, $by, $a, $b);
        $B = $this->B4($cx, $cy, $dx, $dy, $c, $d);
        $X = (($A*($dy-$cy) - $B*($by-$ay)) / ((($bx-$ax) * ($dy-$cy)) - (($dx-$cx) * ($by-$ay))));
        $Y = (($A*($dx-$cx) - $B*($bx-$ax)) / ((($by-$ay) * ($dx-$cx)) - (($dy-$cy) * ($bx-$ax))));
        return ['x' => $X, 'y' => $Y];
    }

    public function three($ax, $ay, $bx, $by, $cx, $cy, $a, $b, $c)
    {
        $A = $this->A3($ax, $ay, $bx, $by, $a, $b);
        $B = $this->B3($ax, $ay, $cx, $cy, $a, $c);
        $X = ($A*($cy-$ay) - $B*($by-$ay)) / ((($bx-$ax) * ($cy-$ay)) - (($cx-$ax) * ($by-$ay)));
        $Y = ($A*($cx-$ax) - $B*($bx-$ax)) / ((($by-$ay) * ($cx-$ax)) - (($cy-$ay) * ($bx-$ax)));
        return ['x' => $X, 'y' => $Y];
    }

    private function A3($ax, $ay, $bx, $by, $a, $b)
    {
        $A = (($a*$a) - ($b*$b) - ($ax*$ax) - ($ay*$ay) + ($bx*$bx) + ($by*$by)) / 2;
        return $A;
    }

    private function B3($ax, $ay, $cx, $cy, $a, $c)
    {
        $B = (($a*$a) - ($c*$c) - ($ax*$ax) - ($ay*$ay) + ($cx*$cx) + ($cy*$cy)) / 2;
        return $B;
    }

    private function A4($ax, $ay, $bx, $by, $a, $b)
    {
        $A = (($a*$a) - ($b*$b) - ($ax*$ax) - ($ay*$ay) + ($bx*$bx) + ($by*$by)) / 2;
        return $A;
    }

    private function B4($cx, $cy, $dx, $dy, $c, $d)
    {
        $B = (($c*$c) - ($d*$d) - ($cx*$cx) - ($cy*$cy) + ($dx*$dx) + ($dy*$dy)) / 2;
        return $B;
    }
}