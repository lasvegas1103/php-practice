<?php

require_once "./interface/ICalculate.php";
require_once "./discount/DisCountContext.php";
require_once "./higherRate/HigherRateContext.php";

/**
 * Calculateクラス
 */
class Calculate implements ICalculate
{
    private $ticket;
    private $discountContext;
    private $higherRateContext;

    function __construct(TicketBase $ticket)
    {
        $this->ticket = $ticket;
        $this->discountContext = new DiscountContext($this->ticket);
        $this->higherRateContext = new HigherRateContext($this->ticket);
    }

    /**
     * 販売合計金額計算取得
     */
    public function totalSalesPriceCalculation(): void
    {
        // 割引を反映
        $this->discountContext->priceAfterDiscountCalculation();
        // 割増を反映
        $this->higherRateContext->priceAfterHigherRateCalculation();

        $this->ticket->addTotalSalesPrice($this->ticket->getPriceAfterChange() * $this->ticket->getPersonCount());
    }

    /**
     * 金額変更前合計金額取得
     */
    public function totalPriceBeforePriceChangeCalculation(): void
    {
        $this->ticket->addTotalSalesPriceBeforeChange($this->ticket->getPrice() * $this->ticket->getPersonCount());
    }
}
?>