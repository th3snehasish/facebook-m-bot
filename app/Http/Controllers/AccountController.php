<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteUserRequest;
use App\Http\Requests\UpdateUserPasswordRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Notification;
use Auth;

class AccountController extends Controller
{
    /**
     * Show user form.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('account.index', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update user details.
     *
     * @param UpdateUserRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateUserRequest $request)
    {
        $request->user()->name = $request->get('name');
        $request->user()->save();

        Notification::success('Account details updated successfully.');

        return redirect()->route('account.index');
    }

    /**
     * Update user details.
     *
     * @param UpdateUserPasswordRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function password(UpdateUserPasswordRequest $request)
    {
        $request->user()->password = bcrypt($request->get('new_password'));
        $request->user()->save();

        Notification::success('Account password updated successfully.');

        return redirect()->route('account.index')->withInput(['tab' => 'password']);
    }

    /**
     * Delete user.
     *
     * @param DeleteUserRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(DeleteUserRequest $request)
    {
        $userId = $request->user()->id;

        Auth::logout();

        User::findOrFail($userId)->delete();

        return redirect()->route('home');
    }
}
