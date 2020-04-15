<?php

namespace App\Http\Controllers;

use App\Events\ProfileUpdated;
use App\Http\Requests\UpdateProfileRequest;
use Illuminate\Http\Request;
use App\User;

class ProfileController extends Controller
{
    /**
     * Update user
     *
     * @param  UpdateProfileRequest $request
     * @return App\User
     */
    public function update(UpdateProfileRequest $request)
    {

        $user = $request->user();

        $user->fill([
            'name' => $request->input('name'),
            'email' => $request->input('email')
        ]);

        if ($request->input('password')) {
            $user->password = bcrypt($request->input('password'));
        }

        $user->save();

        event(new ProfileUpdated($user));

        return response()->json(compact('user'));
    }
}
