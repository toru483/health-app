<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>服薬管理アプリ - ダッシュボード</title>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;500;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Noto Sans JP', sans-serif; }
        .highlight-line { border-left-width: 4px; border-left-color: #facc15; }
    </style>
</head>
<body class="bg-slate-50 min-h-screen text-slate-800">

    <header class="bg-white border-b border-slate-200 sticky top-0 z-50 shadow-sm px-6 py-4 flex flex-col sm:flex-row items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <span class="text-3xl">🏥</span>
            <div>
                <h1 class="text-xl font-bold text-slate-800 tracking-tight">MediSync <span class="text-xs font-normal text-slate-500">服薬管理システム</span></h1>
            </div>
        </div>
        
        <a href="{{ route('vitals.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 font-bold rounded-xl text-sm transition-all border border-emerald-200/60 active:scale-95 shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
            </svg>
            体調管理アプリへ切り替え (体重・血圧・血糖値) ⇄
        </a>
    </header>

    <div class="flex min-h-[calc(100vh-73px)]">
        
        <aside class="w-64 bg-white border-r border-slate-200 p-6 hidden md:flex flex-col justify-between shrink-0">
            <div class="space-y-8">
                <div>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-4">データ管理</p>
                    <nav class="space-y-1">
                        <a href="#medicine-management" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-bold bg-blue-50 text-blue-700 transition-colors">
                            <span>💊</span> お薬の管理
                        </a>
                        <a href="#hospital-management" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-slate-600 hover:bg-slate-50 hover:text-slate-900 transition-colors">
                            <span>🏢</span> 病院の管理
                        </a>
                    </nav>
                </div>

                <div>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-4">設定</p>
                    <nav class="space-y-1">
                        <a href="#settings" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-slate-600 hover:bg-slate-50 transition-colors">
                            <span>⚙️</span> アプリ設定
                        </a>
                    </nav>
                </div>
            </div>

            <div class="border-t border-slate-100 pt-4 text-xs text-slate-400">
                <p>MediSync v1.0.0</p>
            </div>
        </aside>

        <main class="flex-1 p-6 lg:p-8 max-w-5xl mx-auto w-full">
            
            @if(session('success'))
                <div class="mb-6">
                    <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded shadow-sm flex items-center justify-between">
                        <div class="flex items-center">
                            <svg class="h-5 w-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <p class="text-green-700 font-medium">{{ session('success') }}</p>
                        </div>
                        <button onclick="this.parentElement.parentElement.remove()" class="text-green-500 hover:text-green-700">
                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20"><path d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"></path></svg>
                        </button>
                    </div>
                </div>
            @endif

            <div class="mb-8 p-4 bg-indigo-50 border-l-4 border-indigo-500 rounded-r-xl shadow-sm flex items-center gap-4">
                <div class="bg-indigo-500 text-white p-2 rounded-lg shadow-inner">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <p class="text-indigo-900 font-bold">
                        現在は <span class="text-xl text-indigo-600 underline decoration-indigo-300 underline-offset-4">{{ $slotName }}</span> の服用時間帯です
                    </p>
                    <p class="text-indigo-600 text-xs mt-0.5">該当するお薬が黄色くハイライトされています</p>
                </div>
            </div>

            <section class="mb-10">
                <h2 class="text-lg font-bold text-slate-800 mb-4 flex items-center">
                    <span class="w-1.5 h-6 bg-blue-500 rounded-full mr-2.5"></span>
                    現在服用中のお薬
                </h2>

                @forelse($prescriptions as $prescription)
                    <div class="mb-6 bg-white shadow-sm rounded-2xl overflow-hidden border border-slate-200 transition-hover hover:shadow-md">
                        <div class="bg-slate-50/80 px-6 py-3 border-b border-slate-100 flex flex-wrap justify-between items-center gap-2">
                            <div>
                                <div class="flex items-center gap-2">
                                    <h3 class="text-sm font-bold text-slate-800">
                                        {{ $prescription->department->hospital->name }}
                                    </h3>
                                    <span class="bg-white border border-slate-200 text-slate-600 text-[10px] px-2 py-0.5 rounded shadow-sm">
                                        {{ $prescription->department->name }}
                                    </span>
                                </div>
                            </div>
                            @if($prescription->next_visit_date)
                                <div class="bg-rose-50 text-rose-600 text-[10px] font-bold px-2.5 py-1 rounded-full flex items-center border border-rose-100">
                                    次回予約：{{ is_object($prescription->next_visit_date) ? $prescription->next_visit_date->format('Y/m/d') : $prescription->next_visit_date }}
                                </div>
                            @endif
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="text-left text-[10px] font-bold text-slate-400 uppercase tracking-wider bg-slate-50/30 border-b border-slate-100">
                                        <th class="px-6 py-2.5">薬品名</th>
                                        <th class="px-6 py-2.5">1回量</th>
                                        <th class="px-6 py-2.5">服用時期</th>
                                        <th class="px-6 py-2.5 text-right">服用チェック</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @foreach($prescription->medicines as $medicine)
                                        @php
                                            $isTargetTime = in_array($currentSlotId, explode(',', $medicine->time_slots));
                                        @endphp
                                        
                                        <tr class="transition-colors {{ $isTargetTime ? 'bg-yellow-50/60 highlight-line' : 'hover:bg-slate-50/30' }}">
                                            <td class="px-6 py-3">
                                                <div class="flex items-center gap-2">
                                                    <div class="font-bold text-sm {{ $isTargetTime ? 'text-yellow-900' : 'text-slate-700' }}">
                                                        {{ $medicine->name }}
                                                    </div>
                                                    @if($isTargetTime)
                                                        <span class="animate-pulse bg-yellow-400 text-white text-[9px] px-1.5 py-0.5 rounded-sm font-black">NEXT</span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="px-6 py-3 text-slate-600 text-xs">
                                                {{ $medicine->dosage_amount }}<span class="text-[10px] ml-0.5 text-slate-400">{{ $medicine->dosage_unit }}</span>
                                            </td>
                                            <td class="px-6 py-3">
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-bold {{ $isTargetTime ? 'bg-yellow-200 text-yellow-800' : 'bg-blue-50 text-blue-700 border border-blue-100' }}">
                                                    @php
                                                        $slots = explode(',', $medicine->time_slots);
                                                        $names = array_map(fn($id) => [1=>'朝', 2=>'昼', 3=>'晩', 4=>'寝る前'][$id] ?? '随時', $slots);
                                                    @endphp
                                                    {{ implode('・', $names) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-3 text-right">
                                            @if($medicine->isTakenToday())
                                                <button disabled class="bg-gray-200 text-gray-400 text-xs font-medium py-1 px-3 rounded-full cursor-not-allowed">
                                                    服用済み
                                                </button>
                                            @else
                                                <form action="{{ route('medicine.take') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="medicine_id" value="{{ $medicine->id }}">
                                                    <button type="submit" class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold transition-all {{ $isTargetTime ? 'bg-yellow-500 hover:bg-yellow-600 text-white shadow-sm' : 'bg-blue-600 hover:bg-blue-700 text-white shadow-sm' }}">
                                                        飲んだ！
                                                    </button>
                                                </form>
                                            @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @empty
                    <div class="bg-white border-2 border-dashed border-slate-200 rounded-2xl p-8 text-center shadow-sm">
                        <p class="text-slate-500 text-sm">処方箋がまだ登録されていません。</p>
                    </div>
                @endforelse
            </section>

            <section class="mt-12">
                <h2 class="text-lg font-bold text-slate-800 mb-4 flex items-center">
                    <span class="w-1.5 h-6 bg-emerald-500 rounded-full mr-2.5"></span>
                    本日の服用履歴
                </h2>

                @forelse($todayLogs as $log)
                    <div class="relative pl-6 border-l-2 border-slate-200 last:border-l-0 pb-6 ml-3">
                        <div class="absolute -left-[7px] top-1.5 w-3 h-3 rounded-full bg-emerald-500 ring-4 ring-white"></div>
                        
                        <div class="bg-white rounded-xl p-4 border border-slate-200 shadow-sm flex items-center justify-between">
                            <div>
                                <span class="text-xs font-bold text-slate-400 bg-slate-100 px-2 py-0.5 rounded mr-2">
                                    {{ $log->taken_at->format('H:i') }}
                                </span>
                                <span class="font-bold text-slate-700 text-sm">
                                    {{ $log->medicine->name ?? '削除されたお薬' }}
                                </span>
                            </div>
                            <div class="text-xs text-emerald-600 font-bold flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                服用完了
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="bg-white rounded-2xl p-8 border border-slate-200 shadow-sm text-center text-sm text-slate-400">
                        <span class="text-2xl block mb-2">💤</span>
                        本日の服用履歴はまだありません。お薬を飲んだら「飲んだ！」ボタンを押してください。
                    </div>
                @endforelse
            </section>

        </main>
    </div>

</body>
</html>