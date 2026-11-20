<?php

namespace App\Traits;

trait FormatsPricing
{
    /**
     * Format a numeric amount to BDT currency string
     */
    public function formatBDT(float|int $amount, int $decimals = 0): string
    {
        return '৳' . number_format($amount, $decimals);
    }

    /**
     * Calculate percentage discount between regular and deal price
     */
    public function calculateDiscountPercent(float $regularPrice, float $dealPrice): int
    {
        if ($regularPrice <= 0 || $dealPrice >= $regularPrice) {
            return 0;
        }

        return (int) round((($regularPrice - $dealPrice) / $regularPrice) * 100);
    }

    /**
     * Calculate total savings
     */
    public function calculateSavings(float $regularPrice, float $dealPrice): float
    {
        return max(0.0, round($regularPrice - $dealPrice, 2));
    }
}
