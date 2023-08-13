<x-layoutPembeli>
    <div class="mx-5 mt-5 p-4 md:mx-10 flex">
        <div class="w-1/4 flex flex-col">
            <a href="{{ route('profileUserPelanggan') }}" class="font-semibold text-left my-2 hover:font-bold">Profile</a>
            <a href="{{ route('daftarTransaksiUserPelanggan') }}"
                class="font-semibold text-left my-2 hover:font-bold">Transaksi</a>
        </div>
        <div class="w-3/4 border-4 p-4">
            <div id="profile" class="">
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
                    <a href="{{ route('profileEditPelanggan') }}" class="bg-green-400 rounded-md p-1 mr-5">Update
                        Profile</a>
                    <a href="{{ route('editPasswordUserPelanggan') }}" class="bg-green-400 rounded-md p-1">Ubah
                        Password</a>
                </div>
            </div>
        </div>
    </div>
</x-layoutPembeli>
