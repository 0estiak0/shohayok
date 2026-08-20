@extends('layouts.app', ['title' => 'Users & Providers — Shohayok'])
@section('content')
    <div class="container-fluid">
        <div class="row">@include('admin.partials.sidebar')<main class="col-lg-10 dashboard-main p-4 p-xl-5">
                <h2 class="fw-bold">Users &amp; Service Providers</h2>
                <p class="text-secondary mb-4">View registered account information and activity.</p>
                <form class="row g-2 mb-4" method="get">
                    <div class="col-md-6"><input class="form-control" name="q" value="{{ request('q') }}"
                            placeholder="Search name, email or phone"></div>
                    <div class="col-md-3"><select class="form-select" name="role">
                            <option value="">All roles</option>
                            <option value="user" @selected(request('role') === 'user')>Users</option>
                            <option value="provider" @selected(request('role') === 'provider')>Providers</option>
                        </select></div>
                    <div class="col-md-3"><button class="btn btn-primary">Search</button> <a class="btn btn-light border"
                            href="{{ route('admin.users') }}">Reset</a></div>
                </form>
                <div class="card-soft p-3 table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Contact</th>
                                <th>Role</th>
                                <th>Activity</th>
                                <th>Joined</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                                <tr>
                                    <td><b>{{ $user->name }}</b>
                                        <div class="small text-secondary">{{ $user->city }}, {{ $user->country }}</div>
                                    </td>
                                    <td>{{ $user->email }}<div class="small">{{ $user->country_code }} {{ $user->phone }}
                                        </div>
                                    </td>
                                    <td><span
                                            class="badge {{ $user->isProvider() ? 'bg-success' : 'bg-primary' }}">{{ ucfirst($user->role) }}</span>
                                        @if ($user->isProvider())
                                            <div class="small mt-1">
                                                {{ $user->is_verified ? 'Verified' : 'Pending verification' }}</div>
                                        @endif
                                    </td>
                                    <td>{{ $user->listings_count }} listings · {{ $user->bookings_count }} bookings</td>
                                    <td>{{ $user->created_at->format('d M Y') }}</td>
                                    <td><a class="btn btn-sm btn-outline-primary"
                                            href="{{ route('admin.users.show', $user) }}">View Details</a></td>
                            </tr>@empty<tr>
                                    <td colspan="6" class="text-center py-5">No accounts found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">{{ $users->links() }}</div>
            </main>
        </div>
    </div>
@endsection
