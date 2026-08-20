<aside class="col-lg-2 sidebar p-3 d-none d-lg-block">
    <div class="brand mb-4">◉ সহায়ক<small>Shohayok</small></div>
    @foreach ([['Dashboard','admin.dashboard'],['Users & Providers','admin.users'],['Services & Rentals','admin.listings'],['Provider Payments','admin.provider-payments'],['Messages','admin.messages'],['Banner Management','admin.banners'],['Settings','admin.settings'],['Ads Management','admin.ads']] as $item)
        <a class="nav-link {{ request()->routeIs($item[1], $item[1] . '.*') ? 'active' : '' }}" href="{{ route($item[1]) }}">{{ $item[0] }}</a>
    @endforeach
    <form method="post" action="{{ route('logout') }}" class="mt-4">@csrf<button class="nav-link text-danger border-0 bg-transparent">Logout</button></form>
</aside>
