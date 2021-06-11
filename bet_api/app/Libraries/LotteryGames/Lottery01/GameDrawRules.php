<?php

namespace App\Libraries\LotteryGames\Lottery01;

use App\Libraries\LotteryGames\Lottery01\GameDraw;

class GameDrawRules extends GameDraw
{
    // General area lottery number array.(一般區開獎號碼陣列)
    private $generalCode = [];
    // Special number lottery number array.(特別號開獎號碼陣列)
    private $specialCode = [];

    public function __construct()
    {
        parent::__construct();
    }

    // re set darw member
    public function setDarwCode(array $generalCode = [], array $specialCode = [])
    {
        $this->generalCode = $generalCode;

        $this->specialCode = $specialCode;
    }

    // (北京賽車規則)
    public function lottery01Rule(int $typeId, string $ruleJson = '')
    {
        $resultData = array();
        $ruleJson = json_decode($ruleJson, true);// (開獎公式用資料)
        switch ($typeId) {
            case '1':
                // (名次猜車號)
                $resultData = self::type01($ruleJson);
                break;

            case '2':
                // (車號猜名次)
                $resultData = self::type02($ruleJson);
                break;

            case '3':
                // (名次猜大小)
                $resultData = self::type03($ruleJson);
                break;

            case '4':
                // (名次猜單雙)
                $resultData = self::type04($ruleJson);
                break;

            case '5':
                // (名次猜龍虎)
                $resultData = self::type05($ruleJson);
                break;

            case '6':
                // (冠亞猜車號)
                $resultData = self::type06($ruleJson);
                break;

            case '7':
                // (冠亞加總)
                $resultData = self::type07($ruleJson);
                break;

            case '8':
                // (冠亞加總大小)
                $resultData = self::type08($ruleJson);
                break;

            case '9':
                // (冠亞加總單雙)
                $resultData = self::type09($ruleJson);
                break;

            default:
                
                break;
        }
        return $resultData;
    }

    /**
     * Guess the car number.(名次猜車號)
     *
     * 規則SON:
     * {
     *     "SourceCode":"generalCode",
     *     "GetArrayKey":"0"
     * }
     *
     * SourceCode   : 使用的資料陣列變數
     * GetArrayKey  : 取值使用的陣列KEY
     *
     * @param array $ruleArray  : 開獎公式資料
     * @return void
     */
    public function type01(array $ruleArray = [])
    {
        $sourceCode = (isset($ruleArray['SourceCode']))? $ruleArray['SourceCode'] : 'generalCode';
        $returnData = array(
            'codeVal' => $this->$sourceCode[$ruleArray['GetArrayKey']],
        );
        unset($sourceCode);
        return $returnData;
    }

    /**
     * (車號猜名次)
     *
     * 規則SON:
     * {
     *     "SourceCode":"generalCode",
     *     "GetArrayVal":"01"
     * }
     *
     * SourceCode   : 使用的資料陣列變數
     * GetArrayVal  : 查詢陣列KEY的值
     *
     * @param array $ruleArray  : 開獎公式資料
     * @return void
     */
    public function type02(array $ruleArray = [])
    {
        $sourceCode = (isset($ruleArray['SourceCode']))? $ruleArray['SourceCode'] : 'generalCode';
        $no = array_search($ruleArray['GetArrayVal'], $this->$sourceCode) + 1;
        $returnData = array(
            'codeVal' => sprintf('N%s', $no),
        );
        unset($sourceCode);
        return $returnData;
    }

    /**
     * (名次猜大小)
     *
     * 規則SON:
     * {
     *     "SourceCode":"generalCode",
     *     "GetArrayKey":"01"
     * }
     *
     * SourceCode   : 使用的資料陣列變數
     * GetArrayKey  : 取值使用的陣列KEY
     *
     * @param array $ruleArray  : 開獎公式資料
     * @return void
     */
    public function type03(array $ruleArray = [])
    {
        $sourceCode = (isset($ruleArray['SourceCode']))? $ruleArray['SourceCode'] : 'generalCode';
        $returnData = array(
            'codeVal' => $this->big_small($this->$sourceCode[$ruleArray['GetArrayKey']]),
        );
        return $returnData;
    }

    /**
     * (名次猜單雙)
     *
     * 規則SON:
     * {
     *     "SourceCode":"generalCode",
     *     "GetArrayKey":"01"
     * }
     *
     * SourceCode   : 使用的資料陣列變數
     * GetArrayKey  : 取值使用的陣列KEY
     *
     * @param array $ruleArray  : 開獎公式資料
     * @return void
     */
    public function type04(array $ruleArray = [])
    {
        $sourceCode = (isset($ruleArray['SourceCode']))? $ruleArray['SourceCode'] : 'generalCode';
        $returnData = array(
            'codeVal' => $this->odd_even($this->$sourceCode[$ruleArray['GetArrayKey']]),
            // ['odd'=>'單', 'even'=>'雙']
        );
        return $returnData;

    }

    /**
     * (名次猜龍虎)
     *
     * 規則SON:
     * {
     *     "SourceCode":"generalCode",
     *     "GetArrayKeyA":"0",
     *     "GetArrayKeyB":"9"
     * }
     *
     * SourceCode   : 使用的資料陣列變數
     * GetArrayKeyA : 取值使用的陣列KEY
     * GetArrayKeyB : 取值使用的陣列KEY
     *
     * @param array $ruleArray  : 開獎公式資料
     * @return void
     */
    public function type05(array $ruleArray = [])
    {
        $sourceCode = (isset($ruleArray['SourceCode']))? $ruleArray['SourceCode'] : 'generalCode';
        $returnData = array(
            'codeVal' => $this->dragon_tiger($this->$sourceCode[$ruleArray['GetArrayKeyA']], $this->$sourceCode[$ruleArray['GetArrayKeyB']]),
            // ['dragon'=>'龍', 'tiger'=>'虎']
        );
        return $returnData;
    }

    /**
     * (冠亞猜車號)
     *
     * 規則SON:
     * {
     *     "SourceCode":"generalCode",
     *     "GetArrayKeyA":"0",
     *     "GetArrayKeyB":"1"
     * }
     *
     * SourceCode   : 使用的資料陣列變數
     * GetArrayKeyA : 取值使用的陣列KEY
     * GetArrayKeyB : 取值使用的陣列KEY
     *
     * @param array $ruleArray  : 開獎公式資料
     * @return void
     */
    public function type06(array $ruleArray = [])
    {
        $sourceCode = (isset($ruleArray['SourceCode']))? $ruleArray['SourceCode'] : 'generalCode';
        $s = array(
            $this->$sourceCode[$ruleArray['GetArrayKeyA']],
            $this->$sourceCode[$ruleArray['GetArrayKeyB']],
        );
        sort($s);
        $returnData = array(
            'codeVal' => implode('-', $s),
        );
        return $returnData;
    }

    /**
     * (冠亞加總)
     *
     * 規則SON:
     * {
     *     "SourceCode":"generalCode",
     *     "GetArrayKeyA":"0",
     *     "GetArrayKeyB":"1"
     * }
     *
     * SourceCode   : 使用的資料陣列變數
     * GetArrayKeyA : 取值使用的陣列KEY
     * GetArrayKeyB : 取值使用的陣列KEY
     *
     * @param array $ruleArray  : 開獎公式資料
     * @return void
     */
    public function type07(array $ruleArray = [])
    {
        $sourceCode = (isset($ruleArray['SourceCode']))? $ruleArray['SourceCode'] : 'generalCode';
        $returnData = array(
            'codeVal' => $this->$sourceCode[$ruleArray['GetArrayKeyA']] + $this->$sourceCode[$ruleArray['GetArrayKeyB']],
        );
        return $returnData;
    }

    /**
     * (冠亞加總大小)
     *
     * 規則SON:
     * {
     *     "SourceCode":"generalCode",
     *     "GetArrayKeyA":"0",
     *     "GetArrayKeyB":"1"
     * }
     *
     * SourceCode   : 使用的資料陣列變數
     * GetArrayKeyA : 取值使用的陣列KEY
     * GetArrayKeyB : 取值使用的陣列KEY
     *
     * @param array $ruleArray  : 開獎公式資料
     * @return void
     */
    public function type08(array $ruleArray = [])
    {
        $sourceCode = (isset($ruleArray['SourceCode']))? $ruleArray['SourceCode'] : 'generalCode';
        $returnData = array(
            'codeVal' => $this->big_tie_small($this->$sourceCode[$ruleArray['GetArrayKeyA']] + $this->$sourceCode[$ruleArray['GetArrayKeyB']]),
        );
        return $returnData;
    }

    /**
     * (冠亞加總單雙)
     *
     * 規則SON:
     * {
     *     "SourceCode":"generalCode",
     *     "GetArrayKeyA":"0",
     *     "GetArrayKeyB":"1"
     * }
     *
     * SourceCode   : 使用的資料陣列變數
     * GetArrayKeyA : 取值使用的陣列KEY
     * GetArrayKeyB : 取值使用的陣列KEY
     *
     * @param array $ruleArray  : 開獎公式資料
     * @return void
     */
    public function type09(array $ruleArray = [])
    {
        $sourceCode = (isset($ruleArray['SourceCode']))? $ruleArray['SourceCode'] : 'generalCode';
        $returnData = array(
            'codeVal' => $this->odd_even($this->$sourceCode[$ruleArray['GetArrayKeyA']] + $this->$sourceCode[$ruleArray['GetArrayKeyB']]),
        );
        return $returnData;
    }

    /**
     * 比大小
     *
     * @param integer $val
     * @return void
     */
    public function big_small(int $val)
    {
        // ['big'=>'大', 'small'=>'小']
        if ($val >= 6) {
            return 'big';
        } else {
            return 'small';
        }
    }

    /**
     * 加總比大小
     *
     * @param integer $val
     * @return void
     */
    public function big_tie_small(int $val)
    {
        // // ['big'=>'大', 'tie'=>'和', 'small'=>'小']
        // if ($val == 11) {
        //     return 'tie';
        // } else if ($val >= 12) {
        //     return 'big';
        // } else {
        //     return 'small';
        // }
        // ['big'=>'大', 'small'=>'小']
        if ($val >= 12) {
            return 'big';
        } else {
            return 'small';
        }
    }

    /**
     * 猜單雙
     *
     * @param integer $val
     * @return void
     */
    public function odd_even(int $val)
    {
        // ['odd'=>'單', 'even'=>'雙']
        if ($val %2 == 1) {
            return 'odd';
        } else {
            return 'even';
        }

    }

    /**
     * 猜龍虎
     *
     * @param integer $dragon
     * @param integer $tiger
     * @return void
     */
    public function dragon_tiger(int $dragon, int $tiger)
    {
        // ['dragon'=>'龍', 'tiger'=>'虎']
        if ($dragon > $tiger) {
            return 'dragon';
        } else {
            return 'tiger';
        }

    }

    public function __destruct()
    {
        parent::__destruct();
        $this->generalCode = [];
        $this->specialCode = [];
    }
}
