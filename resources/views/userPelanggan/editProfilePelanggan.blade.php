<x-layoutPembeli>
    <div class="mx-5 mt-5 p-4 md:mx-10 flex">
        <div class="w-1/4 flex flex-col">
            <a href="{{ route('profileUserPelanggan') }}" class="font-semibold text-left my-2 hover:font-bold">Profile</a>
            <a href="{{ route('daftarTransaksiUserPelanggan') }}"
                class="font-semibold text-left my-2 hover:font-bold">Transaksi</a>
        </div>
        <div class="w-3/4 border-4 p-4">
            <div>
                <h3 class="text-center text-xl font-semibold">Update Profile</h3>
                <form action="{{ route('updateProfileUserPelanggan', ['user' => auth()->user()->id]) }}" method="POST">
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
        </div>
    </div>
</x-layoutPembeli>
