<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jawab Pertanyaan - IQRAIN</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;600;700&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            font-family: 'Fredoka', sans-serif;
            background-color: #ffffff;
            position: relative;
        }

        .pattern-bg {
            position: fixed;
            inset: 0;
            background-image: url('/images/pattern/pattern1.webp');
            background-size: 1000px;
            background-repeat: repeat;
            opacity: 0.5;
            pointer-events: none;
            z-index: 1;
        }

        .forgot-card-single {
            background: linear-gradient(135deg, #56B1F3, #D3F2FF);
            border-radius: 1.5rem;
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.2);
            position: relative;
            z-index: 10;
        }

        .btn-submit {
            background-color: #FF87AB;
            transition: all 0.2s ease-in-out;
            font-weight: 700;
        }
        .btn-submit:hover {
            background-color: #E85A8B;
            transform: translateY(-2px);
        }

        .alert-pink {
            background-color: #F7A0B3;
            color: #3d3d3d;
            border-radius: 0.75rem;
            padding: 1rem;
            border: 1px solid #f08097;
        }

        input:focus {
            outline: none;
            border-color: #5CB8E6;
            ring: 2px;
            ring-color: #5CB8E6;
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center p-4 relative ">

    <div class="pattern-bg"></div>

    <div class="w-full max-w-md relative z-20">

        <div class="forgot-card-single p-8 sm:p-10">

            <div class="text-center mb-6">
                <div class="w-20 h-20 bg-yellow-100 rounded-full mx-auto flex items-center justify-center mb-4">
                    <svg class="w-10 h-10 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.56-.994 1.113m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                        </path>
                    </svg>
                </div>

                <h1 class="text-3xl font-bold text-gray-800 mb-1">Jawab Pertanyaan</h1>
                <p class="text-gray-700 text-sm font-medium">Jawab pertanyaan keamanan kamu dengan benar</p>
            </div>

            @if ($errors->any())
                <div class="alert-pink mb-4 text-sm">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('error'))
                <div class="alert-pink mb-4 text-sm">
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.murid.verify') }}" class="space-y-6">
                @csrf

                <div>
                    <label class="block text-base font-bold text-gray-700 mb-2 flex items-center">
                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-blue-500 text-white text-sm font-bold mr-2">🎨</span>
                        {{ $pertanyaan }}
                    </label>

                    <input type="text" name="jawaban" required autofocus
                        class="w-full px-5 py-4 border-0 rounded-xl text-gray-800 text-lg"
                        style="background-color: white;"
                        placeholder="Jawaban kamu...">
                </div>

                <div class="bg-white/50 rounded-xl p-4 border border-blue-200">
                    <p class="text-xs text-gray-700">
                        💡 <strong>Tips:</strong> Huruf besar/kecil tidak masalah. Yang penting jawabannya sama!
                    </p>
                </div>

                <button type="submit"
                    class="w-full btn-submit text-white font-bold py-3 px-10 rounded-xl shadow-lg text-lg">
                    Verifikasi
                </button>

            </form>

            <div class="mt-6 text-center">
                <a href="{{ route('password.request') }}"
                    class="text-gray-700 hover:text-iqrain-dark-blue text-sm font-bold underline">
                    ← Kembali
                </a>
            </div>

        </div>

    </div>

</body>
</html>
