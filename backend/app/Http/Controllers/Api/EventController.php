<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    // List semua event (public)
    public function index()
    {
        return Event::with(['materials','feedbacks'])->orderBy('start_time','desc')->get();
    }

    // Detail event (public)
    public function show($id)
    {
        return Event::with(['materials','feedbacks','attendances'])->findOrFail($id);
    }

    // Buat event (protected)
    public function store(Request $req)
    {
        $req->validate([
            'title'=>'required|string',
            'start_time'=>'required|date',
        ]);

        $event = Event::create($req->only(['title','description','speaker','start_time','end_time','location','banner']));

        return response()->json(['message'=>'Event dibuat','data'=>$event],201);
    }

    // Update event (protected)
    public function update(Request $req, $id)
    {
        $event = Event::findOrFail($id);
        $event->update($req->only(['title','description','speaker','start_time','end_time','location','banner']));
        return response()->json(['message'=>'Event diperbarui','data'=>$event]);
    }

    // Hapus event (protected)
    public function destroy($id)
    {
        Event::destroy($id);
        return response()->json(['message'=>'Event dihapus']);
    }
}
