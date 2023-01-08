<?php

require_once "TicketBase.php";

class SpecialTicket extends TicketBase
{

    protected $adultPrice = 600;
    protected $childPrice = 400;
    protected $seniorPrice = 500;
    private $totalSalesPrice;
    private $totalSalesPriceBeforeChange;

    function __construct(array $persons)
    {
        TicketBase::__construct($persons);
    }

    /**
     * 販売合計金額取得
     * @return int 販売合計金額
     */
    public function getTotalSalesPrice(): int
    {
        return $this->totalSalesPrice;
    }

    /**
     * 販売合計金額計算
     */
    public function addTotalSalesPrice(int $price): void
    {
        $this->totalSalesPrice += $price;
    }

    /**
     * 金額変更前合計金額取得
     * @return int 販売合計金額
     */
    public function getTotalSalesPriceBeforeChange(): int
    {
        return $this->totalSalesPriceBeforeChange;
    }

    /**
     * 金額変更前合計金額計算
     */
    public function addTotalSalesPriceBeforeChange(int $price): void
    {
        $this->totalSalesPriceBeforeChange += $price;
    }
}

?>