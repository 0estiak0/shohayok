<?php
namespace App\Http\Controllers;

use App\Models\{ProviderPayment,Setting};
use Illuminate\Http\Request;

class ProviderApplicationController extends Controller
{
    private function pricing(): array
    {
        $regular = max(0, (float) Setting::get('provider_registration_fee', '1000'));
        $discountPercent = min(100, max(0, (float) Setting::get('provider_discount_percent', '100')));
        $discountAmount = round($regular * ($discountPercent / 100), 2);
        $total = max(0, round($regular - $discountAmount, 2));
        return compact('regular','discountPercent','discountAmount','total');
    }

    public function show(Request $request)
    {
        $user = $request->user();
        if ($user->isAdmin()) abort(403);
        $pricing = $this->pricing();
        $latest = ProviderPayment::where('user_id',$user->id)->latest()->first();
        return view('provider.apply', [
            ...$pricing,
            'latest'=>$latest,
            'bkash'=>Setting::get('provider_bkash_number','01XXXXXXXXX'),
            'nagad'=>Setting::get('provider_nagad_number','01XXXXXXXXX'),
        ]);
    }

    public function store(Request $request)
    {
        $user = $request->user();
        abort_if($user->isAdmin(), 403);
        if ($user->isProvider()) return redirect()->route('provider.dashboard')->with('success','You are already a service provider.');

        $pricing = $this->pricing();
        $pending = ProviderPayment::where('user_id',$user->id)->where('status','pending')->exists();
        if ($pending) return back()->withErrors(['payment'=>'You already have a pending provider application.']);

        $rules = [];
        if ($pricing['total'] > 0) {
            $rules = [
                'payment_method'=>'required|in:bkash,nagad',
                'sender_number'=>'required|string|max:40',
                'transaction_id'=>'required|string|max:120',
            ];
        }
        $data = $request->validate($rules);

        $payment = ProviderPayment::create([
            'user_id'=>$user->id,
            'regular_price'=>$pricing['regular'],
            'discount_percent'=>$pricing['discountPercent'],
            'discount_amount'=>$pricing['discountAmount'],
            'total_amount'=>$pricing['total'],
            'payment_method'=>$data['payment_method'] ?? null,
            'sender_number'=>$data['sender_number'] ?? null,
            'transaction_id'=>$data['transaction_id'] ?? null,
            'status'=>$pricing['total'] <= 0 ? 'approved' : 'pending',
            'approved_at'=>$pricing['total'] <= 0 ? now() : null,
            'admin_note'=>$pricing['total'] <= 0 ? 'Automatically approved because payable total was zero.' : null,
        ]);

        if ($pricing['total'] <= 0) {
            $user->update(['role'=>'provider','is_verified'=>false,'availability_status'=>'available']);
            return redirect()->route('provider.dashboard')->with('success','100% discount applied. Your provider account is active and awaiting profile verification.');
        }

        return redirect()->route('provider.apply')->with('success','Payment submitted. Admin will verify the transaction and activate your provider account.');
    }
}
