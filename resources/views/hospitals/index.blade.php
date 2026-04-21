@if (session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
        {{ session('success') }}
    </div>
@endif
<div class="container mx-auto p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">病院一覧</h1>
        <a href="{{ route('hospitals.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            + 病院を追加
        </a>
    </div>

    <div class="bg-white shadow-md rounded my-6">
        <table class="min-w-full table-auto">
            <thead>
                <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-left">病院名</th>
                    <th class="py-3 px-6 text-left">電話番号</th>
                    <th class="py-3 px-6 text-center">操作</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                @foreach ($hospitals as $hospital)
                <tr class="border-b border-gray-200 hover:bg-gray-100">
                    <td class="py-3 px-6 text-left"><a href="{{ route('hospitals.show', $hospital->id) }}" class="hover:underline text-blue-600">
                        {{ $hospital->name }}
                        </a>
                    </td>
                    <td class="py-3 px-6 text-left">{{ $hospital->tel }}</td>
                    <td class="py-3 px-6 text-center">
                        <a href="{{ route('hospitals.show', $hospital->id) }}" class="text-blue-500 hover:text-blue-700 font-bold">
                            詳細
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>