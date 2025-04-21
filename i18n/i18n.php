<?php

enum Language: string
{
    case EN = 'en';
    case FR = 'fr';
}

class BaseTranslationUnit 
{
    public function translate(string $str): string
    {
        return $str;
    }
}

class TranslationUnit extends BaseTranslationUnit
{
    public function __construct(
        private array $translations,
        private bool $throwOnMissing = false,
    ) {}

    public function translate(string $str): string
    {
        if (!isset($this->translations[$str]) && $this->throwOnMissing) {
            throw new RuntimeException("Failed to translate: $str");
        }

        return $this->translations[$str] ?? $str;
    }
}

class Translator
{
    private static array $instances = [];

    public static function translate(string $str, Language $from, Language $to): string
    {
        $translationUnit = self::$instances[$from->value][$to->value] ??= self::buildTranslationUnit($from, $to);

        return $translationUnit->translate($str);
    }

    private static function buildTranslationUnit(Language $from, Language $to): BaseTranslationUnit
    {
        if ($from === $to) {
            return new BaseTranslationUnit;
        }

        $translations = file_get_contents("./i18n/{$from->value}-{$to->value}.txt");
        $translations = explode("\n", $translations);

        $translationArray = [];

        foreach ($translations as $translation) {
            if (empty($translation) || $translation[0] === '#') {
                continue;
            }
            
            [$en, $target] = explode("\t", $translation);

            $translationArray[$en] = $target;
        }

        return new TranslationUnit($translationArray);
    }
}

function i18n(string $en, Language $target = LANG): string
{
    return Translator::translate($en, Language::EN, $target);
}