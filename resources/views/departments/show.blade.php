<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $department->name }} - 処方箋管理 | MediSync</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen">

    <!-- ナビゲーションバー（文脈維持型） -->
    <header class="bg-white border-b border-slate-200 sticky top-0 z-40 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <span class="text-2xl">📄</span>
                <h1 class="text-xl font-black tracking-tight text-slate-900">
                    MediSync <span class="text-sm font-normal text-slate-500">処方箋データ管理</span>
                </h1>
            </div>
            <!-- 親である病院の詳細画面へスマートに戻る動線 -->
            <a href="{{ route('hospitals.show', $department->hospital_id) }}" class="text-sm font-medium text-slate-600 hover:text-slate-900 transition-colors">
                ← {{ $department->hospital->name }} に戻る
            </a>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- フラッシュメッセージ -->
        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl flex items-center gap-3 shadow-sm">
                <span>✨</span>
                <p class="text-sm font-bold">{{ session('success') }}</p>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- 左カラム：現在の文脈（所属） & 処方箋追加フォーム -->
            <div class="space-y-6">
                <!-- 所属情報カード -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
                    <span class="text-xs font-bold uppercase tracking-wider text-indigo-600 bg-indigo-50 px-2.5 py-1 rounded-md">Medical Context</span>
                    <h2 class="text-xl font-bold text-slate-900 mt-3">🧬 {{ $department->name }}</h2>
                    <p class="text-sm text-slate-500 mt-1">医療機関: {{ $department->hospital->name }}</p>
                </div>

                <!-- 処方箋追加フォーム -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
                    <h3 class="text-base font-bold text-slate-900 mb-4 flex items-center gap-2">
                        <span>➕</span> 新しい処方箋を記録
                    </h3>
                    
                        <!-- フォーム部分の修正箇所 -->
                        <form action="{{ route('prescriptions.store') }}" method="POST" class="space-y-4">
                            @csrf
                            <input type="hidden" name="department_id" value="{{ $department->id }}">

                            <div>
                                <label for="prescribed_date" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">診察日 / 処方日</label>
                                <!-- 💡 name属性を prescribed_date に変更 -->
                                <input type="date" name="prescribed_date" id="prescribed_date" max="{{ date('Y-m-d') }}"
                                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all text-sm" required>
                                @error('prescribed_date')
                                    <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="next_visit_date" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">次回受診予定日（任意）</label>
                                <!-- 💡 新設カラム next_visit_date の入力欄を追加 -->
                                <input type="date" name="next_visit_date" id="next_visit_date"
                                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all text-sm">
                                @error('next_visit_date')
                                    <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="doctor_name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">担当医師名（任意）</label>
                                <input type="text" name="doctor_name" id="doctor_name" placeholder="例: 山田 太郎 先生" 
                                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all placeholder:text-slate-400 text-sm">
                                @error('doctor_name')
                                    <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <button type="submit" class="w-full bg-slate-900 hover:bg-slate-800 text-white font-bold py-2.5 px-4 rounded-xl transition-all shadow-sm hover:shadow text-sm">
                                処方箋データを登録
                            </button>
                        </form>
                </div>
            </div>

            <!-- 右カラム：登録されている処方箋一覧 -->
            <div class="lg:grid-cols-1 lg:col-span-2">
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm h-full">
                    <h3 class="text-base font-bold text-slate-900 mb-4 flex items-center gap-2">
                        <span>📋</span> 処方箋・お薬登録履歴
                    </h3>

                    @if($department->prescriptions->isEmpty())
                        <div class="flex flex-col items-center justify-center py-16 text-center border-2 border-dashed border-slate-200 rounded-xl bg-slate-50/50">
                            <span class="text-3xl mb-2">📋</span>
                            <p class="text-sm font-medium text-slate-500">処方箋がまだ登録されていません。</p>
                            <p class="text-xs text-slate-400 mt-1">左のフォームから、お薬手帳や領収書を元に最初の処方箋を登録してください。</p>
                        </div>
                    @else
                        <div class="space-y-4">
                            <!-- 右側の一覧表示（ループ部分）の修正箇所 -->
                            @foreach($department->prescriptions->sortByDesc('prescribed_date') as $prescription)
                                <div class="p-5 border border-slate-200 rounded-xl hover:border-indigo-300 hover:shadow-sm transition-all flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-slate-50/30">
                                    <div class="space-y-1">
                                        <div class="flex flex-wrap items-center gap-2">
                                            <!-- 💡 clinic_date から prescribed_date に変更 -->
                                            <span class="text-sm font-black text-slate-900 bg-white px-2.5 py-1 rounded-md border border-slate-200 shadow-sm">
                                                📅 {{ \Carbon\Carbon::parse($prescription->prescribed_date)->format('Y年m月d日') }}
                                            </span>
                                            
                                            <!-- 💡 次回受診日があればバッジで表示 -->
                                            @if($prescription->next_visit_date)
                                                <span class="text-xs font-medium text-emerald-700 bg-emerald-50 border border-emerald-200 px-2 py-0.5 rounded-md">
                                                    次回の目安: {{ \Carbon\Carbon::parse($prescription->next_visit_date)->format('Y/m/d') }}
                                                </span>
                                            @endif

                                            @if($prescription->doctor_name)
                                                <span class="text-xs font-medium text-slate-600 bg-slate-100 px-2 py-0.5 rounded">
                                                    主治医: {{ $prescription->doctor_name }}
                                                </span>
                                            @endif
                                        </div>
                                        <p class="text-xs text-slate-400 pt-1">登録薬剤数: {{ $prescription->medicines ? $prescription->medicines->count() : 0 }} 種類</p>
                                    </div>
                                    
                                    <div>
                                        <a href="{{ route('medicines.create', ['prescription_id' => $prescription->id]) }}" 
                                        class="w-full sm:w-auto text-center text-xs font-bold text-white bg-indigo-600 hover:bg-indigo-700 px-4 py-2 rounded-xl transition-colors shadow-sm block">
                                            💊 内服薬を追加・管理
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </main>

</body>
</html>