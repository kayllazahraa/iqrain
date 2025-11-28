<?php
// app/Livewire/Admin/Video/VideoTable.php

namespace App\Livewire\Admin\Video;

use App\Models\VideoPembelajaran;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;

class VideoTable extends DataTableComponent
{
    protected $model = VideoPembelajaran::class;

    protected $listeners = ['reloadTable' => '$refresh'];

    public function configure(): void
    {
        $this->setPrimaryKey('video_id')
            ->setDefaultSort('created_at', 'desc')
            ->setEmptyMessage('Tidak ada video yang ditemukan.')
            ->setPerPageAccepted([5, 10, 25, 50])
            ->setPerPage(10)
            ->setSearchEnabled()
            ->setSearchDebounce(500)
            ->setSearchPlaceholder('Cari video...')
            ->setFilterLayoutSlideDown();
    }

    public function builder(): Builder
    {
        return VideoPembelajaran::query()
            ->with(['tingkatanIqra'])
            ->select([
                'video_pembelajarans.video_id',
                'video_pembelajarans.tingkatan_id',
                'video_pembelajarans.judul_video',
                'video_pembelajarans.video_path',
                'video_pembelajarans.deskripsi',
                'video_pembelajarans.created_at',
            ]);
    }

    public function filters(): array
    {
        $tingkatanOptions = \App\Models\TingkatanIqra::pluck('nama_tingkatan', 'tingkatan_id')->toArray();

        return [
            SelectFilter::make('Tingkatan')
                ->options(['' => 'Semua Tingkatan'] + $tingkatanOptions)
                ->filter(function (Builder $builder, string $value) {
                    if ($value) {
                        $builder->where('tingkatan_id', $value);
                    }
                })
                ->setFilterPillTitle('Tingkatan'),
        ];
    }

    public function columns(): array
    {
        return [
            Column::make('No', 'video_id')
                ->sortable()
                ->format(fn($v, $r, $c) => $c->getRowIndex() + 1),

            Column::make('Thumbnail')
                ->label(function ($row) {
                    $thumbnail = $row->youtube_thumbnail;
                    $embedUrl = $row->youtube_embed_url;

                    return '
                        <div class="group relative w-32 h-20 rounded-lg overflow-hidden cursor-pointer" 
                             x-data="{ showVideo: false }">
                            <!-- Thumbnail -->
                            <img src="' . $thumbnail . '" 
                                 alt="Thumbnail" 
                                 class="w-full h-full object-cover"
                                 @click="showVideo = true">
                            
                            <!-- Play Button Overlay -->
                            <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center group-hover:bg-opacity-50 transition"
                                 @click="showVideo = true">
                                <svg class="w-12 h-12 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z"/>
                                </svg>
                            </div>

                            <!-- Video Modal -->
                            <div x-show="showVideo" 
                                 x-cloak
                                 class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-75"
                                 @click.away="showVideo = false"
                                 @keydown.escape.window="showVideo = false">
                                <div class="relative w-full max-w-4xl mx-4">
                                    <button @click="showVideo = false" 
                                            class="absolute -top-10 right-0 text-white hover:text-gray-300">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </button>
                                    <div class="relative pt-[56.25%]">
                                        <iframe x-show="showVideo"
                                                class="absolute inset-0 w-full h-full rounded-lg"
                                                :src="showVideo ? \'' . $embedUrl . '\' : \'\'"
                                                frameborder="0"
                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                                allowfullscreen>
                                        </iframe>
                                    </div>
                                </div>
                            </div>
                        </div>
                    ';
                })
                ->html()
                ->excludeFromColumnSelect(),

            Column::make('Judul Video', 'judul_video')
                ->sortable()
                ->searchable()
                ->format(function ($value, $row) {
                    return '
                        <div class="flex flex-col">
                            <span class="font-medium text-gray-900 dark:text-white">' . e($value) . '</span>
                            <span class="text-xs text-gray-500 dark:text-gray-400">' . e($row->tingkatanIqra->nama_tingkatan ?? '-') . '</span>
                        </div>
                    ';
                })
                ->html(),

            Column::make('Link YouTube', 'video_path')
                ->sortable()
                ->searchable()
                ->format(function ($value) {
                    $shortUrl = strlen($value) > 40 ? substr($value, 0, 40) . '...' : $value;
                    return '
                        <a href="' . e($value) . '" 
                           target="_blank" 
                           class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 flex items-center space-x-1">
                            <i class="fab fa-youtube text-red-600"></i>
                            <span class="text-xs">' . e($shortUrl) . '</span>
                        </a>
                    ';
                })
                ->html(),

            Column::make('Deskripsi', 'deskripsi')
                ->format(function ($value) {
                    if (!$value) return '<span class="text-gray-400 italic">-</span>';
                    $short = strlen($value) > 50 ? substr($value, 0, 50) . '...' : $value;
                    return '<span class="text-sm text-gray-600 dark:text-gray-400">' . e($short) . '</span>';
                })
                ->html(),

            Column::make('Aksi')
                ->label(function ($row) {
                    return view('components.column.video.actions', ['video' => $row]);
                })
                ->excludeFromColumnSelect(),
        ];
    }
}
