<!DOCTYPE html>
<html>
<head>
    <title>Cetak QR Code</title>
    <style>
        body{
            font-family: Arial, sans-serif;
        }

        .box{
            width:300px;
            border:1px solid #000;
            padding:15px;
            margin:15px;
            text-align:center;
            float:left;
        }

        .pt{
            font-weight:bold;
            font-size:14px;
        }

        .sub{
            font-size:12px;
            margin-bottom:8px;
        }

        .kode{
            font-size:12px;
            margin:10px 0;
        }
    </style>
</head>
<body onload="window.print()">

@foreach($barangs as $barang)
    <div class="box">
        <div class="pt">PT DESIGN JAYA INDONESIA</div>
        <div class="sub">(KIOS BANK)</div>

        <div class="kode">
            {{ $barang->no_asset }}
        </div>

        {!! QrCode::size(200)->generate($barang->no_asset) !!}
    </div>
@endforeach

</body>
</html>