<?php

namespace App\Http\Livewire\Admin;

use App\Models\Murid;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;

class MuridTable extends DataTableComponent
{
    protected $model = Murid::class;

    public function configure(): void
    {
        $this->setPrimaryKey('murid_id');
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
            Column::make('ID', 'murid_id')
                ->sortable()
                ->searchable(),

            Column::make('Username', 'user.username')
                ->sortable()
                ->searchable(),

            Column::make('Sekolah', 'sekolah')
                ->sortable()
                ->searchable(),

            Column::make('Mentor', 'mentor.nama_lengkap')
                ->sortable()
                ->searchable()
                ->format(function ($value) {
                    return $value ?? '<span class="text-gray-400">Belum ada mentor</span>';
                })
                ->html(),

            Column::make('Total Games', 'hasil_games_count')
                ->sortable()
                ->format(function ($value) {
                    return $value ?? 0;
                }),

            Column::make('Total Poin')
                ->label(function ($row) {
                    return $row->hasilGames->sum('total_poin');
                })
                ->sortable(),

            Column::make('Preferensi Terisi', 'preferensi_terisi')
                ->sortable()
                ->format(function ($value) {
                    return $value
                        ? '<span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">Ya</span>'
                        : '<span class="px-2 py-1 text-xs font-medium bg-red-100 text-red-800 rounded-full">Tidak</span>';
                })
                ->html(),

            Column::make('Tanggal Daftar', 'created_at')
                ->sortable()
                ->format(function ($value) {
                    return $value->format('d M Y');
                }),

            Column::make('Aksi')
                ->label(function ($row) {
                    $actions = '<div class="flex space-x-2">';
                    $actions .= '<button wire:click="viewProgress(' . $row->murid_id . ')" class="px-3 py-1 text-xs bg-blue-500 text-white rounded hover:bg-blue-600">Lihat Progress</button>';
                    $actions .= '<button wire:click="edit(' . $row->murid_id . ')" class="px-3 py-1 text-xs bg-yellow-500 text-white rounded hover:bg-yellow-600">Edit</button>';
                    $actions .= '<button wire:click="delete(' . $row->murid_id . ')" class="px-3 py-1 text-xs bg-red-500 text-white rounded hover:bg-red-600">Delete</button>';
                    $actions .= '</div>';

                    return $actions;
                })
                ->html(),
        ];
    }

    public function filters(): array
    {
        return [
            SelectFilter::make('Status Mentor')
                ->options([
                    '' => 'Semua',
                    'with_mentor' => 'Punya Mentor',
                    'without_mentor' => 'Belum Punya Mentor',
                ])
                ->filter(function (Builder $builder, string $value) {
                    if ($value === 'with_mentor') {
                        $builder->whereNotNull('mentor_id');
                    } elseif ($value === 'without_mentor') {
                        $builder->whereNull('mentor_id');
                    }
                }),

            SelectFilter::make('Preferensi')
                ->options([
                    '' => 'Semua',
                    '1' => 'Sudah Terisi',
                    '0' => 'Belum Terisi',
                ])
                ->filter(function (Builder $builder, string $value) {
                    if ($value !== '') {
                        $builder->where('preferensi_terisi', (bool) $value);
                    }
                }),
        ];
    }

    public function builder(): Builder
    {
        return Murid::query()
            ->with(['user', 'mentor', 'hasilGames'])
            ->withCount('hasilGames');
    }

    public function viewProgress($muridId)
    {
        $this->emit('viewMuridProgress', $muridId);
    }

    public function edit($muridId)
    {
        $this->emit('editMurid', $muridId);
    }

    public function delete($muridId)
    {
        $murid = Murid::find($muridId);
        if ($murid) {
            $murid->user->delete(); 
            $this->emit('muridUpdated', 'Murid berhasil dihapus!');
        }
    }
}
