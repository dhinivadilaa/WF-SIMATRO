<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Participant; // kalau kamu pakai participants; kalau memakai users ganti modelnya
use App\Models\Registration; // jika pakai registration table
use Illuminate\Http\Request;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    // Absensi via email + pin (public)
    public function checkInByEmailPin(Request $req)
    {
        $req->validate(['email'=>'required|email','pin'=>'required']);

        // contoh: jika peserta disimpan di participants table
        $participant = Participant::where('email',$req->email)->where('pin',$req->pin)->first();
        if(! $participant){
            return response()->json(['message'=>'Email atau PIN tidak ditemukan'],422);
        }

        // Hindari duplikasi check-in (satu kali per event)
        $already = Attendance::where('event_id',$participant->event_id)
                    ->where('user_id',$participant->id)
                    ->first();
        if($already){
            return response()->json(['message'=>'Sudah absen sebelumnya','data'=>$already]);
        }

        $att = Attendance::create([
            'event_id' => $participant->event_id,
            'user_id'  => $participant->id,
            'is_present' => true,
            'check_in_time' => Carbon::now()
        ]);

        return response()->json(['message'=>'Absensi berhasil','data'=>$att],201);
    }

    // Admin: list attendances (protected)
    public function index(Request $req)
    {
        return Attendance::with(['event','user'])->latest()->paginate(50);
    }
}
