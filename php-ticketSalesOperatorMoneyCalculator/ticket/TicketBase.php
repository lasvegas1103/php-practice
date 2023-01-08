<?php
abstract class TicketBase
{
    protected const AdultPersonType = "adult";
    protected const ChildPersonType = "child";
    protected const SeniorPersonType = "senior";
    protected $price;
    private $priceAfterChange;
    protected $ticket;
    protected $personCount;
    private $adultCount;
    private $childCount;
    private $seniorCount;
    private $totalPersonsForGroupDiscount;

    function __construct(array $ticket)
    {
        if (!empty($ticket) && count($ticket) === 3)
        {
            foreach($ticket as $personCount)
            {
                $option = ['options' => ['min_range' => 1]];
                if (!filter_var($personCount, FILTER_VALIDATE_INT, $option))
                {
                    throw new Exception("枚数を入力してください");
                }
            }
            $this->ticket = $ticket;
        } else {
            throw new Exception("枚数を入力してください");
        }
    }

    /**
     * 料金取得
     * @return int 料金
     */
    public function getPrice(): int
    {
        return $this->price;
    }

    /**
     * 料金をセット
     */
    public function setPrice(string $personType): void
    {
        $v = "{$personType}Price";
        $this->price = $this->{$v};
    }

    /**
     * 変更後の料金取得
     */
    public function getPriceAfterChange(): int
    {
        return $this->priceAfterChange;
    }

    /**
     * 変更後の料金をセット
     */
    public function setPriceAfterChange(int $price): void
    {
        $this->priceAfterChange = $price;
    }

    /**
     * 人数得
     * @return int 人数
     */
    public function getPersonCount(): int
    {
        return $this->personCount;
    }

    /**
     * 人数をセット
     */
    public function setPersonCount(string $personType): void
    {
        $this->personCount = $this->ticket[$personType];
    }

    /**
     * 団体割引用に合計人数を取得
     * @return float 体割引用に合計人数
     */
    public function getTotalPersonsForGroupDiscount(): float
    {
        return $this->totalPersonsForGroupDiscount;
    }

    /**
     * 団体割引用に合計人数を取得
     */
    public function setTotalPersonsForGroupDiscount(array $tickets): void
    {
        foreach($tickets as $ticket)
        {
            foreach($ticket as $personType => $personCount)
            {
                if ($personType === TicketBase::AdultPersonType)
                {
                    $this->adultCount += $personCount;
                } elseif ($personType === TicketBase::ChildPersonType)
                {
                    $this->childCount += $personCount;
                } elseif ($personType === TicketBase::SeniorPersonType)
                {
                    $this->seniorCount += $personCount;
                } else
                {
                    throw new Exception("チケットのタイプが不正です");
                }
            }
        }


        $this->totalPersonsForGroupDiscount =  $this->adultCount + ($this->childCount * 0.5) + $this->seniorCount;
    }

    /**
     * 販売合計金額取得
     * @return int 販売合計金額
     */
    abstract public function getTotalSalesPrice(): int;

    /**
     * 販売合計金額計算
     */
    abstract public function addTotalSalesPrice(int $price): void;

    /**
     * 金額変更前合計金額取得
     * @return int 販売合計金額
     */
    abstract public function getTotalSalesPriceBeforeChange(): int;
    /**
     * 金額変更前合計金額計算
     */
    abstract public function addTotalSalesPriceBeforeChange(int $price): void;
}
?>