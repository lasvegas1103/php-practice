<?php

require_once "./discount/GroupDiscount.php";
require_once "./discount/EveningRates.php";
require_once "./discount/MondaysAndWednesdaysDiscount.php";

/**
 * 割引処理を実行するクラス
 */
class DiscountContext
{
    private $discounts;
    private $ticket;

    function __construct(TicketBase $ticket)
    {
        $this->ticket = $ticket;
        $this->_addDiscounts();    
    }

    /**
     * 割引後を反映させる
     */
    public function priceAfterDiscountCalculation(): void
    {
        foreach($this->discounts as $discount)
        {
            $discount->priceAfterDiscountCalculation();
        }
    }

    /**
     * 割引額を取得
     */
    public function getDiscountRates(): array
    {
        $discountRates = [];
        foreach($this->discounts as $discount)
        {
            $discountRates[get_class($discount)] = $discount->getDiscountRate();
        }

        return $discountRates;
    }

    /**
     * インスタンス生成 
     */
    private function _addDiscounts(): void
    {
        $this->discounts = [
            new GroupDiscount($this->ticket),
            new EveningRates($this->ticket),
            new MondaysAndWednesdaysDiscount($this->ticket),
        ];
    }
}
?>