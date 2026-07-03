<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $hospital->name }} - 詳細管理 | MediSync</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen">

    <!-- ナビゲーションバー -->
    <header class="bg-white border-b border-slate-200 sticky top-0 z-40 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <span class="text-2xl">🏥</span>
                <h1 class="text-xl font-black tracking-tight text-slate-900">MediSync <span class="text-sm font-normal text-slate-500">病院詳細管理</span></h1>
            </div>
            <a href="{{ route('hospitals.index') }}" class="text-sm font-medium text-slate-600 hover:text-slate-900 transition-colors">
                ← 病院一覧に戻る
            </a>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- フラッシュメッセージ -->
        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl flex items-center gap-3 shadow-sm animate-fade-in">
                <span>✨</span>
                <p class="text-sm font-bold">{{ session('success') }}</p>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- 左カラム：病院基本情報 & 受診科追加フォーム -->
            <div class="space-y-6">
                <!-- 病院情報カード -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
                    <span class="text-xs font-bold uppercase tracking-wider text-blue-600 bg-blue-50 px-2.5 py-1 rounded-md">Hospital Info</span>
                    <h2 class="text-2xl font-bold text-slate-900 mt-2">{{ $hospital->name }}</h2>
                    <p class="text-sm text-slate-500 mt-1">登録日: {{ $hospital->created_at->format('Y年m月d日') }}</p>
                </div>

                <!-- 受診科追加フォーム -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
                    <h3 class="text-lg font-bold text-slate-900 mb-4 flex items-center gap-2">
                        <span>➕</span> 診療科を追加する
                    </h3>
                    
                    <form action="{{ route('departments.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <!-- 親である病院のIDを隠しフィールドで送信 -->
                        <input type="hidden" name="hospital_id" value="{{ $hospital->id }}">

                        <div>
                            <label for="name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">診療科名</label>
                            <input type="text" name="name" id="name" placeholder="例: 内科、皮膚科、眼科" 
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all placeholder:text-slate-400 text-sm" required>
                            @error('name')
                                <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit" class="w-full bg-slate-900 hover:bg-slate-800 text-white font-bold py-2.5 px-4 rounded-xl transition-all shadow-sm hover:shadow text-sm">
                            この病院に診療科を登録
                        </button>
                    </form>
                </div>
            </div>

            <!-- 右カラム：登録されている受診科（診療科）一覧 -->
            <div class="lg:grid-cols-1 lg:col-span-2">
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm h-full">
                    <h3 class="text-lg font-bold text-slate-900 mb-4 flex items-center gap-2">
                        <span>📋</span> 開設中の診療科・処方一覧
                    </h3>

                    @if($hospital->departments->isEmpty())
                        <div class="flex flex-col items-center justify-center py-12 text-center border-2 border-dashed border-slate-200 rounded-xl bg-slate-50/50">
                            <span class="text-3xl mb-2">🏥</span>
                            <p class="text-sm font-medium text-slate-500">まだ診療科が登録されていません。</p>
                            <p class="text-xs text-slate-400 mt-1">左のフォームから最初の診療科を追加してください。</p>
                        </div>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($hospital->departments as $department)
                                <div class="p-4 border border-slate-200 rounded-xl hover:border-blue-300 hover:shadow-sm transition-all flex items-center justify-between bg-slate-50/50">
                                    <div>
                                        <h4 class="font-bold text-slate-900 text-base">🧬 {{ $department->name }}</h4>
                                        <p class="text-xs text-slate-400 mt-1">処方箋データ: 未連携</p>
                                    </div>
                                    <!-- 💡 将来、ここに「処方箋を追加する（Medicinesの追加画面へ）」ボタンを配置します -->
                                    <button class="text-xs font-bold text-blue-600 bg-white border border-slate-200 px-3 py-1.5 rounded-lg hover:bg-blue-50 hover:border-blue-200 transition-colors">
                                        データ管理
                                    </button>
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