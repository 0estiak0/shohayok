@extends('layouts.app', ['title' => 'Settings — Shohayok'])
@section('content')
<div class="container-fluid"><div class="row">@include('admin.partials.sidebar')<main class="col-lg-10 dashboard-main p-4 p-xl-5"><div class="mb-4"><h2 class="fw-bold">System Settings</h2><p class="text-secondary">Website, provider pricing, manual payment, Google Maps and platform controls.</p></div>
<form method="post" action="{{ route('admin.settings.save') }}">@csrf<div class="row g-4">
@php($fields = [
['General',[['Website Name','site_name','Shohayok'],['Theme Color','theme_color','#1268e8'],['Default Language','language','English'],['Maintenance Mode','maintenance_mode','0']]],
['Provider Registration Price',[['Regular Price (৳)','provider_registration_fee','1000'],['Discount (%)','provider_discount_percent','100']]],
['Manual Payments',[['bKash Send Money Number','provider_bkash_number','01XXXXXXXXX'],['Nagad Send Money Number','provider_nagad_number','01XXXXXXXXX']]],
['Google Maps',[['API Key','google_maps_api_key',''],['Default Latitude','maps_default_lat','23.8103'],['Default Longitude','maps_default_lng','90.4125']]],
['Future Live Payment API',[['bKash Merchant ID','bkash_merchant_id',''],['Nagad Merchant ID','nagad_merchant_id','']]],
['SMTP / Social Login',[['SMTP Host','mail_host',''],['Google Client ID','google_client_id',''],['Facebook Client ID','facebook_client_id','']]]
])
@foreach($fields as [$heading,$items])<div class="col-lg-6"><div class="card-soft p-4 h-100"><h5>{{ $heading }}</h5>@foreach($items as [$label,$name,$default])<label class="form-label mb-1">{{ $label }}</label>@if($name==='language')<select class="form-select mb-3" name="language"><option value="English" @selected(App\Models\Setting::get('language','English')==='English')>English</option><option value="Bangla" @selected(App\Models\Setting::get('language')==='Bangla')>Bangla</option></select>@elseif($name==='maintenance_mode')<select class="form-select mb-3" name="maintenance_mode"><option value="0" @selected(App\Models\Setting::get('maintenance_mode','0')==='0')>Off</option><option value="1" @selected(App\Models\Setting::get('maintenance_mode')==='1')>On</option></select>@else<input class="form-control mb-3" name="{{ $name }}" value="{{ App\Models\Setting::get($name,$default) }}">@endif @endforeach</div></div>@endforeach
</div><button class="btn btn-primary mt-4 px-5">Save Settings</button></form></main></div></div>
@endsection
