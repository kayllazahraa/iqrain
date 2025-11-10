<?php

namespace App\Http\Livewire\Mentor;

use App\Models\PermintaanBimbingan;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use Illuminate\Support\Facades\Auth;

class PermintaanBimbinganTable extends DataTableComponent
{
    protected $model = PermintaanBimbingan::class;

    public function configure(): void
    {
        $this->setPrimaryKey('permintaan_id');
        $this->setDefaultSort('tanggal_permintaan', 'desc');
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
            Column::make('Username Murid', 'murid.user.username')
                ->sortable()
                ->searchable(),

            Column::make('Sekolah', 'murid.sekolah')
                ->sortable()
                ->searchable(),

            Column::make('Status', 'status')
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

            Column::make('Tanggal Permintaan', 'tanggal_permintaan')
                ->sortable()
                ->format(function ($value) {
                    return $value->format('d M Y, H:i');
                }),

            Column::make('Tanggal Respons', 'tanggal_respons')
                ->sortable()
                ->format(function ($value) {
                    return $value ? $value->format('d M Y, H:i') : '-';
                }),

            Column::make('Games Played')
                ->label(function ($row) {
                    return $row->murid->hasilGames->count();
                }),

            Column::make('Total Poin')
                ->label(function ($row) {
                    return $row->murid->hasilGames->sum('total_poin');
                }),

            Column::make('Catatan', 'catatan')
                ->format(function ($value) {
                    return $value ? (strlen($value) > 30 ? substr($value, 0, 30) . '...' : $value) : '-';
                }),

            Column::make('Aksi')
                ->label(function ($row) {
                    $actions = '<div class="flex space-x-2">';

                    if ($row->status === 'pending') {
                        $actions .= '<button wire:click="approve(' . $row->permintaan_id . ')" class="px-3 py-1 text-xs bg-green-500 text-white rounded hover:bg-green-600">Approve</button>';
                        $actions .= '<button wire:click="reject(' . $row->permintaan_id . ')" class="px-3 py-1 text-xs bg-red-500 text-white rounded hover:bg-red-600">Reject</button>';
                    }

                    $actions .= '<button wire:click="viewDetail(' . $row->permintaan_id . ')" class="px-3 py-1 text-xs bg-blue-500 text-white rounded hover:bg-blue-600">Detail</button>';
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
                        $builder->where('status', $value);
                    }
                }),
        ];
    }

    public function builder(): Builder
    {
        $mentorId = Auth::user()->mentor->mentor_id;

        return PermintaanBimbingan::query()
            ->where('mentor_id', $mentorId)
            ->with(['murid.user', 'murid.hasilGames']);
    }

    public function approve($permintaanId)
    {
        $permintaan = PermintaanBimbingan::find($permintaanId);
        if ($permintaan && $permintaan->status === 'pending') {
            $permintaan->update([
                'status' => 'approved',
                'tanggal_respons' => now(),
            ]);

            // Update murid's mentor_id
            $permintaan->murid->update([
                'mentor_id' => $permintaan->mentor_id
            ]);

            $this->emit('permintaanUpdated', 'Permintaan berhasil disetujui!');
        }
    }

    public function reject($permintaanId)
    {
        $permintaan = PermintaanBimbingan::find($permintaanId);
        if ($permintaan && $permintaan->status === 'pending') {
            $permintaan->update([
                'status' => 'rejected',
                'tanggal_respons' => now(),
                'catatan' => 'Ditolak oleh mentor',
            ]);

            $this->emit('permintaanUpdated', 'Permintaan berhasil ditolak!');
        }
    }

    public function viewDetail($permintaanId)
    {
        $this->emit('viewPermintaanDetail', $permintaanId);
    }
}
