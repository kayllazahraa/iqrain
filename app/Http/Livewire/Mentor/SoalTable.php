<?php

namespace App\Http\Livewire\Mentor;

use App\Models\SoalDragDrop;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use Illuminate\Support\Facades\Auth;

class SoalTable extends DataTableComponent
{
    protected $model = SoalDragDrop::class;

    public function configure(): void
    {
        $this->setPrimaryKey('soal_id');
        $this->setDefaultSort('created_at', 'desc');
        $this->setPerPageAccepted([10, 25, 50]);
        $this->setPerPage(10);
        $this->setSearchEnabled();
        $this->setColumnSelectEnabled();
        $this->setFilterLayoutSlideDown();
        $this->setLoadingPlaceholderEnabled();
        $this->setOfflineIndicatorEnabled();
    }

    public function columns(): array
    {
        return [
            Column::make('Pertanyaan', 'pertanyaan')
                ->sortable()
                ->searchable()
                ->format(function ($value) {
                    return strlen($value) > 50 ? substr($value, 0, 50) . '...' : $value;
                }),

            Column::make('Tingkatan', 'tingkatanIqra.nama_tingkatan')
                ->sortable()
                ->searchable(),

            Column::make('Opsi A', 'opsi_a')
                ->sortable(),

            Column::make('Opsi B', 'opsi_b')
                ->sortable(),

            Column::make('Opsi C', 'opsi_c')
                ->sortable(),

            Column::make('Opsi D', 'opsi_d')
                ->sortable(),

            Column::make('Jawaban Benar', 'jawaban_benar')
                ->sortable()
                ->format(function ($value) {
                    return '<span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">' . $value . '</span>';
                })
                ->html(),

            Column::make('Status', 'status_approval')
                ->sortable()
                ->format(function ($value) {
                    $badges = [
                        'pending' => '<span class="px-2 py-1 text-xs font-medium bg-yellow-100 text-yellow-800 rounded-full">Pending</span>',
                        'approved' => '<span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">Approved</span>',
                        'rejected' => '<span class="px-2 py-1 text-xs font-medium bg-red-100 text-red-800 rounded-full">Rejected</span>',
                    ];
                    return $badges[$value] ?? $value;
                })
                ->html(),

            Column::make('Dimainkan', 'hasil_games_count')
                ->sortable()
                ->format(function ($value) {
                    return $value ?? 0;
                }),

            Column::make('Success Rate')
                ->label(function ($row) {
                    $total = $row->hasilGames->count();
                    if ($total === 0) return '0%';

                    $correct = $row->hasilGames->where('skor', '>', 0)->count();
                    return round(($correct / $total) * 100) . '%';
                }),

            Column::make('Tanggal Dibuat', 'created_at')
                ->sortable()
                ->format(function ($value) {
                    return $value->format('d M Y');
                }),

            Column::make('Aksi')
                ->label(function ($row) {
                    $actions = '<div class="flex space-x-2">';
                    $actions .= '<button wire:click="edit(' . $row->soal_id . ')" class="px-3 py-1 text-xs bg-yellow-500 text-white rounded hover:bg-yellow-600">Edit</button>';
                    $actions .= '<button wire:click="view(' . $row->soal_id . ')" class="px-3 py-1 text-xs bg-blue-500 text-white rounded hover:bg-blue-600">View</button>';
                    $actions .= '<button wire:click="delete(' . $row->soal_id . ')" class="px-3 py-1 text-xs bg-red-500 text-white rounded hover:bg-red-600">Delete</button>';
                    $actions .= '</div>';

                    return $actions;
                })
                ->html(),
        ];
    }

    public function filters(): array
    {
        return [
            SelectFilter::make('Status')
                ->options([
                    '' => 'Semua Status',
                    'pending' => 'Pending',
                    'approved' => 'Approved',
                    'rejected' => 'Rejected',
                ])
                ->filter(function (Builder $builder, string $value) {
                    if ($value) {
                        $builder->where('status_approval', $value);
                    }
                }),

            SelectFilter::make('Tingkatan')
                ->options([
                    '' => 'Semua Tingkatan',
                    '1' => 'Iqra 1',
                    '2' => 'Iqra 2',
                    '3' => 'Iqra 3',
                    '4' => 'Iqra 4',
                    '5' => 'Iqra 5',
                    '6' => 'Iqra 6',
                ])
                ->filter(function (Builder $builder, string $value) {
                    if ($value) {
                        $builder->where('tingkatan_id', $value);
                    }
                }),
        ];
    }

    public function builder(): Builder
    {
        $mentorId = Auth::user()->mentor->mentor_id;

        return SoalDragDrop::query()
            ->where('mentor_id', $mentorId)
            ->with(['tingkatanIqra', 'hasilGames'])
            ->withCount('hasilGames');
    }

    public function edit($soalId)
    {
        $this->emit('editSoal', $soalId);
    }

    public function view($soalId)
    {
        $this->emit('viewSoal', $soalId);
    }

    public function delete($soalId)
    {
        $soal = SoalDragDrop::find($soalId);
        if ($soal) {
            $soal->delete();
            $this->emit('soalUpdated', 'Soal berhasil dihapus!');
        }
    }
}
