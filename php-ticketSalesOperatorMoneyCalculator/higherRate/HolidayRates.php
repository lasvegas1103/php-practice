<?php

/**
 * HolidayRatesクラス
 */
require_once "./interface/IHigherRate.php";
class HolidayRates implements IHigherRate {

    // 100円増し
    private $higherRate  = 100;
    private $isHigherRated = false;
    private $ticket;

    function __construct(TicketBase $ticket)
    {
        $this->ticket = $ticket;
        $this->isHigherRated = $this->_isHoliday();
    }

    /**
     * 割増後の金額計算
     * @return object 割増後の金額計算
     */
    public function priceAfterHigherRateCalculation():void 
    {
        
        if (!$this->isHigherRated) return;

        $price = empty($this->ticket->getPriceAfterChange()) ? $this->ticket->getPrice() : $this->ticket->getPriceAfterChange();
        $this->ticket->setPriceAfterChange($price + $this->higherRate);
    }

    /**
     * 割増額を返す
     * @return int 割引額
     */
    public function getHigherRate(): int
    {
        if (!$this->isHigherRated) return 0;
        return $this->higherRate;
    }

    /**
     * 休日か確認
     * @return $numberOfPeople
     */
    private function _isHoliday(): bool {
        // 土日であるか
        $week = date("w");
        if ($week == 0 || $week == 6) return true;

        // 祝日か
        $nationalHoliday = [
            '2022-01-01'
            ,'2022-01-10'
            ,'2022-02-11'
            ,'2022-02-23'
            ,'2022-03-21'
            ,'2022-04-29'
            ,'2022-05-03'
            ,'2022-05-04'
            ,'2022-05-05'
            ,'2022-07-18'
            ,'2022-08-11'
            ,'2022-09-19'
            ,'2022-09-23'
            ,'2022-10-10'
            ,'2022-11-03'
            ,'2022-11-23'
        ];
        $today = date("Y-m-d");
        if (in_array($today, $nationalHoliday)) return true;

        return false;
    }
}

?>