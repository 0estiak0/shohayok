<?php
namespace App\Http\Controllers;

use App\Models\{User,Listing,Banner,Complaint,Setting,ProviderPayment,SupportMessage};
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    private function guard($r){ abort_unless($r->user()?->isAdmin(),403); }

    public function dashboard(Request $r)
    {
        $this->guard($r);
        $stats=[
            'users'=>User::where('role','user')->count(),
            'providers'=>User::where('role','provider')->count(),
            'pending'=>User::where('role','provider')->where('is_verified',false)->count(),
            'services'=>Listing::where('type','service')->count(),
            'rentals'=>Listing::where('type','rental')->count(),
            'payment_pending'=>ProviderPayment::where('status','pending')->count(),
            'unread_messages'=>SupportMessage::where('is_from_admin',false)->whereNull('read_at')->count(),
        ];
        $pending=User::where('role','provider')->where('is_verified',false)->latest()->limit(5)->get();
        $services=Listing::with(['provider','category'])->where('type','service')->latest()->limit(5)->get();
        $rentals=Listing::with(['provider','category'])->where('type','rental')->latest()->limit(5)->get();
        $complaints=Complaint::latest()->limit(5)->get();
        return view('admin.dashboard',compact('stats','pending','services','rentals','complaints'));
    }

    public function approveProvider(Request $r, User $user){$this->guard($r);abort_unless($user->role==='provider',404);$user->update(['is_verified'=>true,'availability_status'=>'available']);return back()->with('success','Provider approved.');}
    public function rejectProvider(Request $r, User $user){$this->guard($r);abort_unless($user->role==='provider',404);$user->update(['is_verified'=>false,'availability_status'=>'inactive']);return back()->with('success','Provider rejected/deactivated.');}

    public function providerPayments(Request $r)
    {
        $this->guard($r);
        $payments=ProviderPayment::with('user')->latest()->paginate(30);
        return view('admin.provider-payments',compact('payments'));
    }

    public function approveProviderPayment(Request $r, ProviderPayment $providerPayment)
    {
        $this->guard($r);
        if ($providerPayment->status !== 'approved') {
            $providerPayment->update(['status'=>'approved','approved_at'=>now(),'admin_note'=>$r->input('admin_note')]);
            $providerPayment->user->update(['role'=>'provider','is_verified'=>false,'availability_status'=>'available']);
        }
        return back()->with('success','Payment approved and provider account activated.');
    }

    public function rejectProviderPayment(Request $r, ProviderPayment $providerPayment)
    {
        $this->guard($r);
        $providerPayment->update(['status'=>'rejected','admin_note'=>$r->input('admin_note')]);
        return back()->with('success','Payment marked as rejected.');
    }

    public function messages(Request $r)
    {
        $this->guard($r);
        $threads=SupportMessage::with('user')
            ->selectRaw('user_id, MAX(created_at) as last_message_at, SUM(CASE WHEN is_from_admin = 0 AND read_at IS NULL THEN 1 ELSE 0 END) as unread_count')
            ->groupBy('user_id')->orderByDesc('last_message_at')->get();
        return view('admin.messages',compact('threads'));
    }

    public function messageThread(Request $r, User $user)
    {
        $this->guard($r);
        SupportMessage::where('user_id',$user->id)->where('is_from_admin',false)->whereNull('read_at')->update(['read_at'=>now()]);
        $messages=SupportMessage::where('user_id',$user->id)->with('sender')->oldest()->get();
        return view('admin.message-thread',compact('user','messages'));
    }

    public function replyMessage(Request $r, User $user)
    {
        $this->guard($r);
        $data=$r->validate(['message'=>'required|string|max:3000']);
        SupportMessage::create(['user_id'=>$user->id,'sender_id'=>$r->user()->id,'message'=>$data['message'],'is_from_admin'=>true]);
        return back()->with('success','Reply sent.');
    }

    public function banners(Request $r){$this->guard($r);$banners=Banner::orderBy('sort_order')->get();return view('admin.banners',compact('banners'));}
    public function storeBanner(Request $r){$this->guard($r);$data=$r->validate(['title'=>'required','subtitle'=>'nullable','button_text'=>'nullable','button_url'=>'nullable','sort_order'=>'nullable|integer','image'=>'nullable|image|max:8192']);if($r->hasFile('image'))$data['image']=$r->file('image')->store('banners','public');Banner::create($data);return back()->with('success','Banner created.');}
    public function settings(Request $r){$this->guard($r);$settings=Setting::orderBy('group')->get()->groupBy('group');return view('admin.settings',compact('settings'));}
    public function saveSettings(Request $r){$this->guard($r);foreach($r->except('_token') as $k=>$v)Setting::updateOrCreate(['key'=>$k],['value'=>$v]);return back()->with('success','Settings saved.');}
    public function ads(Request $r){$this->guard($r);$listings=Listing::with(['provider','category'])->latest()->paginate(20);return view('admin.ads',compact('listings'));}
    public function updateAd(Request $r, Listing $listing){$this->guard($r);$data=$r->validate(['is_sponsored'=>'required|boolean','is_featured'=>'required|boolean']);$listing->update($data);return back()->with('success','Advertisement settings updated.');}
    public function listings(Request $r){$this->guard($r);$listings=Listing::with(['provider','category'])->latest()->paginate(20);$providers=User::where('role','provider')->orderBy('name')->get();$categories=\App\Models\Category::where('is_active',true)->orderBy('type')->orderBy('name')->get();return view('admin.listings',compact('listings','providers','categories'));}
    public function storeListing(Request $r){$this->guard($r);$data=$r->validate(['provider_id'=>'nullable|required_without:manual_provider|exists:users,id','manual_provider'=>'nullable|required_without:provider_id|string|max:255','category_id'=>'required|exists:categories,id','type'=>'required|in:service,rental','title'=>'required|string|max:180','description'=>'required|string','price'=>'required|numeric|min:0','discount_price'=>'nullable|numeric|min:0|lte:price','price_unit'=>'required|string|max:50','address'=>'required|string|max:500','city'=>'required|string|max:100','country'=>'required|string|max:100','images'=>'nullable|array','images.*'=>'image|max:5120']);if(!empty($data['manual_provider'])){$value=trim($data['manual_provider']);$provider=User::where('role','provider')->where(fn($q)=>$q->where('email',$value)->orWhere('phone',$value)->orWhere('name',$value))->first();if(!$provider)return back()->withInput()->withErrors(['manual_provider'=>'No provider account matches that email, phone, or exact name.']);$data['provider_id']=$provider->id;}abort_unless(User::whereKey($data['provider_id'])->where('role','provider')->exists(),422);unset($data['manual_provider']);$data['slug']=Str::slug($data['title']).'-'.Str::lower(Str::random(5));if($r->hasFile('images')){$paths=[];foreach($r->file('images') as $file)$paths[]=$file->store('listings','public');$data['images']=$paths;}Listing::create($data);return back()->with('success',ucfirst($data['type']).' created successfully.');}
    public function users(Request $r){$this->guard($r);$query=User::withCount(['listings','bookings']);if($r->filled('role'))$query->where('role',$r->role);if($r->filled('q')){$term=$r->q;$query->where(fn($q)=>$q->where('name','like',"%{$term}%")->orWhere('email','like',"%{$term}%")->orWhere('phone','like',"%{$term}%"));}$users=$query->latest()->paginate(20)->withQueryString();return view('admin.users',compact('users'));}
    public function userDetails(Request $r, User $user){$this->guard($r);$user->load(['listings.category'])->loadCount(['listings','bookings','providerBookings','reviews']);return view('admin.user-details',compact('user'));}
}
