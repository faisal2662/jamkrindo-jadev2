<?php

namespace PhpOffice\PhpSpreadsheet\Writer;

require_once base_path('vendor/ZipStream/autoload.php');

use ZipStream\ZipStream;
use ZipStream\Option\Archive;

// use ZipStream\ZipStream;

class ZipStream3
{
    /**
     * @param resource $fileHandle
     */
    public static function newZipStream($fileHandle): ZipStream
    {
        return new ZipStream(
            enableZip64: false,
            outputStream: $fileHandle,
            sendHttpHeaders: false,
            defaultEnableZeroHeader: false,
        );
    }
}
