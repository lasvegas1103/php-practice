<?php

/**
 * GroupDiscountクラス
 */
require_once "./interface/IDiscount.php";
class GroupDiscount implements IDiscount {

    // 10%割引なので0.9をかける
    private $discountRate  = 10;
    private $isDiscounted = false;
    private $ticket;

    function __construct(TicketBase $ticket)
    {
        $this->ticket = $ticket;
        $this->isDiscounted = $this->_isGroupDiscount();
    }

    /**
     * 割引後の金額計算
     * @return object 割引後の金額計算
     */
    public function priceAfterDiscountCalculation():void 
    {
        
        if (!$this->isDiscounted) return;

        $price = empty($this->ticket->getPriceAfterChange()) ? $this->ticket->getPrice() : $this->ticket->getPriceAfterChange();
        $this->ticket->setPriceAfterChange($price  * ((100 - 100 / $this->discountRate) / 100));
    }

    /**
     * 割引額を返す
     * @return int 割引額
     */
    public function getDiscountRate(): float
    {
        if (!$this->isDiscounted) return 0;
        return $this->ticket->getPrice() * ($this->discountRate / 100);
    }
    
    /**
     * 団体割引が適用されるか
     * @return bool
     */
    private function _isGroupDiscount(): bool {

        if ($this->ticket->getTotalPersonsForGroupDiscount() >= 10) return true; // 10人以上か確認

        return false;
    }
        
}

?>