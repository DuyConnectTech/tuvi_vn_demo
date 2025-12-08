<?php

namespace App\Services\Horoscope;

use App\Models\Horoscope;
use App\Models\HoroscopeReading;
use App\Models\Rule;
use Illuminate\Support\Collection;

class RuleEngine
{
    public function interpret(Horoscope $horoscope): void
    {
        // Clear old readings
        HoroscopeReading::where('horoscope_id', $horoscope->id)->delete();

        // Load Rules with Conditions
        $rules = Rule::where('is_active', true)->with('conditions')->get();

        // Load Horoscope Data fully
        $horoscope->load(['houses.stars', 'meta']);

        $readings = [];

        foreach ($rules as $rule) {
            if ($this->checkRule($rule, $horoscope)) {
                $readings[] = [
                    'horoscope_id' => $horoscope->id,
                    'rule_id' => $rule->id,
                    'text' => $this->formatContent($rule->text_template, $horoscope), // Changed 'content' to 'text'
                    'house_code' => $rule->target_house,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        if (!empty($readings)) {
            HoroscopeReading::insert($readings);
        }
    }

    protected function checkRule(Rule $rule, Horoscope $horoscope): bool
    {
        if ($rule->conditions->isEmpty()) {
            return false; // Rule without conditions is invalid or always true? Let's say invalid.
        }

        // Logic: All conditions MUST be true (AND). 
        // Future: Support OR groups.
        foreach ($rule->conditions as $condition) {
            if (!$this->checkCondition($condition, $horoscope)) {
                return false;
            }
        }

        return true;
    }

    protected function checkCondition($condition, Horoscope $horoscope): bool
    {
        $type = $condition->type;
        $value = $condition->value; // Array/JSON
        $houseCode = $condition->house_code;
        $operator = $condition->operator;

        // Extract values safely
        $starSlug = $value['star_slug'] ?? null;
        $metaKey = $value['meta_key'] ?? null;
        $targetValue = $value['value'] ?? null;

        switch ($type) {
            case 'star_in_house':
                return $this->checkStarInHouse($horoscope, $houseCode, $starSlug, $operator);

            case 'house_position':
                return $this->checkHousePosition($horoscope, $houseCode, $metaKey, $targetValue, $operator);

            default:
                return false;
        }
    }

    protected function checkStarInHouse(Horoscope $horoscope, ?string $houseCode, ?string $starSlug, string $operator): bool
    {
        if (!$houseCode || !$starSlug)
            return false;

        $house = $horoscope->houses->firstWhere('code', $houseCode);
        if (!$house)
            return false;

        $hasStar = $house->stars->contains('slug', $starSlug);

        if ($operator === 'exists')
            return $hasStar;
        if ($operator === 'not_exists')
            return !$hasStar;

        return false;
    }

    protected function checkHousePosition(Horoscope $horoscope, ?string $houseCode, ?string $metaKey, $targetValue, string $operator): bool
    {
        // Example: Check if Than Cu is at Tai Bach
        // Condition: house_code=TAI_BACH, meta_key=than_cung_code, value=TAI_BACH

        if ($metaKey) {
            $metaValue = $horoscope->meta->{$metaKey} ?? null;

            if ($operator === 'equals')
                return $metaValue == $targetValue;
            if ($operator === 'not_equals')
                return $metaValue != $targetValue;
        }

        return false;
    }

    protected function formatContent(string $template, Horoscope $horoscope): string
    {
        // Future: Replace variables like {{name}}, {{gender}}...
        return $template;
    }
}