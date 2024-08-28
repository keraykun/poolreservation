<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Response;
class QRCodeController extends Controller
{
    public function generateQRCode()
    {
        // Generate a basic QR code
        $data = [
            'Name' => 'User Name',
            'User Account' => 'User123',
            'Room' => '123',
            'Couple Size' => '2',
            'Foods' => 'Pritong Baboy, Lechon Baboy',
            'Schedule' => 'Dec 15 - 06:00:00 pm ~ 11:59:59 pm',
            'Payment' => 'Pending',
        ];

        $text = implode("\n", array_map(function ($key, $value) {
            return "$key: $value";
        }, array_keys($data), $data));

        // Generate a QR code
        $qrCode = QrCode::size(100)->color(34, 71, 114)->generate($text);

        // You can return the QR code image directly or display it in a view
     //   return response($qrCode)->header('Content-Type', 'image/png');
     return view('qrcode', compact('qrCode', 'data'));
    }

    public function downloadQRCode()
    {
    // Generate a QR code as a file
    $data = [
        'Name' => 'User Name',
        'User Account' => 'User123',
        'Room' => '123',
        'Couple Size' => '2',
        'Foods' => 'Pritong Baboy, Lechon Baboy',
        'Schedule' => 'Dec 15 - 06:00:00 pm ~ 11:59:59 pm',
        'Payment' => 'Pending',
    ];

    $text = implode("\n", array_map(function ($key, $value) {
        return "$key: $value";
    }, array_keys($data), $data));

    $qrCode = QrCode::size(300)->generate($text);

    // Create a temporary file for the QR code
    $tempFilePath = storage_path('app/public/qrcode.png');
    file_put_contents($tempFilePath, $qrCode);

    // Return the file for download
    return Response::download($tempFilePath, 'qrcode.png')->deleteFileAfterSend(true);
}
}
