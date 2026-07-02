<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>病院管理 - 新規登録</title>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;500;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>body { font-family: 'Noto Sans JP', sans-serif; }</style>
</head>
<body class="bg-slate-50 min-h-screen text-slate-800">

    <header class="bg-white border-b border-slate-200 sticky top-0 z-50 shadow-sm px-6 py-4 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <span class="text-3xl">🏥</span>
            <h1 class="text-xl font-bold text-slate-800 tracking-tight">HospitalLog</h1>
        </div>
        <a href="{{ route('hospitals.index') }}" class="text-sm font-bold text-slate-500 hover:text-slate-800">
            キャンセル
        </a>
    </header>

    <main class="max-w-xl mx-auto px-4 py-10">
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-slate-800">➕ 新しい病院の登録</h2>
            <p class="text-slate-500 text-sm mt-1">かかりつけの医療機関情報を入力してください。</p>
        </div>

        <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm">
            <form action="{{ route('hospitals.store') }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">病院名 <span class="text-rose-500 text-xs">*必須</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" class="w-full px-4 py-3 bg-slate-50 border @error('name') border-rose-400 focus:ring-rose-500/20 @else border-slate-200 focus:ring-blue-500/20 @enderror rounded-xl focus:outline-none focus:ring-2 transition-all text-base" placeholder="〇〇市立病院" required>
                    @error('name')
                        <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">電話番号</label>
                    <input type="tel" name="tel" value="{{ old('tel') }}" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 transition-all text-base" placeholder="03-1234-5678">
                    @error('tel')
                        <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">住所</label>
                    <textarea name="address" rows="3" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 transition-all text-base resize-none" placeholder="東京都渋谷区...決まっている範囲で構いません">{{ old('address') }}</textarea>
                    @error('address')
                        <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="pt-4 flex gap-3">
                    <a href="{{ route('hospitals.index') }}" class="w-1/3 py-3.5 bg-slate-100 text-slate-700 font-bold rounded-xl text-center hover:bg-slate-200 transition-all text-sm active:scale-95">
                        戻る
                    </a>
                    <button type="submit" class="w-2/3 py-3.5 bg-blue-600 text-white font-bold rounded-xl shadow-md hover:bg-blue-700 transition-all text-center text-sm active:scale-95">
                        病院を登録する ✨
                    </button>
                </div>
            </form>
        </div>
    </main>

</body>
</html>