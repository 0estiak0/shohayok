<?php
namespace App\Http\Controllers;

use App\Models\SupportMessage;
use Illuminate\Http\Request;

class SupportController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        abort_if($user->isAdmin(),403);
        SupportMessage::where('user_id',$user->id)->where('is_from_admin',true)->whereNull('read_at')->update(['read_at'=>now()]);
        $messages = SupportMessage::where('user_id',$user->id)->with('sender')->oldest()->get();
        return view('support.messages',compact('messages'));
    }

    public function store(Request $request)
    {
        $user = $request->user();
        abort_if($user->isAdmin(),403);
        $data = $request->validate(['message'=>'required|string|max:3000']);
        SupportMessage::create([
            'user_id'=>$user->id,
            'sender_id'=>$user->id,
            'message'=>$data['message'],
            'is_from_admin'=>false,
        ]);
        return back()->with('success','Your message was sent to the admin team.');
    }
}
