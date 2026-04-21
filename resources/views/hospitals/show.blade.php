@if (session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
        {{ session('success') }}
    </div>
@endif
<div class="container mx-auto p-6 max-w-2xl">
    <div class="mb-6">
        <a href="{{ route('hospitals.index') }}" class="text-blue-500 hover:underline">← 病院一覧に戻る</a>
        <h1 class="text-3xl font-bold text-gray-800 mt-2">{{ $hospital->name }}</h1>
        <p class="text-gray-600">{{ $hospital->address }} / {{ $hospital->tel }}</p>
    </div>

    <div class="bg-white shadow-md rounded-lg p-6 mb-8">
        <h2 class="text-xl font-semibold mb-4 border-b pb-2">受診科リスト</h2>
        @if($hospital->departments->isEmpty())
            <p class="text-gray-500">登録された受診科はありません。</p>
        @else
            <ul class="divide-y divide-gray-200">
                @foreach($hospital->departments as $dept)
                    <li class="py-3 flex justify-between items-center">
                        <span class="text-gray-700 font-medium">{{ $dept->name }}</span>
                        <a href="{{ route('prescriptions.create', ['department_id' => $dept->id]) }}" 
                        class="text-sm bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded">
                            処方箋を記録
                        </a>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>

    <div class="bg-blue-50 shadow-md rounded-lg p-6">
        <h2 class="text-lg font-semibold mb-3">新しい受診科を追加</h2>
        <form action="{{ route('departments.store') }}" method="POST" class="flex gap-2">
            @csrf
            <input type="hidden" name="hospital_id" value="{{ $hospital->id }}">
            <input type="text" name="name" placeholder="例：内科、眼科" required 
                   class="flex-1 shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                追加
            </button>
        </form>
    </div>
</div>