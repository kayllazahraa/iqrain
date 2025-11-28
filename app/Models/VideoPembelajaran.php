<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoPembelajaran extends Model
{
    use HasFactory;

    protected $primaryKey = 'video_id';

    protected $fillable = [
        'tingkatan_id',
        'judul_video',
        'video_path',
        'deskripsi',
    ];

    public function tingkatanIqra()
    {
        return $this->belongsTo(TingkatanIqra::class, 'tingkatan_id', 'tingkatan_id');
    }

    public function getVideoUrlAttribute()
    {
        return $this->video_path;
    }

    public function getYoutubeEmbedUrlAttribute()
    {
        $url = $this->video_path;

        // Jika sudah format embed, return langsung
        if (strpos($url, 'youtube.com/embed/') !== false) {
            return $url;
        }

        // Extract video ID dari berbagai format
        $videoId = null;

        // Format: youtube.com/watch?v=VIDEO_ID
        if (preg_match('/youtube\.com\/watch\?v=([a-zA-Z0-9_-]+)/', $url, $matches)) {
            $videoId = $matches[1];
        }
        // Format: youtu.be/VIDEO_ID
        elseif (preg_match('/youtu\.be\/([a-zA-Z0-9_-]+)/', $url, $matches)) {
            $videoId = $matches[1];
        }
        // Format: youtube.com/embed/VIDEO_ID
        elseif (preg_match('/youtube\.com\/embed\/([a-zA-Z0-9_-]+)/', $url, $matches)) {
            $videoId = $matches[1];
        }

        // Jika berhasil extract video ID, return embed URL
        if ($videoId) {
            return "https://www.youtube.com/embed/{$videoId}";
        }

        // Default return original URL
        return $url;
    }

    /**
     * Get YouTube thumbnail
     */
    public function getYoutubeThumbnailAttribute()
    {
        $url = $this->video_path;
        $videoId = null;

        if (preg_match('/youtube\.com\/watch\?v=([a-zA-Z0-9_-]+)/', $url, $matches)) {
            $videoId = $matches[1];
        } elseif (preg_match('/youtu\.be\/([a-zA-Z0-9_-]+)/', $url, $matches)) {
            $videoId = $matches[1];
        } elseif (preg_match('/youtube\.com\/embed\/([a-zA-Z0-9_-]+)/', $url, $matches)) {
            $videoId = $matches[1];
        }

        if ($videoId) {
            return "https://img.youtube.com/vi/{$videoId}/maxresdefault.jpg";
        }

        return asset('images/default-video-thumbnail.png');
    }
}
