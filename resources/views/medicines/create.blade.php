<div class="container mx-auto p-6 max-w-2xl">
    <!-- ヘッダー：コンテキストの明示 -->
    <div class="bg-gray-100 p-4 rounded-t-lg border-b">
        <h1 class="text-xl font-bold text-gray-800">💊 お薬の登録</h1>
        <div class="text-sm text-gray-600 mt-1">
            <span class="font-bold">{{ $prescription->department->hospital->name }}</span> 
            ({{ $prescription->department->name }}) 
            <span class="ml-2">受診日: {{ $prescription->prescribed_date }}</span>
        </div>
    </div>

    <!-- 登録フォーム -->
    <form action="{{ route('medicines.store') }}" method="POST" class="bg-white shadow-md p-6">
        @csrf
        <input type="hidden" name="prescription_id" value="{{ $prescription->id }}">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="md:col-span-2">
                <label class="block text-gray-700 text-sm font-bold mb-2">薬の名前</label>
                <input type="text" name="name" required class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">分量</label>
                <div class="flex">
                    <input type="number" name="dosage_amount" value="1" class="w-full border rounded-l px-3 py-2">
                    <select name="dosage_unit" class="border-y border-r rounded-r px-2 bg-gray-50">
                        <option value="錠">錠</option>
                        <option value="包">包</option>
                        <option value="ml">ml</option>
                    </select>
                </div>
            </div>
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">服用タイミング</label>
                <input type="text" name="frequency" placeholder="例: 朝夕食後" required class="w-full border rounded px-3 py-2">
            </div>
        </div>

        <button type="submit" class="mt-6 w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-lg shadow-lg transition">
            このお薬をリストに追加
        </button>
    </form>

    <!-- 登録済みリスト（ここが重要！） -->
    <div class="mt-8 bg-white shadow-md rounded-lg overflow-hidden">
        <div class="bg-gray-50 px-4 py-2 border-b">
            <h3 class="font-bold text-gray-700">今回の処方箋に含まれるお薬</h3>
        </div>
        <table class="w-full text-left">
            <thead class="bg-gray-100 text-xs uppercase text-gray-600">
                <tr>
                    <th class="px-4 py-2">薬名</th>
                    <th class="px-4 py-2">分量</th>
                    <th class="px-4 py-2">頻度</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($prescription->medicines as $med)
                <tr>
                    <td class="px-4 py-3 font-medium">{{ $med->name }}</td>
                    <td class="px-4 py-3">{{ $med->dosage_amount }}{{ $med->dosage_unit }}</td>
                    <td class="px-4 py-3 text-sm text-gray-500">{{ $med->frequency }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="px-4 py-6 text-center text-gray-400 italic">まだ登録された薬はありません。</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6 text-center">
        <a href="{{ route('hospitals.index') }}" class="text-blue-500 hover:underline">← 病院一覧へ戻る（入力を完了する）</a>
    </div>
</div>