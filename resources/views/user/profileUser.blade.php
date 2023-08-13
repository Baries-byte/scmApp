<x-layoutAdmin>
    <x-title>
        Profile Pengguna
    </x-title>

    <div class="mx-5 mt-5 border-4 p-4 mb-10 md:mx-10">
        <div class="flex my-2">
            <label class="w-1/5 font-semibold p-1">Nama</label>
            <p class="border-2 w-full p-1">{{ auth()->user()->nama }}</p>
        </div>
        <div class="flex my-2">
            <label class="w-1/5 font-semibold p-1">Alamat</label>
            <p class="border-2 w-full p-1">{{ auth()->user()->alamat }}</p>
        </div>
        <div class="flex my-2">
            <label class="w-1/5 font-semibold p-1">Telepon</label>
            <p class="border-2 w-full p-1">{{ auth()->user()->telepon }}</p>
        </div>
        <div class="flex my-2">
            <label class="w-1/5 font-semibold p-1">Email</label>
            <p class="border-2 w-full p-1">{{ auth()->user()->email }}</p>
        </div>
        <div class="flex w-full justify-end">
            <a href="{{ route('editProfileUser') }}" class="bg-green-400 rounded-md p-1 mr-5">Update
                Profile</a>
            <a href="{{ route('editPasswordUser') }}" class="bg-green-400 rounded-md p-1">Ubah
                Password</a>
        </div>
    </div>
</x-layoutAdmin>
