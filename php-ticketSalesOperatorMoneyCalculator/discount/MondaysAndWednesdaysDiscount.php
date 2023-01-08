<?php

/**
 * MondaysAndWednesdaysDiscountクラス
 */
require_once "./interface/IDiscount.php";
class MondaysAndWednesdaysDiscount implements IDiscount {

    // 100円引き
    private $discountRate  = 100;
    private $isDiscounted = false;
    private $ticket;

    function __construct(TicketBase $ticket)
    {
        $this->ticket = $ticket;
        $this->isDiscounted = $this->_isMondaysAndWednesdays();
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
     * 月・水か確認
     * @return bool
     */
    private function _isMondaysAndWednesdays(): bool {
        // 月・水であるか
        $week = date("w");
        if ($week == 1 || $week == 3) return true;

        return false;
    }
        
}

?>