<?php
/**
 * Discountインターフェイス
 */
interface IDiscount {

    public function priceAfterDiscountCalculation(): void;
    public function getDiscountRate(): float;
} 
?>