<?php

declare(strict_types=1);

namespace App\Service;

use YouTube\YouTubeDownloader;

class Downloader
{
    public function downloadVideo($link): array
    {
        $yt = new YouTubeDownloader();

        $links = $yt->getDownloadLinks($link);
        
        return $links;
    }

    public function videoId($link)
    {
        preg_match('/[a-zA-Z0-9]*$/', $link, $match);
        return $match[0];
    }

}

