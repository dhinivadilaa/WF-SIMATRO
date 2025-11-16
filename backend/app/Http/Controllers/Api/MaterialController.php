<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Material;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MaterialController extends Controller
{
    // Admin upload materi (protected)
    public function store(Request $req)
    {
        $req->validate([
            'event_id'=>'required|exists:events,id',
            'title'=>'required|string',
            'file'=>'nullable|file|max:10240'
        ]);

        $path = null;
        if($req->hasFile('file')){
            $path = $req->file('file')->store('materials','public');
        }

        $mat = Material::create([
            'event_id'=>$req->event_id,
            'title'=>$req->title,
            'description'=>$req->description,
            'file_path'=>$path
        ]);

        return response()->json(['message'=>'Materi terupload','data'=>$mat],201);
    }

    // List materi by event (public/protected)
    public function index($eventId)
    {
        return Material::where('event_id',$eventId)->get();
    }

    // Download file
    public function download($id)
    {
        $mat = Material::findOrFail($id);
        if(! $mat->file_path || ! Storage::disk('public')->exists($mat->file_path)){
            return response()->json(['message'=>'File tidak ditemukan'],404);
        }
        return response()->download(storage_path('app/public/'.$mat->file_path));
    }

    // Delete materi (protected)
    public function destroy($id)
    {
        $mat = Material::findOrFail($id);
        if($mat->file_path && Storage::disk('public')->exists($mat->file_path)){
            Storage::disk('public')->delete($mat->file_path);
        }
        $mat->delete();
        return response()->json(['message'=>'Materi dihapus']);
    }
}
