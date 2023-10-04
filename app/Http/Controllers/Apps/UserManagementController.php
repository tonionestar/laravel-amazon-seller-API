<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class UserManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch all data from the User model
        // $users = User::paginate(10);
        $users = User::all();

        return view('pages.apps.user-management.users.list', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, User $user)
    {
        // Store new data in User model
        try {
            $validatedData = $request->validate([
                'email' => 'required|email|unique:users,email',
            ]);

            // Inserting a new user into the database

            $user->full_name = $request->firstname . ' ' . $request->lastname;
            $user->email = $request->email;
            $user->phone_number = $request->phonenumber;
            $user->position = $request->position;
            $user->role = $request->role;
            $user->address = $request->address1 . ' ' . $request->city . ' ' . $request->state . ' ' . $request->zipcode;
            $user->password = Hash::make($request->password);

            $user->save();
            session()->flash('success', 'Data stored successfully!');

            return redirect()->route('user-management.users.store')->with('success', 'User created successfully');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withInput()->withErrors($e->errors());
        }
    }

    public function checkEmail(Request $request)
    {
        $email = $request->email;
        $check = User::where('email', $email)->first();

        if ($check) {
            return "taken";
        } else {
            return "not_taken";
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('pages.apps.user-management.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    public function getUser($id)
    {
        $user = User::find($id);
        return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user, $id)
    {
        // update new data in User model
        // return $request;
        $this->validate($request, [
            'email' => 'required|email|unique:users,email,' . $id,
        ]);

        DB::table('users')->where('id', $id)->update([
            'full_name' => $request->firstname . ' ' . $request->lastname,
            'email' => $request->email,
            'phone_number' => $request->phonenumber,
            'position' => $request->position,
            'role' => $request->role,
            'address' => $request->address1 . ' ' . $request->city . ' ' . $request->state . ' ' . $request->zipcode,
            'password' => Hash::make($request->password)
        ]);

        // $user->update($data);
        session()->flash('success', 'Data stored successfully!');

        return redirect()->route('user-management.users.store')->with('success', 'User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        // Delete user from User Model
        $user->delete();

        // Redirecting back to the users listing page
        return back()->with('success', 'User deleted successfully');
    }
}
