<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    // Store feedback (public/protected)
    public function store(Request $req)
    {
        $req->validate([
            'event_id'=>'required|exists:events,id',
            'user_id'=>'nullable|exists:users,id',
            'rating'=>'required|integer|min:1|max:5',
            'comments'=>'nullable|string'
        ]);

        $fb = Feedback::create($req->only(['event_id','user_id','rating','comments']));

        return response()->json(['message'=>'Feedback tersimpan','data'=>$fb],201);
    }

    // List feedbacks (admin)
    public function index()
    {
        return Feedback::with(['user','event'])->latest()->paginate(50);
    }
}
