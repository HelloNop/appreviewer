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
        }

        .subtitle {
            font-size: 18px;
            margin-top: 8px;
        }

        .name {
            font-size: 24px;
            margin-top: 20px;
            font-weight: bold;
        }

        .description {
            font-size: 16px;
            margin-top: 16px;
        }

        .journal {
            font-size: 18px;
            margin-bottom: 16px;
            margin-top: 20px;
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
            <div class="journal">
                <strong> {{$data['journal']}} </strong>
            </div>
            <div class="title">Certificate of Reviewing</div>
            <div class="subtitle">Awarded in {{$data['bulan']}} {{$data['tahun']}}</div>
            <div class="subtitle">presented to</div>
            <div class="name">{{$data['name'] ?? $data['user'] ?? 'Reviewer'}}</div>
            <div class="description">
                in recognition of the review made for the article entitled:
            </div>
            <div class="description">
                "{{$data['judul']}}"
            </div>
        </div>

        <div class="qrcode">
            <img src="data:image/png;base64,{{ $data['qrcode'] }}">
        </div>
    </div>
</body>
</html>
