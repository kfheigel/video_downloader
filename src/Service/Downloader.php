<?php

declare(strict_types=1);

namespace App\Service;

use App\Athlon\YouTubeDownloader;

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
        preg_match('/\=[\S]*$/', $link, $match);
        if (($index = strpos($match[0], '&')) !== false) {
            return substr($match[0], 1, $index - 1);
        } else {
            return substr($match[0], 1);
        }

        return substr($match[0], 1);
    }

    public function videoTitle($link)
    {
        $videoTitle = explode('</title>', explode('<title>', file_get_contents($link))[1])[0];

        return substr(str_replace('amp;', '', $videoTitle), 0, -10);
    }
}
