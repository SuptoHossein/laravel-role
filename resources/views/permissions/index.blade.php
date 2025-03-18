<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Permission List') }}
            </h2>

            <a href="{{ route('permission.create') }}"
                class="bg-slate-700 text-sm rounded-md px-5 py-2 text-white hover:bg-slate-800">Create</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-message></x-message>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr class="border-b text-left">
                                <th class="px-6 py-3" width="30">#</th>
                                <th class="px-6 py-3" width="450">Name</th>
                                <th class="px-6 py-3" width="">Created</th>
                                <th class="px-6 py-3">Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            @if ($permissions->isNotEmpty())
                                @foreach ($permissions as $permission)
                                    <tr class="border-b">
                                        <td class="px-6 py-3">{{ $loop->index + 1 }}</td>
                                        <td class="px-6 py-3">{{ $permission->name }}</td>
                                        <td class="px-6 py-3">{{ $permission->created_at->format('d M, Y') }}</td>
                                        <td class="px-6 py-3">
                                            <div class="flex m-4">
                                                <a href="{{ route('permission.edit', $permission->id) }}"
                                                    class="bg-slate-700 text-sm rounded-md px-5 py-2 text-white cursor-pointer hover:bg-slate-600 mr-2">Edit</a>

                                                <form action="{{ route('permission.destroy', $permission->id) }}"
                                                    method="POST">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button type="submit" onclick="confirm('Are you sure to delete')"
                                                        class="bg-red-600 text-sm rounded-md px-5 py-2 text-white cursor-pointer hover:bg-red-500">Delete</button>
                                                </form>
                                            </div>
                                            {{-- <a href="{{ route('permission.destroy', $permission->id) }}"
                                                class="bg-red-600 text-sm rounded-md px-5 py-2 text-white cursor-pointer hover:bg-red-500">Delete</a> --}}
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>

                    <div class="mt-5">
                        {{ $permissions->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- <x-slot name="script">
        <script type="text/javascript">
            function deletePermission(id) {
                if (confirm("Are you sure you want to delete?")) {
                    $.ajax({
                        url: "{{ route('permission.destroy') }}",
                        type: 'delete',
                        data: {
                            id: id
                        },
                        dataType: 'json',
                        headers: {
                            'x-csrf-token': '{{ csrf_token() }}'
                        }
                        success: function(response) {
                            window.location.href = '{{ route('permission.index') }}'
                        }
                    })
                }
            }
        </script>
    </x-slot> --}}

</x-app-layout>
