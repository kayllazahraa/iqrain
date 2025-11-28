<?php
// app/Livewire/Admin/Video/CreateVideo.php

namespace App\Livewire\Admin\Video;

use Livewire\Component;
use App\Models\VideoPembelajaran;
use App\Models\TingkatanIqra;

class CreateVideo extends Component
{
    public $tingkatan_id;
    public $judul_video;
    public $video_path;
    public $deskripsi;

    protected $rules = [
        'tingkatan_id' => 'required|exists:tingkatan_iqras,tingkatan_id',
        'judul_video' => 'required|string|max:255',
        'video_path' => ['required', 'url'],
        'deskripsi' => 'nullable|string|max:1000',
    ];

    protected $messages = [
        'tingkatan_id.required' => 'Tingkatan Iqra wajib dipilih.',
        'judul_video.required' => 'Judul video wajib diisi.',
        'video_path.required' => 'Link YouTube wajib diisi.',
        'video_path.url' => 'Link YouTube harus berupa URL yang valid.',
    ];

    public function save()
    {
        $this->validate();

        // Validasi manual untuk YouTube URL
        if (!$this->isYoutubeUrl($this->video_path)) {
            $this->addError('video_path', 'Link harus dari YouTube (youtube.com atau youtu.be).');
            return;
        }

        VideoPembelajaran::create([
            'tingkatan_id' => $this->tingkatan_id,
            'judul_video' => $this->judul_video,
            'video_path' => $this->video_path,
            'deskripsi' => $this->deskripsi,
        ]);

        session()->flash('success', 'Video berhasil ditambahkan! 🎉');

        $this->dispatch('videoCreated');
        $this->dispatch('reloadTable');

        return redirect()->route('admin.video.index');
    }

    /**
     * Check if URL is valid YouTube URL
     */
    private function isYoutubeUrl($url)
    {
        return preg_match('/^(https?:\/\/)?(www\.)?(youtube\.com|youtu\.be)\/.+$/', $url);
    }

    public function render()
    {
        $tingkatans = TingkatanIqra::orderBy('level')->get();

        return view('livewire.admin.video.create-video', [
            'tingkatans' => $tingkatans
        ]);
    }
}
