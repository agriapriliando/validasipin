<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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
            // ->gradient($from[0], $from[1], $from[2], $to[0], $to[1], $to[2], 'diagonal')
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

    public function report($id)
    {
        $mhs = User::find($id);
        return view('report', compact('mhs'));
    }
}
