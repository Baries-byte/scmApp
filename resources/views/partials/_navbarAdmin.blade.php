<div class="hidden md:block">
    <nav class="bg-slate-200 w-full flex p-3 justify-end">
        <div class="flex">
            @auth
                <div>
                    <ul class="flex space-x-6">
                        <li>
                            <span class="font-bold uppercase">Selamat datang {{ auth()->user()->nama }}</span>
                        </li>
                        <li>
                            <a href="{{ route('profileUser') }}" class="mr-2">
                                <i class="fa-solid fa-person"></i>
                                Profile
                            </a>
                            <form class="inline" action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit">
                                    <i class="fa-solid fa-door-closed"></i>
                                    Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            @endauth
        </div>
    </nav>
