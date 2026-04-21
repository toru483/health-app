<div class="container mx-auto p-6 max-w-lg">
    <h1 class="text-2xl font-bold text-gray-800 mb-2">処方箋の記録</h1>
    <p class="text-gray-600 mb-6">{{ $department->hospital->name }} / {{ $department->name }}</p>

    <form action="{{ route('prescriptions.store') }}" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        @csrf
        <input type="hidden" name="department_id" value="{{ $department->id }}">

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">受診日</label>
            <input type="date" name="prescribed_date" value="{{ date('Y-m-d') }}" required class="shadow border rounded w-full py-2 px-3 focus:ring-2 focus:ring-green-500">
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2">次回受診予定日（任意）</label>
            <input type="date" name="next_visit_date" class="shadow border rounded w-full py-2 px-3 focus:ring-2 focus:ring-green-500">
        </div>

        <button type="submit" class="w-full bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
            処方箋を登録して薬の入力へ
        </button>
    </form>
</div>