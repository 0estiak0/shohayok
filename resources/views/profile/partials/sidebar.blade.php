<aside class="col-lg-2 sidebar p-3 d-none d-lg-block">
    <div class="brand mb-4">◉ সহায়ক<small>Shohayok</small></div>
    <a class="nav-link {{ request()->routeIs('profile.show') ? 'active' : '' }}" href="{{ route('profile.show') }}">My Profile</a>
    <a class="nav-link {{ request()->routeIs('profile.edit') ? 'active' : '' }}" href="{{ route('profile.edit') }}">Edit Profile</a>
    <a class="nav-link" href="{{ route('profile.show') }}#bookings">My Bookings</a>
    <a class="nav-link {{ request()->routeIs('notifications') ? 'active' : '' }}" href="{{ route('notifications') }}">Notifications</a>
    <a class="nav-link {{ request()->routeIs('support.messages') ? 'active' : '' }}" href="{{ route('support.messages') }}">Shohayok Support</a>
    <a class="nav-link" href="{{ route('provider.apply') }}">Become a Provider</a>
    <form method="post" action="{{ route('logout') }}" class="mt-4">@csrf<button class="nav-link text-danger border-0 bg-transparent">Logout</button></form>
</aside>
