<!DOCTYPE html>
<html>
<head>
<style>
    @page {
     size: A4 landscape; 
     margin: 0;
    }

        body {
            margin: 0;
            font-family: DejaVu Sans, sans-serif;
        }

        .page {
            width: 297mm;
            height: 210mm;
            position: relative;
            overflow: hidden;
            display: block;
        }

        .background {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: 0;
        }

        .content {
            position: relative;
            z-index: 1;
            padding: 180px 120px;
            text-align: center;
            color: #060505;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.7);
        }

        .title {
            font-size: 30px;
            font-weight: bold;
            margin-top: 10px;
        }

        .subtitle {
            font-size: 18px;
            margin-top: 12px;
        }

        .name {
            font-size: 24px;
            margin-top: 20px;
            font-weight: bold;
        }

        .description {
            font-size: 14px;
            margin-top: 16px;
        }

        .link {
            font-size: 12px;
            margin-top: 16px;
        }

        .signature {
            text-align: center;
        }

        .sinta {
            z-index: 2;
            position: absolute;
            bottom: 100px;
            left: 100px;
        }

        .sinta img {
            width: 200px;
            height: 80px;

        }

        .qrcode {
            z-index: 2;
            position: absolute;
            bottom: 100px;
            right: 100px;
        }

        .qrcode img {
            height: 120px;
        }
    </style>
</head>
<body> 
    <div class="page" style="background-image: url({{$backgroundPath}}); background-size: cover; background-repeat: no-repeat;">
        <div class="content">
            <div class="title">Certificate of Appreciation</div>
            <div class="description">
               Certificate Number: <strong>{{$sk_number}}</strong>
            </div>
            <div class="subtitle">This is to certify that</div>
            <div class="name">{{$user}}</div>

            <div class="description">
               has served as a <strong>{{$position}}</strong> for the journal
            </div>

            <div class="description">
                <strong> {{$journal}} </strong>
            </div>

            <div class="description">
                @if($position === 'Reviewer')
                    in recognition of their valuable contribution in reviewing manuscripts and ensuring the quality and integrity of research published in this journal.
                @else
                    in recognition of their valuable contribution in managing and overseeing the editorial process, ensuring the quality and integrity of research published in this journal.
                @endif
            </div>
        </div>

        <div class="qrcode">
            <img src="data:image/png;base64,{{ $qrcode }}" alt="QR Code">
        </div>
    </div>
</body>
</html>
