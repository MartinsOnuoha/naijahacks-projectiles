<?php

namespace App\Http\Controllers;

use App\User;
use Session;
use Illuminate\Http\Request;
use Auth;

class ProfilesController extends Controller
{
    public function index($slug)
    {
        $user = User::where('slug', $slug)->first();

        return view('profiles.profile')->with('user', $user);
        
    }

    public function edit()
    {
        return view('profiles.edit')->with('user', Auth::user());
    }

    public function update(Request $r)
    {
        // $this->validate($r, [
        //     'location' => ['required'],
        //     'about' => ['required'],
        //     'phone' => ['required']
        // ]);
        
        Auth::user()->profile()->update([
            'location' => $r->location,
            'about' => $r->about,
            'phone' => $r->phone,
            'industry' => $r->industry,
            'website' => $r->website,
            'talent' => $r->talent
        ]);

        if($r->hasFile('avatar')) {
            Auth::user()->update([
                'avatar' => $r->avatar->store('public/avatars'),
            ]);
        }

        Session::flash('success', 'Profile updated.');

        return redirect()->back();
    }
}
