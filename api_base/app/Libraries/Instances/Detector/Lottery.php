<?php

namespace App\Libraries\Instances\Detector;

/**
 * Final Class Lottery.
 *
 * @package namespace App\Libraries\Instances\Detector;
 */
final class Lottery
{
    /**
     * The total balls.
     *
     * @var int
     */
    private $totalBalls;

    /**
     * Lottery constructor.
     *
     * @param int $totalBalls
     *
     * @return void
     */
    public function __construct(int $totalBalls)
    {
        $this->totalBalls = $totalBalls;
    }

    /**
     * Pick colored balls to successfully count.
     *
     * @param int $colorBalls
     * @param int $rounds
     *
     * @return int
     */
    public function pick(int $colorBalls, int $rounds = 1): int
    {
        if ($colorBalls > 0 && $this->totalBalls >= 0 && $rounds > 0) {
            /* 100 % */
            if ($colorBalls >= $this->totalBalls) {
                return $rounds;
            }
            /* Expected value */
            $expect = floor($rounds * ($colorBalls / $this->totalBalls));
            /* Variance */
            $variance = $rounds * ($colorBalls / $this->totalBalls) * (1 - ($colorBalls / $this->totalBalls));
            /* Standard deviation */
            $deviation = floor(sqrt($variance));
            /* Ensure accuracy */
            $deviation = (($expect == 0 || $deviation == 0) && mt_rand(1, $this->totalBalls) <= $colorBalls ? 1 : $deviation);
            /* Approximation distributed */
            return ($expect > 0 ? mt_rand($expect - $deviation, $expect + $deviation) : $deviation);
        }
        return 0;
    }

    /**
     * Create a ball box.
     *
     * @param int $totalBalls
     *
     * @return object
     */
    public static function inBox(int $totalBalls): object
    {
        return new self($totalBalls);
    }
}
