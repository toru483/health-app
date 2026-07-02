<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>体調管理システム - 一括登録</title>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;500;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>body { font-family: 'Noto Sans JP', sans-serif; }</style>
</head>
<body class="bg-slate-50 min-h-screen text-slate-800">

    <header class="bg-white border-b border-slate-200 sticky top-0 z-50 shadow-sm px-6 py-4 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <span class="text-3xl">📊</span>
            <div>
                <h1 class="text-xl font-bold text-slate-800 tracking-tight">VitalLog <span class="text-xs font-normal text-slate-500">体調管理システム</span></h1>
            </div>
        </div>
        
        <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-50 hover:bg-blue-100 text-blue-700 font-bold rounded-xl text-sm transition-all border border-blue-200/60 active:scale-95 shadow-sm">
            ← 服薬管理アプリへ戻る
        </a>
    </header>

    <main class="max-w-2xl mx-auto px-4 py-10 space-y-8">
        <div>
            <h2 class="text-2xl font-bold text-slate-800">📝 今日の体調を一括登録</h2>
            <p class="text-slate-500 text-sm mt-1">体重、血圧、血糖値をまとめて記録し、健康状態を維持しましょう。</p>
        </div>

        <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm">
            <form action="{{ route('vitals.store') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">⚖️ 体重</label>
                    <div class="relative rounded-xl shadow-sm">
                        <input type="number" step="0.1" name="weight" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all text-lg" placeholder="60.0">
                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-slate-400 font-bold">kg</div>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">🫀 血圧</label>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="relative rounded-xl shadow-sm">
                            <input type="number" name="blood_pressure_high" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all" placeholder="120">
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-slate-400 text-xs">最高 (SYS)</div>
                        </div>
                        <div class="relative rounded-xl shadow-sm">
                            <input type="number" name="blood_pressure_low" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all" placeholder="80">
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-slate-400 text-xs">最低 (DIA)</div>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">🩸 血糖値</label>
                    <div class="relative rounded-xl shadow-sm">
                        <input type="number" name="blood_sugar" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all text-lg" placeholder="100">
                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-slate-400 font-bold">mg/dL</div>
                    </div>
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full py-3.5 bg-emerald-600 text-white font-bold rounded-xl shadow-md hover:bg-emerald-700 transition-all text-center active:scale-[0.99]">
                        この内容で記録する ✨
                    </button>
                </div>
            </form>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                <h3 class="font-bold text-slate-800">📊 過去10日間の登録履歴</h3>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-slate-600">
                    <thead class="text-xs uppercase bg-slate-50 text-slate-500 border-b border-slate-100">
                        <tr>
                            <th class="px-6 py-3 font-medium">日付</th>
                            <th class="px-6 py-3 text-right font-medium">体重 (kg)</th>
                            <th class="px-6 py-3 text-right font-medium">最高血圧</th>
                            <th class="px-6 py-3 text-right font-medium">最低血圧</th>
                            <th class="px-6 py-3 text-right font-medium">血糖値</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($vitals as $vital)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="px-6 py-4 font-medium text-slate-900 whitespace-nowrap">
                                {{ $vital->created_at->format('Y/m/d') }}
                            </td>
                            <td class="px-6 py-4 text-right">{{ $vital->weight ?? '-' }}</td>
                            <td class="px-6 py-4 text-right">{{ $vital->blood_pressure_high ?? '-' }}</td>
                            <td class="px-6 py-4 text-right">{{ $vital->blood_pressure_low ?? '-' }}</td>
                            <td class="px-6 py-4 text-right text-slate-900 font-medium">{{ $vital->blood_sugar ?? '-' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-slate-400">
                                登録されたデータがまだありません。今日の体調を記録してみましょう！
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                    
                    @if($vitals->isNotEmpty())
                    <tfoot class="bg-emerald-50/40 border-t-2 border-emerald-100 font-bold text-emerald-900">
                        <tr>
                            <td class="px-6 py-3.5 text-emerald-800">10日間平均</td>
                            <td class="px-6 py-3.5 text-right">{{ $avgWeight ? number_format($avgWeight, 1) : '-' }}</td>
                            <td class="px-6 py-3.5 text-right">{{ $avgBpHigh ? number_format($avgBpHigh, 1) : '-' }}</td>
                            <td class="px-6 py-3.5 text-right">{{ $avgBpLow ? number_format($avgBpLow, 1) : '-' }}</td>
                            <td class="px-6 py-3.5 text-right text-emerald-950">{{ $avgSugar ? number_format($avgSugar, 1) : '-' }}</td>
                        </tr>
                    </tfoot>
                    @endif
                </table>
            </div>
        </div>
    </main>

</body>
</html>