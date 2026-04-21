<!DOCTYPE html>
<html>
<head>
    <title>QR Code Barang</title>
    <style>
        body{
            margin:0;
            display:flex;
            justify-content:center;
            align-items:center;
            height:100vh;
            font-family:Arial, sans-serif;
            background:white;
        }

        .box{
            border:2px solid #000;
            padding:20px;
            border-radius:12px;
            text-align:center;
            width:330px;
        }

        .logo{
            width:80px;
            margin-bottom:10px;
        }

        .pt{
            font-size:14px;
            font-weight:bold;
            margin-bottom:2px;
        }

        .sub{
            font-size:12px;
            margin-bottom:12px;
        }

        .kode{
            font-size:13px;
            font-weight:bold;
            margin:12px 0;
        }

        @media print {
            body{
                height:auto;
            }
        }
    </style>
</head>
<body onload="window.print()">

<div class="box">

    <img src="{{ asset('kiosbank.png') }}" 
         alt="Logo Kiosbank" 
         class="logo">

    <div class="pt">
        PT DESIGN JAYA INDONESIA
    </div>

    <div class="sub">
        (KIOS BANK)
    </div>

    <div class="kode">
        {{ $barang->no_asset }}
    </div>

    {{-- 🔥 PAKAI QR DARI CONTROLLER --}}
    {!! $qr !!}

</div>

</body>
</html>