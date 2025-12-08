<?php

namespace App\Enums;

enum Chi: int
{
    case TY = 0;
    case SUU = 1;
    case DAN = 2;
    case MAO = 3;
    case THIN = 4;
    case TI = 5; // Tỵ
    case NGO = 6;
    case MUI = 7;
    case THAN = 8;
    case DAU = 9;
    case TUAT = 10;
    case HOI = 11;

    /**
     * Get the Vietnamese label for the Chi.
     */
    public function label(): string
    {
        return match($this) {
            self::TY => 'Tý',
            self::SUU => 'Sửu',
            self::DAN => 'Dần',
            self::MAO => 'Mão',
            self::THIN => 'Thìn',
            self::TI => 'Tỵ',
            self::NGO => 'Ngọ',
            self::MUI => 'Mùi',
            self::THAN => 'Thân',
            self::DAU => 'Dậu',
            self::TUAT => 'Tuất',
            self::HOI => 'Hợi',
        };
    }

    /**
     * Get the slug for the Chi (used in CSS classes and file names).
     * Mapped to match existing seeder conventions (e.g., Tỵ -> 'ti').
     */
    public function slug(): string
    {
        return match($this) {
            self::TY => 'ty',
            self::SUU => 'suu',
            self::DAN => 'dan',
            self::MAO => 'mao',
            self::THIN => 'thin',
            self::TI => 'ti',
            self::NGO => 'ngo',
            self::MUI => 'mui',
            self::THAN => 'than',
            self::DAU => 'dau',
            self::TUAT => 'tuat',
            self::HOI => 'hoi',
        };
    }

    /**
     * Find Enum instance by its Label (e.g. "Tý").
     */
    public static function fromLabel(string $label): ?self
    {
        foreach (self::cases() as $case) {
            if ($case->label() === $label) {
                return $case;
            }
        }
        return null;
    }
}
