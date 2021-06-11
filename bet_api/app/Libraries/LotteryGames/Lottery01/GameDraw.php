<?php

namespace App\Libraries\LotteryGames\Lottery01;

class GameDraw
{
    /**
     * General draw number array.(一般區開獎號碼)
     */
    private $generalOpenArr = [];
    /**
     * Special draw number array.(特別號開獎號碼)
     */
    private $specialOpenArr = [];

    // 建構子
    public function __construct()
    {
    }

    /**
     * Setting general draw rule.(設定一般區開獎規則)
     *
     * @param string $dataJson  使用開獎號碼JSON
     * @param integer $digits   開幾碼
     * @param integer $repeat   是否重複號碼
     * @return void
     */
    public function setGeneraDrawRule(string $dataJson, int $digits, int $repeat=0)
    {
        if (empty($dataJson) || !self::isJSON($dataJson) || empty($digits)) {
            return [];
        }

        $this->generalOpenArr = self::draw($dataJson, $digits, $repeat);
        return $this->generalOpenArr;
    }

    /**
     * Setting special draw rule.(設定特別號開獎規則)
     *
     * @param string $dataJson  使用開獎號碼JSON
     * @param integer $digits   開幾碼
     * @param boolean $repeat   是否重複號碼
     * @return void
     */
    public function setSpecialDrawRule(string $dataJson, int $digits, int $repeat=0)
    {
        if (empty($dataJson) || !self::isJSON($dataJson) || empty($digits)) {
            return [];
        }

        $this->specialOpenArr = self::draw($dataJson, $digits, $repeat);
        return $this->specialOpenArr;
    }

    /**
     * Determine the JSON data format.(判斷JSON資料格式)
     *
     * @param [type] $string    受檢查資料
     * @return boolean
     */
    public function isJSON($string){
        return ( is_string($string) && is_array(json_decode($string, true)) && (json_last_error() == JSON_ERROR_NONE) )? true : false;
    }

    /**
     * Lottery game draw.(彩票遊戲開獎)
     *
     * @param string $dataJson  使用開獎號碼JSON
     * @param integer $digits   開幾碼
     * @param integer $repeat   是否重複號碼
     * @return void
     */
    private function draw(string $dataJson, int $digits, int $repeat)
    {
        $openArr = [];
        $dataArr = json_decode($dataJson, true);
        $processingArr = $dataArr;
        while (count($openArr) <  $digits) {
            if ($repeat == 1) {
                // 1: repeatable(1:可重複)
                $processingArr = $dataArr;
            }
            shuffle($processingArr);
            array_push($openArr, array_shift($processingArr));
        }
        unset($processingArr);
        unset($dataArr);

        return $openArr;
    }

    // 建構子
    public function __destruct()
    {
        $this->generalOpenArr = [];
        $this->specialOpenArr = [];
    }
}
