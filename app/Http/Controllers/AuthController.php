<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use TheSeer\Tokenizer\Token;

class AuthController extends Controller
{

    public function dashboard()
    {
        $user = Auth::user();
        if ($user->role === 'admin') {
            $usercount = User::count();
            $leadcount = Lead::where('status', '1')->count();
            $perposelcount = Lead::count();
        } else {
            $usercount = 1; 
            $leadcount = Lead::where('user_id', $user->id)->where('status', '1')->count();
            $perposelcount = Lead::where('user_id', $user->id)->count();
        }
    
        return view('dashboard.index', compact('usercount', 'leadcount', 'perposelcount'));
    }
    

    public function user(){
        $user = Auth::user();
        if ($user->role === 'admin') {
            $users = User::all();
        } else {
            $users = User::where('id', $user->id)->get();
        }
    
        return view('user', compact('users'));
    }
    

    public function signup(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'password' => 'required|string|min:6|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        return redirect()->route('login')->with('success','Account created successfully! Please login.');

    }

        public function login(Request $request)
        {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required|min:6',
            ]);

            if (Auth::attempt([
                'email' => $request->input('email'),
                'password' => $request->input('password')
            ], $request->remember)) {
                return redirect()->route('dashboard');
            }
            return back()->with('error','These credentials do not match our records.');
        }

        public function update(Request $request, $id)
        {
            $user = User::findOrFail($id); 
    
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $id,
                'image' => 'nullable|image',
                'password' => 'nullable|string|min:8',
            ]);
    
            if ($request->hasFile('image')) {
                if ($user->image) {
                    Storage::disk('public')->delete($user->image);
                }
                $validated['image'] = $request->file('image')->store('images', 'public');
            }
    
            if (empty($validated['password'])) {
                unset($validated['password']);
            }else{
                $validated['password'] = bcrypt($validated['password']);
            }
      
        
            $user->update($validated);
        
            return redirect()->back()->with('success', 'Profile updated successfully.');
        }


        public function logout(){
            Auth::logout();
            return redirect()->route('leads.index');
        }

}

