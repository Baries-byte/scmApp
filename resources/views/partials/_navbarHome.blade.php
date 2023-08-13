<div class="bg-slate-200 p-3 flex justify-between sticky top-0">
    <div>
        <div class="font-bold">
            <a href="/">
                TB Guna Bangunan
            </a>
        </div>
    </div>

    @auth
        <div>
            <ul class="flex space-x-6">
                <li>
                    <span class="font-bold uppercase">Selamat datang {{ auth()->user()->nama }}</span>
                </li>
                @if (auth()->user()->level !== 0)
                    <li>
                        <a href="/dashboard">Dashboard</a>
                    </li>
                @else
                    <li>
                        <a href="{{ route('profileUserPelanggan') }}">Profile</a>
                    </li>
                    <li>
                        <a href="{{ route('keranjangBelanja') }}">
                            <i class="fa-solid fa-cart-arrow-down"></i>
                        </a>
                    </li>
                @endif
                <li>
                    <form class="inline" action="/logout" method="POST">
                        @csrf
                        <button type="submit">
                            <i class="fa-solid fa-door-closed"></i>
                            Logout
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    @else
        <div class="">
            <a href="/login" class="font-semibold hover:font-bold">
                <i class="fa-solid fa-door-open"></i>
                Login
            </a>
        </div>
    @endauth
</div>
