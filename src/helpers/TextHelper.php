<?php
namespace wajox\yii2base\helpers;

class TextHelper
{
    public static function transliterate($text)
    {
        $converter = array(
            'а' => 'a',   'б' => 'b',   'в' => 'v',
            'г' => 'g',   'д' => 'd',   'е' => 'e',
            'ё' => 'e',   'ж' => 'zh',  'з' => 'z',
            'и' => 'i',   'й' => 'y',   'к' => 'k',
            'л' => 'l',   'м' => 'm',   'н' => 'n',
            'о' => 'o',   'п' => 'p',   'р' => 'r',
            'с' => 's',   'т' => 't',   'у' => 'u',
            'ф' => 'f',   'х' => 'h',   'ц' => 'c',
            'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',
            'ь' => '\'',  'ы' => 'y',   'ъ' => '\'',
            'э' => 'e',   'ю' => 'yu',  'я' => 'ya',

            'А' => 'A',   'Б' => 'B',   'В' => 'V',
            'Г' => 'G',   'Д' => 'D',   'Е' => 'E',
            'Ё' => 'E',   'Ж' => 'Zh',  'З' => 'Z',
            'И' => 'I',   'Й' => 'Y',   'К' => 'K',
            'Л' => 'L',   'М' => 'M',   'Н' => 'N',
            'О' => 'O',   'П' => 'P',   'Р' => 'R',
            'С' => 'S',   'Т' => 'T',   'У' => 'U',
            'Ф' => 'F',   'Х' => 'H',   'Ц' => 'C',
            'Ч' => 'Ch',  'Ш' => 'Sh',  'Щ' => 'Sch',
            'Ь' => '\'',  'Ы' => 'Y',   'Ъ' => '\'',
            'Э' => 'E',   'Ю' => 'Yu',  'Я' => 'Ya',
        );

        return str_replace(array_keys($converter), array_values($converter), $text);
    }

    public static function lower($text)
    {
        return mb_strtolower($text, 'UTF-8');
    }

    public static function upper($text)
    {
        return mb_strtoupper($text, 'UTF-8');
    }

    public static function filterWhitespaces($text)
    {
        $text = str_replace("\r", '', $text);
        $text = str_replace(["\n ", " \n"], "\n", $text);
        $text = preg_replace("/\n{2,}/", "\n", $text);
        $text = trim($text);

        return $text;
    }

    public static function str2url($text, $uniqId = null, $delimiter = '-')
    {
        $text = self::transliterate($text);
        $text = self::lower($text);
        $text = self::filterWhitespaces($text);
        $text = str_replace([' ', '-'], '_', $text);
        $text = preg_replace('/\W+/i', '', $text);
        $text = preg_replace('/_+/is', '-', $text);

        if ($uniqId !== null) {
            $text = $text.$delimiter.$uniqId;
        }

        return $text;
    }

    public static function shorter($text, $maxTextLength = 70, $endText = '...')
    {
        if ($maxTextLength && mb_strlen($text) > $maxTextLength) {
            $currentIndex = $maxTextLength;
            while (!in_array($text{$currentIndex}, [' ', "\t", "\n"])) {
                if ($currentIndex == 0) {
                    break;
                }

                $currentIndex--;
            }

            $text = mb_substr($text, 0, $currentIndex - 1);
            $text .= $endText;
        }

        return $text;
    }

    public static function plain2html($text)
    {
        $text = str_replace("\n", '<br/>', $text);

        return $text;
    }
}
