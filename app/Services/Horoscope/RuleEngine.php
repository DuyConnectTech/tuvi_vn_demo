<?php

namespace App\Services\Horoscope;

use App\Models\Horoscope;
use App\Models\Rule;
use App\Models\RuleCondition;
use Illuminate\Support\Collection;

class RuleEngine
{
    /**
     * Evaluate all active rules against a given horoscope.
     *
     * @param Horoscope $horoscope The horoscope to evaluate. Must be eager loaded with necessary relations (e.g., houses, houseStars, chartFourPillars, meta).
     * @return Collection A collection of fulfilled rules.
     */
    public function evaluate(Horoscope $horoscope): Collection
    {
        // TODO: Ensure the horoscope is eager loaded with all necessary relations:
        // $horoscope->load(['houses.stars', 'chartFourPillars', 'meta']);

        $fulfilledRules = collect();

        // Get all active rules, ordered by priority
        $rules = Rule::where('is_active', true)
                     ->orderByDesc('priority')
                     ->get();

        foreach ($rules as $rule) {
            if ($this->checkRule($rule, $horoscope)) {
                $fulfilledRules->push($rule);
            }
        }

        return $fulfilledRules;
    }

    /**
     * Check if a specific rule is fulfilled by the horoscope.
     *
     * @param Rule $rule
     * @param Horoscope $horoscope
     * @return bool
     */
    protected function checkRule(Rule $rule, Horoscope $horoscope): bool
    {
        $rule->load('conditions'); // Ensure conditions are loaded for the rule

        if ($rule->conditions->isEmpty()) {
            return false; // A rule without conditions cannot be fulfilled
        }

        $isFulfilled = true;
        $currentOrGroup = null;
        $orGroupResults = [];

        foreach ($rule->conditions as $condition) {
            $conditionResult = $this->checkCondition($condition, $horoscope);

            if ($condition->or_group !== null) {
                // If it's part of an OR group
                if ($currentOrGroup === null || $currentOrGroup !== $condition->or_group) {
                    // Start of a new OR group
                    if ($currentOrGroup !== null && !empty($orGroupResults[$currentOrGroup])) {
                        // Previous OR group was not fulfilled, apply its result
                        $isFulfilled = $isFulfilled && array_sum($orGroupResults[$currentOrGroup]) > 0;
                    }
                    $currentOrGroup = $condition->or_group;
                    $orGroupResults[$currentOrGroup] = []; // Reset for new group
                }
                $orGroupResults[$currentOrGroup][] = $conditionResult;
            } else {
                // Not part of an OR group
                if ($currentOrGroup !== null && !empty($orGroupResults[$currentOrGroup])) {
                    // Previous OR group was not fulfilled, apply its result
                    $isFulfilled = $isFulfilled && array_sum($orGroupResults[$currentOrGroup]) > 0;
                    $currentOrGroup = null; // Reset OR group tracking
                }
                $isFulfilled = $isFulfilled && $conditionResult;
            }

            if (!$isFulfilled && $currentOrGroup === null) { // Optimization: If a non-OR condition fails, rule fails
                return false;
            }
        }

        // Check the last OR group if any
        if ($currentOrGroup !== null && !empty($orGroupResults[$currentOrGroup])) {
            $isFulfilled = $isFulfilled && array_sum($orGroupResults[$currentOrGroup]) > 0;
        }

        return $isFulfilled;
    }

    /**
     * Check a single condition against the horoscope.
     * This method will contain complex logic based on condition type, field, operator, and value.
     *
     * @param RuleCondition $condition
     * @param Horoscope $horoscope
     * @return bool
     */
    protected function checkCondition(RuleCondition $condition, Horoscope $horoscope): bool
    {
        // TODO: Implement the actual logic for various condition types and operators.
        // This is the most complex part. Examples:
        // - type 'has_star', field 'house.stars', operator '=', value 'Tử Vi'
        // - type 'can_chi_year', field 'can_chi_year', operator '=', value 'Giáp Tý'
        // - type 'house_element', field 'houses.MENH.element', operator '=', value 'Mộc'

        // Placeholder for now
        // dd($condition, $horoscope); // Debugging line

        $result = false; // Default to false

        $value = $condition->value;

        switch ($condition->type) {
            case 'has_star':
            case 'has_not_star':
            case 'has_any_star':
            case 'has_not_any_star':
            case 'has_star_pair':
            case 'has_not_star_pair':
                $result = $this->checkStarCondition($condition, $horoscope, $value);
                break;
            case 'can_chi_year':
            case 'can_chi_month':
            case 'can_chi_day':
            case 'can_chi_hour':
                $result = $this->checkCanChiCondition($condition, $horoscope, $value);
                break;
            case 'house_element':
            case 'house_life_phase':
                $result = $this->checkHouseAttributeCondition($condition, $horoscope, $value);
                break;
            case 'nap_am':
            case 'am_duong':
            case 'cuc':
                $result = $this->checkHoroscopeAttributeCondition($condition, $horoscope, $value);
                break;
            case 'age_at_view':
                $result = $this->checkAgeCondition($condition, $horoscope, $value);
                break;
            case 'custom':
                // For custom conditions, logic might be in the 'field' or 'value' itself,
                // or require a dedicated handler. This is for advanced use cases.
                // For now, let's assume 'value' contains a simple boolean or a string to evaluate.
                $result = (bool) $value; // Simplistic for custom
                break;
            default:
                // Fallback for unhandled types
                $result = false;
                break;
        }

        // Apply NOT logic for 'has_not_star', 'has_not_any_star', 'has_not_star_pair'
        if (str_starts_with($condition->type, 'has_not_')) {
            $result = !$result;
        }
        
        return $result;
    }

    /**
     * Helper to check star-related conditions.
     */
    protected function checkStarCondition(RuleCondition $condition, Horoscope $horoscope, $value): bool
    {
        // $condition->field might be 'house.MENH.stars', 'house.PHU_THE.stars' etc.
        // $value is the star name(s)
        $fieldParts = explode('.', $condition->field);
        if ($fieldParts[0] !== 'house' || !isset($fieldParts[1])) {
            return false; // Invalid field format for star condition
        }

        $houseCode = $fieldParts[1];
        $targetHouse = $horoscope->houses->firstWhere('code', $houseCode);

        if (!$targetHouse) {
            return false; // House not found in horoscope
        }
        
        $houseStars = $targetHouse->stars->pluck('name')->toArray(); // Get names of stars in the house

        switch ($condition->type) {
            case 'has_star':
                return in_array($value, $houseStars);
            case 'has_any_star':
                foreach ($value as $starName) {
                    if (in_array($starName, $houseStars)) {
                        return true;
                    }
                }
                return false;
            case 'has_star_pair':
                // For a pair, value should be an array of two star names
                if (!is_array($value) || count($value) !== 2) {
                    return false;
                }
                return in_array($value[0], $houseStars) && in_array($value[1], $houseStars);
            case 'has_not_star': // Handled by outer 'str_starts_with'
            case 'has_not_any_star': // Handled by outer 'str_starts_with'
            case 'has_not_star_pair': // Handled by outer 'str_starts_with'
            default:
                return false;
        }
    }

    /**
     * Helper to check Can Chi related conditions.
     */
    protected function checkCanChiCondition(RuleCondition $condition, Horoscope $horoscope, $value): bool
    {
        $canChiField = null;
        switch ($condition->type) {
            case 'can_chi_year':
                $canChiField = 'can_chi_year';
                break;
            case 'can_chi_month':
                $canChiField = 'can_chi_month';
                break;
            case 'can_chi_day':
                $canChiField = 'can_chi_day';
                break;
            case 'can_chi_hour':
                $canChiField = 'can_chi_hour';
                break;
        }

        if (!$canChiField || !$horoscope->{$canChiField}) {
            return false;
        }

        $horoscopeCanChi = $horoscope->{$canChiField};

        switch ($condition->operator) {
            case '=':
                return $horoscopeCanChi === $value;
            case '!=':
                return $horoscopeCanChi !== $value;
            case 'IN':
                return in_array($horoscopeCanChi, (array) $value);
            case 'NOT_IN':
                return !in_array($horoscopeCanChi, (array) $value);
            default:
                return false;
        }
    }

    /**
     * Helper to check horoscope house attribute conditions (element, life_phase).
     */
    protected function checkHouseAttributeCondition(RuleCondition $condition, Horoscope $horoscope, $value): bool
    {
        // Field format expected: 'houses.{HOUSE_CODE}.{ATTRIBUTE}' (e.g., houses.MENH.element)
        // Or 'house.{HOUSE_CODE}.{ATTRIBUTE}' (singular) - let's support both for flexibility
        $fieldParts = explode('.', $condition->field);
        
        // Validation: must have at least 3 parts: prefix, house_code, attribute
        if (count($fieldParts) < 3) {
            return false;
        }

        // $fieldParts[0] is prefix (house/houses) - ignored
        $houseCode = $fieldParts[1];
        $attribute = $fieldParts[2]; // e.g., 'element', 'life_phase', 'branch'

        $targetHouse = $horoscope->houses->firstWhere('code', $houseCode);

        if (!$targetHouse || !isset($targetHouse->{$attribute})) {
            return false;
        }

        $houseAttributeValue = $targetHouse->{$attribute};

        switch ($condition->operator) {
            case '=':
                return $houseAttributeValue == $value; // Use loose comparison for string/int flexibility
            case '!=':
                return $houseAttributeValue != $value;
            case 'IN':
                return in_array($houseAttributeValue, (array) $value);
            case 'NOT_IN':
                return !in_array($houseAttributeValue, (array) $value);
            case 'CONTAINS':
                return str_contains((string)$houseAttributeValue, (string)$value);
            case 'NOT_CONTAINS':
                return !str_contains((string)$houseAttributeValue, (string)$value);
            default:
                return false;
        }
    }

    /**
     * Helper to check main horoscope attributes (nap_am, am_duong, cuc).
     */
    protected function checkHoroscopeAttributeCondition(RuleCondition $condition, Horoscope $horoscope, $value): bool
    {
        $attribute = $condition->field; // e.g., 'nap_am', 'am_duong', 'cuc'

        if (!$horoscope->{$attribute}) {
            return false;
        }

        $horoscopeAttributeValue = $horoscope->{$attribute};

        switch ($condition->operator) {
            case '=':
                return $horoscopeAttributeValue == $value;
            case '!=':
                return $horoscopeAttributeValue != $value;
            case 'IN':
                return in_array($horoscopeAttributeValue, (array) $value);
            case 'NOT_IN':
                return !in_array($horoscopeAttributeValue, (array) $value);
            case 'CONTAINS':
                return str_contains((string)$horoscopeAttributeValue, (string)$value);
            case 'NOT_CONTAINS':
                return !str_contains((string)$horoscopeAttributeValue, (string)$value);
            default:
                return false;
        }
    }

    /**
     * Helper to check age conditions.
     */
    protected function checkAgeCondition(RuleCondition $condition, Horoscope $horoscope, $value): bool
    {
        // This assumes 'age_at_view' is available in Horoscope->meta or directly calculated.
        // For simplicity, let's assume horoscope has an 'age' attribute or similar.
        // In a real scenario, Horoscope Meta might have age.
        $currentAge = $horoscope->view_year - $horoscope->birth_gregorian->year; // Simplified age calculation

        if (!is_numeric($currentAge)) {
            return false;
        }

        switch ($condition->operator) {
            case '=':
                return $currentAge == $value;
            case '!=':
                return $currentAge != $value;
            case '>':
                return $currentAge > $value;
            case '<':
                return $currentAge < $value;
            case '>=':
                return $currentAge >= $value;
            case '<=':
                return $currentAge <= $value;
            default:
                return false;
        }
    }
}
