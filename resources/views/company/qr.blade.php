<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $company->company_name }} - QR Code</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background: #f5f5f5;
        }

        .qr-container {
            background: white;
            padding: 20px 40px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            text-align: center;
        }

        h2 {
            margin-bottom: 15px;
        }

        .qr {
            margin: 10px 0;
        }
    </style>
</head>
<body>
<div class="qr-container">
    <h2>{{ $company->company_name }}</h2>
    <div class="qr">
        {!! $qrCode !!}
    </div>
    <p><strong>Company ID:</strong> {{ $company->company_id }}</p>
    <p><strong>Token:</strong> {{ $company->qr_token }}</p>
</div>
</body>
</html>
