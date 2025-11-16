<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\Participant; // atau Registration/User
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class CertificateController extends Controller
{
    // Generate certificate record + PDF (protected)
    public function generate(Request $req)
    {
        $req->validate(['participant_id'=>'required','event_id'=>'required']);

        // buat token unik
        $token = Str::uuid()->toString();

        $cert = Certificate::create([
            'event_id'=>$req->event_id,
            'user_id'=>$req->participant_id,
            'certificate_number'=> 'SIMATRO-'.time(),
            'qr_token'=>$token
        ]);

        // prepare data untuk PDF view
        $participant = Participant::findOrFail($req->participant_id);
        $event = $cert->event()->first();

        $qrUrl = route('cert.verify', ['token'=>$token]); // pastikan route ada
        $qrSvg = QrCode::format('svg')->size(150)->generate($qrUrl);

        $pdf = Pdf::loadView('pdf.certificate', [
            'name'=>$participant->name,
            'event'=>$event,
            'issued_at'=>now()->toDateString(),
            'qr'=>$qrSvg
        ]);

        $filename = 'certificates/certificate-'.$cert->id.'.pdf';
        Storage::disk('public')->put($filename, $pdf->output());

        $cert->update(['file_path'=>$filename]);

        return response()->json(['message'=>'Sertifikat dibuat','data'=>$cert]);
    }

    // Download sertifikat by token (public)
    public function downloadByToken($token)
    {
        $cert = Certificate::where('qr_token',$token)->firstOrFail();
        if(! $cert->file_path || ! Storage::disk('public')->exists($cert->file_path)){
            return response()->json(['message'=>'File sertifikat tidak tersedia'],404);
        }

        return response()->download(storage_path('app/public/'.$cert->file_path));
    }

    // Verify token (public)
    public function verify($token)
    {
        $cert = Certificate::where('qr_token',$token)->with(['user','event'])->first();
        if(! $cert) return response()->json(['valid'=>false],404);
        return response()->json(['valid'=>true,'data'=>$cert]);
    }
}
