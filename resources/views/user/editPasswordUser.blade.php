<x-layoutAdmin>
    <x-title>
        Ubah Password
    </x-title>

    <div class="mx-5 mt-5 border-4 p-4 mb-10 md:mx-10">
        <form action="{{ route('updatePassword', ['user' => auth()->user()->id]) }}" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" value="{{ auth()->user()->id }}">
            <div class="flex my-2">
                <label for="password" class="w-1/5 font-semibold p-1">Password</label>
                <div class="w-full">
                    <input type="password" name="password" class="border-2 w-full p-1" placeholder="password"
                        value="{{ old('password') }}" />
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="flex my-2">
                <label for="password_confirmation" class="w-1/5 font-semibold p-1">Konfirmasi
                    Password</label>
                <div class="w-full">
                    <input type="password" name="password_confirmation" class="border-2 w-full p-1"
                        placeholder="konfirmasi passsword" value="{{ old('password_confirmation') }}" />
                    @error('password_confirmation')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="flex w-full justify-end">
                <button type="submit" class="bg-primary rounded-md p-1 text-white">Ubah Password</button>
            </div>
        </form>
    </div>
</x-layoutAdmin>
