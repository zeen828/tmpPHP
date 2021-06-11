<?php
/*
 >> Information

    Title		: Lottery Box
    Revision	: 1.0.0
    Notes		:

    Revision History:
    When			Create		When		Edit		Description
    ---------------------------------------------------------------------------
    09-26-2020		Poen		12-18-2020	Poen		Code maintenance.
    ---------------------------------------------------------------------------

 >> About

    file > (app/Libraries/Instances/Detector/Lottery.php) :
    The functional base class.

 >> Learn

    Usage 1 :
    Create a ball box to pick up once in a single round.
    Note : return count 0 ~ 1

    Example :
    --------------------------------------------------------------------------
    use App\Libraries\Instances\Detector\Lottery;
    // 100 % count 1
    Lottery::inBox(100)->pick(100);
    // 20 % count 0 ~ 1
    Lottery::inBox(100)->pick(20);
    // 0.1 % count 0 ~ 1
    Lottery::inBox(1000)->pick(1);
    // 0.01 % count 0 ~ 1
    Lottery::inBox(10000)->pick(1);

    Usage 2 :
    Create a ball box to pick up multiple rounds.
    Note : return count 0 ~ multiple rounds

    Example :
    --------------------------------------------------------------------------
    use App\Libraries\Instances\Detector\Lottery;
    // 100 % count 99
    Lottery::inBox(100)->pick(100, 99);
    // 20 % count 0 ~ 99
    Lottery::inBox(100)->pick(20, 99);
    // 0.1 % count 0 ~ 99
    Lottery::inBox(1000)->pick(1, 99);
    // 0.01 % count 0 ~ 99
    Lottery::inBox(10000)->pick(1, 99);

*/
