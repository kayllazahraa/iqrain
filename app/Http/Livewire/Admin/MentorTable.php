<?php

namespace App\Http\Livewire\Admin;

use App\Models\Mentor;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;

class MentorTable extends DataTableComponent
{
    protected $model = Mentor::class;

    public function configure(): void
    {
        $this->setPrimaryKey('mentor_id');
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
            Column::make('ID', 'mentor_id')
                ->sortable()
                ->searchable(),

            Column::make('Nama Lengkap', 'nama_lengkap')
                ->sortable()
                ->searchable(),

            Column::make('Username', 'user.username')
                ->sortable()
                ->searchable(),

            Column::make('Email', 'email')
                ->sortable()
                ->searchable(),

            Column::make('No. WhatsApp', 'no_wa')
                ->sortable()
                ->searchable(),

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

            Column::make('Jumlah Murid', 'murids_count')
                ->sortable()
                ->format(function ($value) {
                    return $value ?? 0;
                }),

            Column::make('Tanggal Daftar', 'created_at')
                ->sortable()
                ->format(function ($value) {
                    return $value->format('d M Y');
                }),

            Column::make('Aksi')
                ->label(function ($row) {
                    $actions = '<div class="flex space-x-2">';

                    if ($row->status_approval === 'pending') {
                        $actions .= '<button wire:click="approve(' . $row->mentor_id . ')" class="px-3 py-1 text-xs bg-green-500 text-white rounded hover:bg-green-600">Approve</button>';
                        $actions .= '<button wire:click="reject(' . $row->mentor_id . ')" class="px-3 py-1 text-xs bg-red-500 text-white rounded hover:bg-red-600">Reject</button>';
                    }

                    $actions .= '<button wire:click="edit(' . $row->mentor_id . ')" class="px-3 py-1 text-xs bg-blue-500 text-white rounded hover:bg-blue-600">Edit</button>';
                    $actions .= '<button wire:click="delete(' . $row->mentor_id . ')" class="px-3 py-1 text-xs bg-red-500 text-white rounded hover:bg-red-600">Delete</button>';
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
        ];
    }

    public function builder(): Builder
    {
        return Mentor::query()
            ->with(['user', 'murids'])
            ->withCount('murids');
    }

    public function approve($mentorId)
    {
        $mentor = Mentor::find($mentorId);
        if ($mentor) {
            $mentor->update([
                'status_approval' => 'approved',
                'tgl_persetujuan' => now(),
            ]);

            $this->emit('mentorUpdated', 'Mentor berhasil disetujui!');
        }
    }

    public function reject($mentorId)
    {
        $mentor = Mentor::find($mentorId);
        if ($mentor) {
            $mentor->update([
                'status_approval' => 'rejected',
                'alasan_tolak' => 'Ditolak oleh admin',
            ]);

            $this->emit('mentorUpdated', 'Mentor berhasil ditolak!');
        }
    }

    public function edit($mentorId)
    {
        $this->emit('editMentor', $mentorId);
    }

    public function delete($mentorId)
    {
        $mentor = Mentor::find($mentorId);
        if ($mentor) {
            $mentor->user->delete(); // This will cascade delete mentor
            $this->emit('mentorUpdated', 'Mentor berhasil dihapus!');
        }
    }
}
