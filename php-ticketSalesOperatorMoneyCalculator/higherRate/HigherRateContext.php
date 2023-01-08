<?php

require_once "./higherRate/HolidayRates.php";

class HigherRateContext
{
    private $higherRates;
    private $ticket;

    function __construct(TicketBase $ticket)
    {
        $this->ticket = $ticket;
        $this->_addHigherRates();    
    }

    /**
     * 割増を反映させる
     */
    public function priceAfterHigherRateCalculation(): void
    {
        foreach($this->higherRates as $higherRate)
        {
            $higherRate->priceAfterHigherRateCalculation();
        }
    }

    /**
     * 割増額を取得
     */
    public function getHigherRates(): array
    {
        $higherRates = [];
        foreach($this->higherRates as $higherRate)
        {
            $higherRates[get_class($higherRate)] = 0;
            $higherRates[get_class($higherRate)] += $higherRate->getHigherRate();
        }

        return $higherRates;
    }

    /**
     * インスタンス生成 
     */
    private function _addHigherRates(): void
    {
        $this->higherRates = [
            new HolidayRates($this->ticket)
        ];
    }
}
?>