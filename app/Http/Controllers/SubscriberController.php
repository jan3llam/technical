<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use App\Services\SubscriberService;
use Illuminate\Http\Request;

class SubscriberController extends Controller
{

    protected $subscriberService;

    public function __construct(SubscriberService $subscriberService)
    {
        $this->subscriberService = $subscriberService;
    }
    public function index(Request $request)
    {
        $subscribers = $this->subscriberService->index($request);

        return view('subscribers.index', compact('subscribers'));
    }

    public function create()
    {
        return view('subscribers.create');
    }

    public function store(Request $request)
    {
        $data = $this->subscriberService->store($request);

        return redirect()->route('subscribers.index')->with('success', 'Subscriber created successfully.');
    }

    public function edit()
    {
        $subscriber = Subscriber::findOrfail(request()->id);
        return view('subscribers.edit', compact('subscriber'));
    }

    public function update(Request $request, $id)
    {

        $data = $this->subscriberService->update($request,$id);

        return redirect()->route('subscribers.index')->with('success', 'Subscriber updated successfully.');
    }

    public function destroy($id)
    {
        $data = $this->subscriberService->destroy($id);

        return response()->json(['success'=> 'Subscriber deleted successfully.']);
    }
}
