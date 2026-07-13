<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>処方薬の追加 - MediSync</title>
    <!-- Tailwind CSS CDN (コンポーネントエラーを回避しつつスタイルを適用) -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-slate-50 min-h-screen text-slate-800">

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- パンくずリスト -->
            <nav class="flex mb-6 text-sm text-slate-500" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li><span class="hover:text-teal-600 font-medium">{{ $prescription->department->hospital->name }}</span></li>
                    <li><svg class="w-3 h-3 mx-1 text-slate-400" fill="currentColor" viewBox="0 0 20 20"><path d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"/></svg></li>
                    <li><a href="{{ route('departments.show', $prescription->department->id) }}" class="hover:text-teal-600 font-medium">{{ $prescription->department->name }}</a></li>
                    <li><svg class="w-3 h-3 mx-1 text-slate-400" fill="currentColor" viewBox="0 0 20 20"><path d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"/></svg></li>
                    <li class="text-slate-700 font-bold" aria-current="page">処方薬の追加</li>
                </ol>
            </nav>

            <!-- 2カラムレイアウトコンテナ -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- 左カラム：現在の処方文脈（インフォメーション） -->
                <div class="lg:col-span-1 bg-white p-6 rounded-xl shadow-sm border border-slate-200 h-fit">
                    <h3 class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-3">選択中の処方情報</h3>
                    <div class="space-y-4">
                        <div>
                            <span class="text-xs text-slate-500 block">対象医療機関</span>
                            <span class="text-sm font-bold text-slate-800">{{ $prescription->department->hospital->name }}</span>
                        </div>
                        <div>
                            <span class="text-xs text-slate-500 block">受診診療科</span>
                            <span class="text-sm font-bold text-slate-800">{{ $prescription->department->name }}</span>
                        </div>
                        <div>
                            <span class="text-xs text-slate-500 block">処方日（診察日）</span>
                            <span class="text-sm font-bold text-slate-800">{{ \Carbon\Carbon::parse($prescription->prescribed_date)->format('Y年m月d日') }}</span>
                        </div>
                    </div>
                </div>

                <!-- 右カラム：メインのお薬入力フォーム（CRUD機能） -->
                <div class="lg:col-span-2 bg-white p-8 rounded-xl shadow-sm border border-slate-200">
                    <h2 class="text-xl font-bold text-slate-800 mb-6 border-b border-slate-100 pb-4">💊 処方されたお薬を登録</h2>

                    <form action="{{ route('medicines.store') }}" method="POST" class="space-y-6">
                        @csrf
                        
                        <!-- 隠しフィールド群：リレーション紐付け用 -->
                        <input type="hidden" name="prescription_id" value="{{ $prescription->id }}">
                        <input type="hidden" name="department_id" value="{{ $prescription->department->id }}">

                        <!-- 薬剤名 -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-slate-700 mb-1">お薬の名前 <span class="text-red-500 text-xs">必須</span></label>
                            <input type="text" name="name" id="name" required value="{{ old('name') }}" placeholder="例: ロキソニン錠60mg" class="w-full rounded-lg border border-slate-300 p-2 text-sm focus:border-teal-500 focus:ring-1 focus:ring-teal-500 outline-none">
                            @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- 1回量 -->
                        <div>
                            <label for="dosage" class="block text-sm font-medium text-slate-700 mb-1">1回の服用量 <span class="text-red-500 text-xs">必須</span></label>
                            <input type="text" name="dosage" id="dosage" required value="{{ old('dosage') }}" placeholder="例: 1錠、2カプセル、5ml" class="w-full rounded-lg border border-slate-300 p-2 text-sm focus:border-teal-500 focus:ring-1 focus:ring-teal-500 outline-none">
                            @error('dosage') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- 服用タイミング -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">服用するタイミング <span class="text-slate-400 text-xs">（複数選択可）</span></label>
                            <div class="grid grid-cols-2 gap-4 bg-slate-50 p-4 rounded-xl border border-slate-100">
                                
                                <label class="inline-flex items-center cursor-pointer p-2 hover:bg-white rounded-lg transition-colors">
                                    <input type="checkbox" name="timing_morning" value="1" {{ old('timing_morning') ? 'checked' : '' }} class="rounded border-slate-300 text-teal-600 h-4 w-4">
                                    <span class="ml-2 text-sm text-slate-700 font-medium">🌅 朝</span>
                                </label>

                                <label class="inline-flex items-center cursor-pointer p-2 hover:bg-white rounded-lg transition-colors">
                                    <input type="checkbox" name="timing_noon" value="1" {{ old('timing_noon') ? 'checked' : '' }} class="rounded border-slate-300 text-teal-600 h-4 w-4">
                                    <span class="ml-2 text-sm text-slate-700 font-medium">☀️ 昼</span>
                                </label>

                                <label class="inline-flex items-center cursor-pointer p-2 hover:bg-white rounded-lg transition-colors">
                                    <input type="checkbox" name="timing_night" value="1" {{ old('timing_night') ? 'checked' : '' }} class="rounded border-slate-300 text-teal-600 h-4 w-4">
                                    <span class="ml-2 text-sm text-slate-700 font-medium">🌙 夜</span>
                                </label>

                                <label class="inline-flex items-center cursor-pointer p-2 hover:bg-white rounded-lg transition-colors">
                                    <input type="checkbox" name="timing_before_sleep" value="1" {{ old('timing_before_sleep') ? 'checked' : '' }} class="rounded border-slate-300 text-teal-600 h-4 w-4">
                                    <span class="ml-2 text-sm text-slate-700 font-medium">💤 就寝前</span>
                                </label>

                            </div>
                        </div>

                        <!-- 備考・注意書き -->
                        <div>
                            <label for="notes" class="block text-sm font-medium text-slate-700 mb-1">備考・注意事項 <span class="text-slate-400 text-xs">任意</span></label>
                            <textarea name="notes" id="notes" rows="3" placeholder="例: 食後30分以内に服用してください。眠気が出る場合があります。" class="w-full rounded-lg border border-slate-300 p-2 text-sm focus:border-teal-500 focus:ring-1 focus:ring-teal-500 outline-none">{{ old('notes') }}</textarea>
                            @error('notes') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- ボタン類 -->
                        <div class="flex items-center justify-end space-x-3 border-t border-slate-100 pt-4">
                            <a href="{{ route('departments.show', $prescription->department->id) }}" class="px-4 py-2 text-sm font-medium text-slate-700 bg-white border border-slate-300 rounded-lg shadow-sm hover:bg-slate-50">
                                キャンセル
                            </a>
                            <button type="submit" class="px-5 py-2 text-sm font-medium text-white bg-teal-600 rounded-lg shadow-sm hover:bg-teal-700">
                                お薬を登録する
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

</body>
</html>