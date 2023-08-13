<x-layoutAdmin>
    <x-title>
        Update Informasi Profile
    </x-title>

    <div class="mx-5 mt-5 border-4 p-4 mb-10 md:mx-10">
        <form action="{{ route('updateProfileUser', ['user' => auth()->user()->id]) }}" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" value="{{ auth()->user()->id }}">
            <div class="flex my-2">
                <label class="w-1/5 font-semibold p-1">Nama</label>
                <input type="text" class="border-2 w-full p-1" name="nama"
                    value="{{ auth()->user()->nama }}"></input>
            </div>
            <div class="flex my-2">
                <label class="w-1/5 font-semibold p-1">Alamat</label>
                <input type="text" class="border-2 w-full p-1" name="alamat"
                    value="{{ auth()->user()->alamat }}"></input>
            </div>
            <div class="flex my-2">
                <label class="w-1/5 font-semibold p-1">Telepon</label>
                <input type="text" class="border-2 w-full p-1" name="telepon"
                    value="{{ auth()->user()->telepon }}"></input>
            </div>
            <div class="flex my-2">
                <label class="w-1/5 font-semibold p-1">Email</label>
                <input type="text" class="border-2 w-full p-1" name="email"
                    value="{{ auth()->user()->email }}"></input>
            </div>
            <div class="flex w-full justify-end">
                <button type="submit" class="bg-green-400 rounded-md p-1">Update
                    Informasi</button>
            </div>
        </form>
    </div>
</x-layoutAdmin>
