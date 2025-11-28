<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-4xl mx-auto">
    {{-- Preview Video --}}
    <div class="mb-6 p-4 bg-gray-50 dark:bg-gray-800 rounded-lg">
        <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">
            <i class="fas fa-eye text-pink-500 mr-2"></i>
            Preview Video Saat Ini
        </h3>
        <div class="relative w-full" style="padding-top: 56.25%;">
            <iframe 
                class="absolute inset-0 w-full h-full rounded-lg"
                src="{{ $video->youtube_embed_url }}"
                frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen>
            </iframe>
        </div>
    </div>

    <form wire:submit.prevent="update" class="space-y-6">
        
        {{-- Tingkatan Iqra --}}
        <div>
            <label for="tingkatan_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                <i class="fas fa-layer-group text-pink-500 mr-2"></i>
                Tingkatan Iqra <span class="text-red-500">*</span>
            </label>
            <select 
                id="tingkatan_id" 
                wire:model="tingkatan_id" 
                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-pink-500 dark:bg-gray-700 dark:text-white @error('tingkatan_id') border-red-500 @enderror"
            >
                <option value="">Pilih Tingkatan</option>
                @foreach($tingkatans as $tingkatan)
                    <option value="{{ $tingkatan->tingkatan_id }}">
                        {{ $tingkatan->nama_tingkatan }}
                    </option>
                @endforeach
            </select>
            @error('tingkatan_id')
                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        {{-- Judul Video --}}
        <div>
            <label for="judul_video" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                <i class="fas fa-heading text-blue-500 mr-2"></i>
                Judul Video <span class="text-red-500">*</span>
            </label>
            <input 
                type="text" 
                id="judul_video" 
                wire:model="judul_video" 
                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-pink-500 dark:bg-gray-700 dark:text-white @error('judul_video') border-red-500 @enderror"
                placeholder="Contoh: Pengenalan Huruf Alif"
            >
            @error('judul_video')
                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        {{-- Link YouTube --}}
        <div>
            <label for="video_path" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                <i class="fab fa-youtube text-red-600 mr-2"></i>
                Link YouTube <span class="text-red-500">*</span>
            </label>
            <input 
                type="url" 
                id="video_path" 
                wire:model="video_path" 
                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-pink-500 dark:bg-gray-700 dark:text-white @error('video_path') border-red-500 @enderror"
                placeholder="https://www.youtube.com/watch?v=..."
            >
            @error('video_path')
                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                <i class="fas fa-info-circle mr-1"></i>
                Format yang didukung: youtube.com/watch?v=... atau youtu.be/...
            </p>
        </div>

        {{-- Deskripsi --}}
        <div>
            <label for="deskripsi" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                <i class="fas fa-align-left text-purple-500 mr-2"></i>
                Deskripsi
            </label>
            <textarea 
                id="deskripsi" 
                wire:model="deskripsi" 
                rows="4"
                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-pink-500 dark:bg-gray-700 dark:text-white"
                placeholder="Deskripsi singkat tentang video..."
            ></textarea>
        </div>

        {{-- Buttons --}}
        <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-200 dark:border-gray-700">
            <a 
                href="{{ route('admin.video.index') }}" 
                class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition"
            >
                <i class="fas fa-times mr-2"></i>
                Batal
            </a>

            <button 
                type="submit" 
                class="px-6 py-2 bg-pink-500 text-white rounded-lg hover:bg-pink-600 transition disabled:opacity-50"
                wire:loading.attr="disabled"
            >
                <span wire:loading.remove wire:target="update">
                    <i class="fas fa-save mr-2"></i>
                    Update Video
                </span>
                <span wire:loading wire:target="update">
                    <i class="fas fa-spinner fa-spin mr-2"></i>
                    Menyimpan...
                </span>
            </button>
        </div>

    </form>
</div>