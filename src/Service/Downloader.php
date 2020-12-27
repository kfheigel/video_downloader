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
        $video_id = explode("?v=", $link);
        if (empty($video_id[1])){
            $video_id = explode("/v/", $link); 
        }
        if (empty($video_id[1])){
            $video_id = explode("be/", $link); 
        }
        if(strpos($video_id[1], "&"))
        {
            $video_id = explode("&", $video_id[1]);
        }elseif (strpos($video_id[1], "?")) {
            $video_id = explode("?", $video_id[1]);
        }
        return($video_id[0]);
    }

    public function videoTitle($link)
    {
        $videoTitle = explode('</title>', explode('<title>', file_get_contents($link))[1])[0];

        return substr(str_replace('amp;', '', $videoTitle), 0, -10);
    }
}
