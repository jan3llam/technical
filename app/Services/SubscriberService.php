<?php

namespace App\Services;

use App\Models\Subscriber;
use Hash;

class SubscriberService
{

    public function index($request)
    {
        $search = $request->input('search');
        $subscribers = Subscriber::where('name', 'LIKE', "%$search%")->paginate(10);

        return $subscribers;
    }

    public function store($request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|unique:subscribers',
            'password' => 'required|string|min:6',
            'status' => 'required|in:' . Subscriber::STATUS_ACTIVE . ',' . Subscriber::STATUS_INACTIVE,
        ]);

        $data['password'] = Hash::make($request['password']);

        $subscriber = Subscriber::create($data);

        $token = $subscriber->createToken('Token')->plainTextToken;

        return $subscriber;
    }

    public function update($request, $id)
    {
        $subscriber = Subscriber::findOrfail($id);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|unique:subscribers,username,' . $id,
            'status' => 'required|in:' . Subscriber::STATUS_ACTIVE . ',' . Subscriber::STATUS_INACTIVE,
        ]);

        $subscriber->update($data);

        $subscriber->save();

        return $subscriber;
    }

    public function destroy($id)
    {
        $subscriber = Subscriber::findOrfail($id);
        $subscriber->delete();

        return true;
    }

}
