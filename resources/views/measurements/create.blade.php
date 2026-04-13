<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>測定記録入力</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow-md">
        <h1 class="text-xl font-bold mb-4">📊 測定結果を入力</h1>

        <form action="{{ route('measurements.store') }}" method="POST">
            @csrf <div class="mb-4">
                <label class="block text-gray-700">種類</label>
                <select name="type" class="w-full border rounded p-2">
                    <option value="血糖値">血糖値</option>
                    <option value="血圧">血圧</option>
                    <option value="体重">体重</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">数値1 (血糖値・最高血圧など)</label>
                <input type="number" name="value_1" step="0.1" class="w-full border rounded p-2" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">数値2 (最低血圧など - 任意)</label>
                <input type="number" name="value_2" step="0.1" class="w-full border rounded p-2">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">測定日時</label>
                <input type="datetime-local" name="measured_at" class="w-full border rounded p-2" value="{{ date('Y-m-d\TH:i') }}" required>
            </div>

            <div class="flex justify-between">
                <a href="{{ route('dashboard') }}" class="text-gray-500 py-2">戻る</a>
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">保存する</button>
            </div>
        </form>
    </div>
</body>
</html>