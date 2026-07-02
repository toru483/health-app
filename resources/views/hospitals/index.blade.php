<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>病院管理 - 一覧</title>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;500;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>body { font-family: 'Noto Sans JP', sans-serif; }</style>
</head>
<body class="bg-slate-50 min-h-screen text-slate-800">

    <header class="bg-white border-b border-slate-200 sticky top-0 z-50 shadow-sm px-6 py-4 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <span class="text-3xl">🏥</span>
            <div>
                <h1 class="text-xl font-bold text-slate-800 tracking-tight">HospitalLog <span class="text-xs font-normal text-slate-500">病院管理</span></h1>
            </div>
        </div>
        <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl text-sm transition-all active:scale-95">
            ← ダッシュボードへ戻る
        </a>
    </header>

    <main class="max-w-4xl mx-auto px-4 py-10 space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-slate-800">🏥 かかりつけ病院一覧</h2>
                <p class="text-slate-500 text-sm mt-1">診察や処方箋をもらった病院を管理します。</p>
            </div>
            <a href="{{ route('hospitals.create') }}" class="px-5 py-3 bg-blue-600 text-white font-bold rounded-xl shadow-md hover:bg-blue-700 transition-all active:scale-95 text-sm flex items-center gap-2">
                ＋ 新しい病院を登録
            </a>
        </div>

        @if(session('success'))
        <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl text-sm font-medium">
            ✨ {{ session('success') }}
        </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @forelse($hospitals as $hospital)
            <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm flex flex-col justify-between hover:border-blue-300 transition-all group">
                <div>
                    <div class="flex items-start justify-between">
                        <h3 class="text-lg font-bold text-slate-900 group-hover:text-blue-600 transition-colors">{{ $hospital->name }}</h3>
                        <span class="text-xs bg-slate-100 text-slate-600 px-2.5 py-1 rounded-full font-medium">医療機関</span>
                    </div>
                    
                    <div class="mt-4 space-y-2 text-sm text-slate-600">
                        <p class="flex items-center gap-2">
                            <span>📞</span> {{ $hospital->tel ?? '未登録' }}
                        </p>
                        <p class="flex items-start gap-2">
                            <span>📍</span> <span class="line-clamp-2">{{ $hospital->address ?? '未登録' }}</span>
                        </p>
                    </div>
                </div>

                <div class="mt-6 pt-4 border-t border-slate-100 flex justify-end">
                    <a href="{{ route('hospitals.show', $hospital) }}" class="text-sm font-bold text-blue-600 hover:text-blue-700 flex items-center gap-1">
                        詳細・受診科を見る ➔
                    </a>
                </div>
            </div>
            @empty
            <div class="col-span-full bg-white rounded-2xl p-12 border border-slate-200 text-center text-slate-400">
                <span class="text-4xl block mb-2">🏥</span>
                登録されている病院がまだありません。右上のボタンから登録してみましょう！
            </div>
            @endforelse
        </div>
    </main>

</body>
</html>