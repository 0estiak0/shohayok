<aside class="col-lg-2 sidebar p-3 d-none d-lg-block">
    <div class="brand mb-4">◉ সহায়ক<small>Shohayok</small></div>
    @foreach ([
        ['Dashboard', 'provider.dashboard'], ['My Profile', 'provider.profile'],
        ['My Services', 'provider.services'], ['Add New Work', 'provider.work.create'],
        ['Recent Works', 'provider.works'], ['Customer Requests', 'provider.bookings'],
        ['Messages', 'provider.messages'], ['Reviews & Ratings', 'provider.reviews'],
        ['Notifications', 'provider.notifications'], ['Settings', 'provider.settings']
    ] as $item)
        <a class="nav-link {{ request()->routeIs($item[1], $item[1] . '.*') ? 'active' : '' }}" href="{{ route($item[1]) }}">{{ $item[0] }}</a>
    @endforeach
    <form method="post" action="{{ route('logout') }}" class="mt-4">@csrf
        <button class="nav-link text-danger border-0 bg-transparent">Logout</button>
    </form>
</aside>
