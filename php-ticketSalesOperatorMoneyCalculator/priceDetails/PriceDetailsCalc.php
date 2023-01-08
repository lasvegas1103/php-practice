<?php
class PriceDetailsCalc
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
     * 割引額・割引増の合計を計算
     * @return array 合計の割引額、合計の割引増
     */
    public function execute(): array
    {
        $discounts = $this->discountContext->getDiscountRates();
        $higherRates = $this->higherRateContext->getHigherRates();

        return [$discounts, $higherRates];
    }

    /**
     * 割引額・割引増を計算
     * @param array $totalDiscounts
     * @param array $totalHigherRates
     * @param array $discoutns
     * @param array $higherRates
     */
    public function addDiscountAndHigherRates($totalDiscounts, $totalHigherRates, $discounts, $higherRates): array
    {
        if (empty($totalDiscounts) && empty($totalHigherRates))
        {
            return [$discounts, $higherRates];
        }

        foreach($discounts as $k => $v)
        {
            $totalDiscounts[$k] += $v * $this->ticket->getPersonCount();
        }

        foreach($higherRates as $k => $v)
        {
            $totalHigherRates[$k] += $v * $this->ticket->getPersonCount();
        }

        return [$totalDiscounts, $totalHigherRates];
    }
}
?>