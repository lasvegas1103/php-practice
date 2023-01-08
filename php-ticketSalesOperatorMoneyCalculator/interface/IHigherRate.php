<?php
/**
 * HigherRateインターフェイス
 */
interface IHigherRate {

    public function priceAfterHigherRateCalculation(): void;
    public function getHigherRate(): int;
} 
?>