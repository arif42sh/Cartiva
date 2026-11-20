<?php

namespace App\Rules;

use App\Models\GroupBuySession;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidGroupBuyQuantity implements ValidationRule
{
    protected ?int $sessionId;

    public function __construct(?int $sessionId = null)
    {
        $this->sessionId = $sessionId;
    }

    /**
     * Run the validation rule.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $quantity = (int) $value;

        if ($quantity < 1) {
            $fail('ক্রয়কৃত পণ্যের পরিমাণ কমপক্ষে ১ হতে হবে।');
            return;
        }

        if ($this->sessionId) {
            $session = GroupBuySession::find($this->sessionId);
            if ($session) {
                $remaining = $session->remainingSlots();
                if ($quantity > $remaining) {
                    $fail("এই গ্রুপে সর্বোচ্চ {$remaining}টি স্লট খালি রয়েছে।");
                }
            }
        }
    }
}
