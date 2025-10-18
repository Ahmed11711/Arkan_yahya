<?php

namespace App\Traits;

use Illuminate\Support\Str;

/**
 * Trait GenerateAffiliate
 * 
 * Automatically generates a unique and professional-looking affiliate code
 * for each user upon creation.
 * Format: PREFIX + random uppercase letters/numbers (e.g., AFF-8CHARCODE)
 */
trait GenerateAffiliate
{
    /**
     * Prefix to prepend to all affiliate codes
     */
    protected static string $affiliatePrefix = 'AFF-';

    /**
     * Boot the trait and attach creating event listener
     * Generates an affiliate code automatically if not already set
     */
    protected static function bootGenerateAffiliate(): void
    {
        static::creating(function ($model) {
            if (empty($model->affiliate_code)) {
                $model->affiliate_code = self::generateUniqueAffiliateCode();
            }
        });
    }

    /**
     * Generate a unique affiliate code
     *
     * @param int $length Length of the random part (excluding prefix)
     * @return string
     */
    private static function generateUniqueAffiliateCode(int $length = 8): string
    {
        do {
            // Generate random uppercase letters/numbers
            $randomCode = Str::upper(Str::random($length));
            $code = self::$affiliatePrefix . $randomCode;
        } while (self::affiliateCodeExists($code)); // Ensure uniqueness

        return $code;
    }

    /**
     * Check if the affiliate code already exists
     *
     * @param string $code
     * @return bool
     */
    private static function affiliateCodeExists(string $code): bool
    {
        return self::where('affiliate_code', $code)->exists();
    }
}
