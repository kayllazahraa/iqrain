{{-- resources/views/pages/admin/approval/index.blade.php --}}
<x-layouts.dashboard title="Persetujuan Mentor">
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        
        {{-- Page Header --}}
        <div class="mb-8">
            <h1 class="text-2xl ">Persetujuan Mentor</h1>
        </div>
        <div class="mb-6">
            <h2 class="text-xl ">Daftar Persetujuan</h2>
        </div>

        {{-- Table Card --}}
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden">
            <div class="p-6">
                @livewire('admin.approval.approval-table')
            </div>
        </div>
    </div>

</x-layouts.dashboard>