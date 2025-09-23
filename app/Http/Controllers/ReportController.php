<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
// untuk QRCode
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Writer;

class ReportController extends Controller
{
    public function qrcode($id)
    {
        $from = [255, 0, 0];
        $to = [0, 0, 255];
        $qrcode = QrCode::size(200)
            ->format('png')
            // ->merge('/storage/app/twitter.jpg')
            // ->merge('/public/assets/agri.png', 0.6)
            ->merge('/public/assets/chrismas.png', 0.6)
            ->errorCorrection('M')
            ->margin(1)
            // ->style('dot')
            // ->eye('circle')
            ->gradient($from[0], $from[1], $from[2], $to[0], $to[1], $to[2], 'diagonal')
            ->generate(url('report/' . $id));
        return base64_encode($qrcode);
    }

    public function savenohp(Request $request, $nim)
    {
        $user = User::whereNim($request->nim)->first();
        $user->nohp = $request->nohp;
        $user->save();
        return redirect('report/' . $user->id)->with('status', 'No HP Diperbaharui');
    }

    public function updateberkas(Request $request, $nim)
    {
        $request->validate([
            'berkas' => 'required|file|mimes:pdf,jpg,jpeg,png',
        ]);

        $user = User::where('nim', $nim)->firstOrFail();
        $file = $request->file('berkas');
        $extension = strtolower($file->getClientOriginalExtension());
        $fileName = $user->nim . '_' . $user->nama_mahasiswa . '_' . date('Ymd_His') . '.' . $extension;
        $sizeKB   = $file->getSize() / 1024;

        if (in_array($extension, ['jpg', 'jpeg', 'png', 'webp']) && $sizeKB > 500) {
            $manager = new ImageManager(new Driver());
            $image   = $manager->read($file->getRealPath());

            // Resize max 1280px
            $image->resize(1280, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            // Simpan ke JPG kualitas 70
            $compressed = (string) $image->encodeByExtension('jpg', quality: 70);

            // Jika masih > 500KB, turunkan lagi ke 50
            if ((strlen($compressed) / 1024) > 500) {
                $compressed = (string) $image->encodeByExtension('jpg', quality: 50);
            }

            Storage::disk('public')->put("berkas/$fileName", $compressed);
            $path = "berkas/$fileName";
        } else {
            $path = $file->storeAs('berkas', $fileName, 'public');
        }

        $user->berkas = $path;
        $user->save();

        return redirect('report/' . $user->id)->with('status', 'Berkas Diperbaharui');
    }

    public function report($id)
    {
        $mhs = User::find($id);
        return view('report', compact('mhs'));
    }
}
