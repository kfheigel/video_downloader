<?php

declare(strict_types=1);

namespace App\Service;

use YouTube\YouTubeDownloader;

class Downloader
{
    public function downloadVideo($link): array
    {
        $yt = new YouTubeDownloader();
        $links = [];
        $results = $yt->getDownloadLinks($link);

        foreach ($results as $result) {
            if ('Unknown' === $result['format'] || 'video' === $result['format']) {
                $key = array_search($result, $results);
                unset($results[$key]);
            }
        }
        return $results;
    }

    public function videoId($link)
    {
        preg_match('/[a-zA-Z0-9\-]*$/', $link, $match);

        return $match[0];
    }
}
