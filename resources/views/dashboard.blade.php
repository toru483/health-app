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
</body>
</html>