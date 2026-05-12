<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>健康管理アプリ - ダッシュボード</title>
    <!-- Google Fonts: 日本語を美しく表示 -->
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;500;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Noto Sans JP', sans-serif; }
        /* ハイライト時の左端のアクセント線 */
        .highlight-line { border-left-width: 4px; border-left-color: #facc15; }
    </style>
</head>
<body class="bg-slate-50 min-h-screen pb-12">

    <!-- 通知メッセージエリア -->
    @if(session('success'))
        <div class="max-w-4xl mx-auto mt-6 px-4">
            <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded shadow-sm flex items-center justify-between">
                <div class="flex items-center">
                    <svg class="h-5 w-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <p class="text-green-700 font-medium">{{ session('success') }}</p>
                </div>
                <button onclick="this.parentElement.parentElement.remove()" class="text-green-500 hover:text-green-700">
                    <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20"><path d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"></path></svg>
                </button>
            </div>
        </div>
    @endif

    <main class="container mx-auto px-4 py-8 max-w-4xl">
        
        <!-- ヘッダーセクション -->
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-800 flex items-center gap-2">
                    <span class="text-3xl">🏥</span> 健康管理ダッシュボード
                </h1>
                <p class="text-slate-500 text-sm mt-1">今日の服用状況と健康ログを管理しましょう</p>
            </div>
            <a href="{{ route('hospitals.index') }}" class="inline-flex items-center justify-center px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg transition-all shadow-md hover:shadow-lg active:scale-95">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                新しい通院・処方を記録
            </a>
        </div>

        <!-- 【追記】現在時刻の服用タイミング通知 -->
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

        <!-- 概要カード -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 relative overflow-hidden">
                <div class="absolute top-0 right-0 p-3 opacity-10 text-blue-600">
                    <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 20 20"><path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"></path></svg>
                </div>
                <h2 class="font-bold text-slate-700 mb-2 flex items-center">💊 最近の服薬</h2>
                <p class="text-sm text-slate-400">本日の服用済み: 0件</p>
                <div class="mt-4 text-xs text-blue-600 font-bold hover:underline cursor-pointer">履歴を見る →</div>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 relative overflow-hidden">
                <div class="absolute top-0 right-0 p-3 opacity-10 text-green-600">
                    <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 20 20"><path d="M2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"></path></svg>
                </div>
                <h2 class="font-bold text-slate-700 mb-2 flex items-center">📊 測定ログ</h2>
                <p class="text-sm text-slate-400">血圧・体重の未入力があります</p>
                <div class="mt-4 text-xs text-green-600 font-bold hover:underline cursor-pointer">測定を入力する →</div>
            </div>
        </div>

        <!-- お薬セクション -->
        <section>
            <h2 class="text-xl font-bold text-slate-800 mb-6 flex items-center">
                <span class="w-2 h-8 bg-blue-500 rounded-full mr-3"></span>
                現在服用中のお薬
            </h2>

            @forelse($prescriptions as $prescription)
                <div class="mb-8 bg-white shadow-sm rounded-2xl overflow-hidden border border-slate-200 transition-hover hover:shadow-md">
                    <!-- 処方箋ヘッダー -->
                    <div class="bg-slate-50 px-6 py-4 border-b border-slate-100 flex flex-wrap justify-between items-center gap-2">
                        <div>
                            <div class="flex items-center gap-2">
                                <h3 class="text-lg font-bold text-slate-800">
                                    {{ $prescription->department->hospital->name }}
                                </h3>
                                <span class="bg-white border border-slate-200 text-slate-600 text-xs px-2 py-0.5 rounded shadow-sm">
                                    {{ $prescription->department->name }}
                                </span>
                            </div>
                            <div class="flex items-center mt-1 text-xs text-slate-400">
                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                処方日：{{ is_object($prescription->prescribed_date) ? $prescription->prescribed_date->format('Y/m/d') : $prescription->prescribed_date }}
                            </div>
                        </div>
                        
                        @if($prescription->next_visit_date)
                            <div class="bg-rose-50 text-rose-600 text-xs font-bold px-3 py-1.5 rounded-full flex items-center border border-rose-100">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path></svg>
                                次回予約：{{ is_object($prescription->next_visit_date) ? $prescription->next_visit_date->format('Y/m/d') : $prescription->next_visit_date }}
                            </div>
                        @endif
                    </div>

                    <!-- 薬のリスト -->
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="text-left text-[11px] font-bold text-slate-400 uppercase tracking-wider bg-slate-50/50">
                                    <th class="px-6 py-3">薬品名</th>
                                    <th class="px-6 py-3">1回量</th>
                                    <th class="px-6 py-3">服用時期</th>
                                    <th class="px-6 py-3 text-right">服用チェック</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach($prescription->medicines as $medicine)
                                    @php
                                        // 【追記】現在時刻と薬の登録タイミング(time_slots)を比較
                                        // $medicine->time_slots には "1,3" のような文字列が入っている想定です
                                        $isTargetTime = in_array($currentSlotId, explode(',', $medicine->time_slots));
                                    @endphp
                                    
                                    <!-- 【追記】ハイライト条件に応じたクラス切り替え -->
                                    <tr class="transition-colors {{ $isTargetTime ? 'bg-yellow-50 highlight-line' : 'hover:bg-slate-50/30' }}">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-2">
                                                <div class="font-bold {{ $isTargetTime ? 'text-yellow-900' : 'text-slate-700' }}">
                                                    {{ $medicine->name }}
                                                </div>
                                                @if($isTargetTime)
                                                    <span class="animate-pulse bg-yellow-400 text-white text-[9px] px-1.5 py-0.5 rounded-sm font-black">NEXT</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-slate-600 text-sm">
                                            {{ $medicine->dosage_amount }}<span class="text-xs ml-0.5 text-slate-400">{{ $medicine->dosage_unit }}</span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-bold {{ $isTargetTime ? 'bg-yellow-200 text-yellow-800' : 'bg-blue-50 text-blue-700 border border-blue-100' }}">
                                                @php
                                                    // 数字のカンマ区切りを日本語名に変換
                                                    $slots = explode(',', $medicine->time_slots);
                                                    $names = array_map(fn($id) => [1=>'朝', 2=>'昼', 3=>'晩', 4=>'寝る前'][$id] ?? '随時', $slots);
                                                @endphp
                                                {{ implode('・', $names) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                        @if($medicine->isTakenToday())
                                            <button disabled class="bg-gray-300 text-gray-500 text-xs font-bold py-1.5 px-4 rounded-full cursor-not-allowed">
                                                服用済み
                                            </button>
                                        @else
                                            <form action="{{ route('medicine.take') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="medicine_id" value="{{ $medicine->id }}">
                                                <button type="submit" class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-bold transition-all {{ $isTargetTime ? 'bg-yellow-500 hover:bg-yellow-600 text-white shadow-md' : 'bg-blue-600 hover:bg-blue-700 text-white shadow-sm' }}">
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
                <!-- データがない場合の表示（Empty State） -->
                <div class="bg-white border-2 border-dashed border-slate-200 rounded-2xl p-12 text-center shadow-sm">
                    <div class="bg-slate-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <h3 class="text-slate-800 font-bold text-lg">処方箋がまだ登録されていません</h3>
                    <p class="text-slate-500 mt-2 mb-6">病院で受け取った処方箋を登録すると、ここにお薬が表示されます。</p>
                    <a href="{{ route('hospitals.index') }}" class="text-blue-600 font-bold hover:underline">病院を登録して始める →</a>
                </div>
            @endforelse
        </section>

    </main>
</body>
</html>