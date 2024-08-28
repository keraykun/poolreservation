<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code</title>
</head>
<body>
    <div>
        {!! $qrCode !!}
    </div>
    <a href="data:image/png;base64,{{ base64_encode($qrCode) }}" download="qrcode.png">Download QR Code</a>
    <div>
        {{-- Display the reservation information --}}
        <pre>{{ print_r($data, true) }}</pre>
    </div>
</body>
</html>
