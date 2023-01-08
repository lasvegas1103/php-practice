<?php

require_once "./calculate/Calculate.php";
require_once "./ticket/RegularTicket.php";
require_once "./ticket/SpecialTicket.php";
require_once "./person/PersonType.php";
require_once "./priceDetails/PriceDetails.php";
require_once "./priceDetails/PriceDetailsCalc.php";

/**
 * 計算機だぜ！！！
 */
class TicketSalesOperatorMoneyCalculator {

    private $tickets;
    private $personType;
    private $priceDetails;
    private $regularTicket;
    private $specialTicket;

    function __construct(array $regularTicket, array $specialTicket)
    {
        $this->regularTicket = $regularTicket;
        $this->specialTicket = $specialTicket;

        // インスタンス生成
        $this->tickets = [
            new RegularTicket($this->regularTicket),
            new SpecialTicket($this->specialTicket),
        ];
        $this->personType = new PersonType();
        $this->priceDetails = new PriceDetails();
    }

    public function execute(): void {

        // 合計金額計算
        [$totalSalesPrice, $totalSalesPriceBeforeChange] = $this->calcPrice();
        // 金額変更明細作成
        $priceDetail = $this->createPriceDetail();

        $output = <<<EOM

        販売合計金額：{$totalSalesPrice}円
        金額変更前合計金額{$totalSalesPriceBeforeChange}円

        {$priceDetail}
EOM;

        echo $output;
    }

    /**
     * 販売合計金額・金額変更前合計金額計算
     * @return array 販売合計金額・金額変更前合計金額
     */
    public function calcPrice(): array
    {
        // 販売合計金額
        $totalSalesPrice = 0;
        // 金額変更前合計金額
        $totalSalesPriceBeforeChange = 0;
        foreach($this->tickets as $ticket)
        {
            foreach($this->personType->getPersonTypes() as $personType)
            {
                $ticket->setPriceAfterChange(0); // 初期化
                $ticket->setPrice($personType);
                $ticket->setPersonCount($personType);
                $ticket->setTotalPersonsForGroupDiscount([$this->regularTicket, $this->specialTicket]);

                // 金額計算
                $calc = new Calculate($ticket);
                $calc->totalSalesPriceCalculation();
                $calc->totalPriceBeforePriceChangeCalculation();
            }
            $totalSalesPrice = $totalSalesPrice + $ticket->getTotalSalesPrice();
            $totalSalesPriceBeforeChange = $totalSalesPriceBeforeChange + $ticket->getTotalSalesPriceBeforeChange();
        }

        return [$totalSalesPrice, $totalSalesPriceBeforeChange];
    }

    /**
     * 金額変更明細作成
     * @return string 金額変更明細
     */
    public function createPriceDetail(): string
    {
        foreach($this->tickets as $ticket)
        {
            foreach($this->personType->getPersonTypes() as $personType)
            {
                $ticket->setPrice($personType);
                $ticket->setPersonCount($personType);
                $ticket->setTotalPersonsForGroupDiscount([$this->regularTicket, $this->specialTicket]);

                // 差額計算
                $this->priceDetails->attach(new PriceDetailsCalc($ticket));
                $this->priceDetails->calcRates();
            }
        }
        return $this->priceDetails->create();
    }
}
?>