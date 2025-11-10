<?php

namespace App\Http\Livewire\Mentor;

use App\Models\Murid;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use Illuminate\Support\Facades\Auth;

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
            Column::make('Username', 'user.username')
                ->sortable()
                ->searchable(),

            Column::make('Sekolah', 'sekolah')
                ->sortable()
                ->searchable(),

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

            Column::make('Progress Modul', 'progress_moduls_count')
                ->sortable()
                ->format(function ($value) {
                    return $value ?? 0;
                }),

            Column::make('Ranking')
                ->label(function ($row) {
                    $leaderboard = $row->leaderboards()->where('mentor_id', Auth::user()->mentor->mentor_id)->first();
                    return $leaderboard ? $leaderboard->ranking_mentor : '-';
                }),

            Column::make('Last Activity')
                ->label(function ($row) {
                    $lastGame = $row->hasilGames()->latest('dimainkan_at')->first();
                    return $lastGame ? $lastGame->dimainkan_at->diffForHumans() : 'Belum ada aktivitas';
                }),

            Column::make('Tanggal Bergabung', 'created_at')
                ->sortable()
                ->format(function ($value) {
                    return $value->format('d M Y');
                }),

            Column::make('Aksi')
                ->label(function ($row) {
                    $actions = '<div class="flex space-x-2">';
                    $actions .= '<button wire:click="viewProgress(' . $row->murid_id . ')" class="px-3 py-1 text-xs bg-blue-500 text-white rounded hover:bg-blue-600">Progress</button>';
                    $actions .= '<button wire:click="viewGames(' . $row->murid_id . ')" class="px-3 py-1 text-xs bg-green-500 text-white rounded hover:bg-green-600">Games</button>';
                    $actions .= '<button wire:click="edit(' . $row->murid_id . ')" class="px-3 py-1 text-xs bg-yellow-500 text-white rounded hover:bg-yellow-600">Edit</button>';
                    $actions .= '<button wire:click="remove(' . $row->murid_id . ')" class="px-3 py-1 text-xs bg-red-500 text-white rounded hover:bg-red-600">Remove</button>';
                    $actions .= '</div>';

                    return $actions;
                })
                ->html(),
        ];
    }

    public function filters(): array
    {
        return [
            SelectFilter::make('Activity Level')
                ->options([
                    '' => 'Semua',
                    'active' => 'Aktif (7 hari terakhir)',
                    'inactive' => 'Tidak Aktif (>7 hari)',
                ])
                ->filter(function (Builder $builder, string $value) {
                    if ($value === 'active') {
                        $builder->whereHas('hasilGames', function ($q) {
                            $q->where('dimainkan_at', '>=', now()->subDays(7));
                        });
                    } elseif ($value === 'inactive') {
                        $builder->whereDoesntHave('hasilGames', function ($q) {
                            $q->where('dimainkan_at', '>=', now()->subDays(7));
                        });
                    }
                }),
        ];
    }

    public function builder(): Builder
    {
        $mentorId = Auth::user()->mentor->mentor_id;

        return Murid::query()
            ->where('mentor_id', $mentorId)
            ->with(['user', 'hasilGames', 'leaderboards'])
            ->withCount(['hasilGames', 'progressModuls']);
    }

    public function viewProgress($muridId)
    {
        $this->emit('viewMuridProgress', $muridId);
    }

    public function viewGames($muridId)
    {
        $this->emit('viewMuridGames', $muridId);
    }

    public function edit($muridId)
    {
        $this->emit('editMurid', $muridId);
    }

    public function remove($muridId)
    {
        $murid = Murid::find($muridId);
        if ($murid) {
            $murid->update(['mentor_id' => null]);
            $this->emit('muridUpdated', 'Murid berhasil dikeluarkan dari bimbingan!');
        }
    }
}
