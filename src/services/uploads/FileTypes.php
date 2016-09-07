<?php
namespace wajox\yii2base\services\uploads;

class FileTypes
{
    const TYPE_ID_UNKNOWN = 100;
    const TYPE_ID_ARCHIVE = 102;
    const TYPE_ID_DOCUMENT = 101;
    const TYPE_ID_BINARY = 102;
    const TYPE_ID_TEXT = 102;
    const TYPE_ID_AUDIO = 103;
    const TYPE_ID_VIDEO = 104;
    const TYPE_ID_IMAGE = 105;

    public static function getAvailableExtensions()
    {
        $extensions = array_merge(
            self::getImageExtensions(),
            self::getVideoExtensions(),
            self::getAudioExtensions(),
            self::getDocumentExtensions(),
            self::getTextExtensions(),
            self::getArchiveExtensions(),
            self::getBinaryExtensions()
        );

        return $extensions;
    }

    public static function getImageExtensions()
    {
        return ['jpg', 'jpeg', 'gif', 'bmp', 'png'];
    }

    public static function getArchiveExtensions()
    {
        return ['rar', 'zip', 'gz2', 'tar', 'gzip'];
    }

    public static function getDocumentExtensions()
    {
        return ['doc', 'docx', 'pdf', 'odt'];
    }

    public static function getTextExtensions()
    {
        return ['txt', 'text', 'json', 'html'];
    }

    public static function getBinaryExtensions()
    {
        return ['bin', 'exe'];
    }

    public static function getAudioExtensions()
    {
        return ['mp3', 'wav'];
    }

    public static function getVideoExtensions()
    {
        return ['mov', 'mp4', 'avi', 'wmv'];
    }

    public static function detectTypeIdByExtension($ext)
    {
        $ext = strtolower(trim($ext));

        if (in_array($ext, self::getImageExtensions())) {
            return self::TYPE_ID_IMAGE;
        }

        if (in_array($ext, self::getAudioExtensions())) {
            return self::TYPE_ID_AUDIO;
        }

        if (in_array($ext, self::getVideoExtensions())) {
            return self::TYPE_ID_VIDEO;
        }

        if (in_array($ext, self::getDocumentExtensions())) {
            return self::TYPE_ID_DOCUMENT;
        }

        if (in_array($ext, self::getTextExtensions())) {
            return self::TYPE_ID_TEXT;
        }

        if (in_array($ext, self::getArchiveExtensions())) {
            return self::TYPE_ID_ARCHIVE;
        }

        if (in_array($ext, self::getBinaryExtensions())) {
            return self::TYPE_ID_BINARY;
        }

        return self::TYPE_ID_UNKNOWN;
    }
}
