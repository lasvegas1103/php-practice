<?php

/**
 * EveningRatesクラス
 */
require_once "./interface/IDiscount.php";
class EveningRates implements IDiscount {

    // 100円引き
    private $discountRate  = 100;
    private $isDiscounted = false;
    private $ticket;

    function __construct(TicketBase $ticket)
    {
        $this->ticket = $ticket;
        $this->isDiscounted = $this->_isEvening17pm();
    }

    /**
     * 割引後の金額計算
     * @return object 割引後の金額計算
     */
    public function priceAfterDiscountCalculation():void 
    {
        
        if (!$this->isDiscounted) return;

        $price = empty($this->ticket->getPriceAfterChange()) ? $this->ticket->getPrice() : $this->ticket->getPriceAfterChange();
        $this->ticket->setPriceAfterChange($price - $this->discountRate);
    }

    /**
     * 割引額を返す
     * @return int 割引額
     */
    public function getDiscountRate(): float
    {

        if (!$this->isDiscounted) return 0;

        return $this->discountRate;
    }

    /**
     * 夕方17時以降か
     * @return bool
     */
    private function _isEvening17pm(): bool {
        //17:00を超えているか？
        date_default_timezone_set('Asia/Tokyo');
        if (strtotime(date('H:i:s')) >= strtotime('17:00:00')) return true;

        return false;
    }
        
}

?>