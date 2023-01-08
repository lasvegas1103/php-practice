<?php
class PriceDetails
{
    private $priceDetailsCalc;
    private $totalDiscountRates;
    private $totalHigherRates;

    // function __construct(PriceDetailsCalc $priceDetailsCalc)
    // {
    //     $this->priceDetailsCalc = $priceDetailsCalc;
    // }

    /**
     * 割引額・割増額計算クラスの切り替え
     */
    public function attach(PriceDetailsCalc $priceDetailsCalc): void
    {
        $this->priceDetailsCalc = $priceDetailsCalc;
    }

    /**
     * 合計の割引額・割引増計算
     * @return array 合計の割引額・割引増
     */
    public function calcRates(): void
    {
        [$discountRates, $higherRates] = $this->priceDetailsCalc->execute();
        [$this->totalDiscountRates, $this->totalHigherRates] = $this->priceDetailsCalc->addDiscountAndHigherRates($this->totalDiscountRates,
                                                                                                                    $this->totalHigherRates,
                                                                                                                    $discountRates,
                                                                                                                    $higherRates);
    }

    /**
     * 金額変更明細作成
     * @return string 金額変更明細
     */
    public function create(): string
    {

        // 団体割引
        $groupDiscount = isset($this->totalDiscountRates["GroupDiscount"]) ? $this->totalDiscountRates["GroupDiscount"] : 0;
        // 夕方料金
        $eveningRate = isset($this->totalDiscountRates["EveningRates"]) ? $this->totalDiscountRates["EveningRates"] : 0;
        // 月・水料金
        $mondaysAndWednesdaysDiscount = isset($this->totalDiscountRates["MondaysAndWednesdaysDiscount"]) ? $this->totalDiscountRates["MondaysAndWednesdaysDiscount"] : 0;
        // 休日料金
        $holidayRate = isset($this->totalHigherRates["HolidayRates"]) ? $this->totalHigherRates["HolidayRates"] : 0;

        return <<<EOM

        ===== 金額変更明細 =====

        団体割引　　：{$groupDiscount}円引き
        夕方料金　　：{$eveningRate}円引き
        月・水料金　：{$mondaysAndWednesdaysDiscount}円引き
        休日料金　　：{$holidayRate}円増し

        =======================
EOM;
    }
}
?>