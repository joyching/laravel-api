<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\User;
use App\Http\Requests\UpdateUser;
use App\Transformers\UserTransformer;

class UserController extends Controller
{
    protected $transformer;

    public function __construct(UserTransformer $transformer)
    {
        $this->transformer = $transformer;
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        return response()->json($this->transformer->transform(Auth::user()));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateUser $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUser $request)
    {
        $user = Auth::user();
        $user->name = $request->name;
        $user->save();

        return response()->json($this->transformer->transform($user));
    }
}
