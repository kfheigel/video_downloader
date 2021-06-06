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
        preg_match('/\?v=[\S]*$|be\/[\S]*$/', $link, $match);
        return(substr($match[0], 3, 11));
    }

    public function videoTitle($link)
    {
        $videoTitle = explode('</title>', explode('<title>', file_get_contents($link))[1])[0];
        $videoTitle = substr(str_replace('amp;', '', $videoTitle), 0, -10);
        $videoTitle = substr(str_replace('&#39;', '\'', $videoTitle),0 );
        return $videoTitle;
    }
}
