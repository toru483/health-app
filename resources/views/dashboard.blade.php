<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>健康管理アプリ</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow-md">
        <h1 class="text-2xl font-bold mb-4 text-blue-600">🏥 健康管理ダッシュボード</h1>
        
        <div class="grid grid-cols-2 gap-4">
            <div class="border p-4 rounded bg-blue-50">
                <h2 class="font-bold border-b mb-2">💊 服薬ログ</h2>
                <p class="text-sm text-gray-600">最近の記録はありません</p>
            </div>

            <div class="border p-4 rounded bg-green-50">
                <h2 class="font-bold border-b mb-2">📊 測定ログ</h2>
                <p class="text-sm text-gray-600">最近の記録はありません</p>
            </div>
        </div>

        <button class="mt-6 w-full bg-blue-500 text-white py-2 rounded hover:bg-blue-600">
            新しく記録する
        </button>
    </div>

    <div class="container mx-auto p-6 max-w-4xl">
        <h1 class="text-3xl font-bold text-gray-800 mb-8 border-l-4 border-blue-500 pl-4">マイページ：現在のお薬</h1>

        @forelse($prescriptions as $prescription)
            <div class="mb-8 bg-white shadow-lg rounded-xl overflow-hidden border border-gray-200">
                <!-- 処方箋ヘッダー -->
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 p-4 border-b">
                    <div class="flex justify-between items-center">
                        <div>
                            <h2 class="text-lg font-bold text-blue-900">
                                {{ $prescription->department->hospital->name }} 
                                <span class="text-sm font-normal text-blue-700">（{{ $prescription->department->name }}）</span>
                            </h2>
                            <p class="text-sm text-gray-600">処方日：{{ $prescription->prescribed_date }}</p>
                        </div>
                        @if($prescription->next_visit_date)
                            <div class="text-right">
                                <span class="bg-red-100 text-red-700 text-xs font-bold px-2 py-1 rounded-full">
                                    次回予約：{{ $prescription->next_visit_date }}
                                </span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- 薬のリスト -->
                <div class="p-4">
                    <table class="w-full">
                        <thead>
                            <tr class="text-left text-xs text-gray-400 uppercase tracking-wider">
                                <th class="pb-2">薬名</th>
                                <th class="pb-2">1回量</th>
                                <th class="pb-2">タイミング</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($prescription->medicines as $medicine)
                                <tr>
                                    <td class="py-3 font-semibold text-gray-700">{{ $medicine->name }}</td>
                                    <td class="py-3 text-gray-600">{{ $medicine->dosage_amount }}{{ $medicine->dosage_unit }}</td>
                                    <td class="py-3 text-gray-600">
                                        <span class="bg-green-50 text-green-700 px-2 py-1 rounded text-sm font-medium">
                                            {{ $medicine->frequency }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @empty
            <div class="text-center py-12 bg-white rounded-xl shadow">
                <p class="text-gray-400 italic">まだ処方箋が登録されていません。</p>
                <a href="{{ route('hospitals.index') }}" class="mt-4 inline-block text-blue-500 hover:underline">病院を登録して始める</a>
            </div>
        @endforelse
    </div>
</body>
</html>