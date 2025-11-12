<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <style>
            body {
                font-family: DejaVu Sans, sans-serif;
                margin: 0;
                padding: 0;
            }
            .page {
                text-align: center;
            }
            .page:not(:last-child) {
                page-break-after: always;
            }
            img {
                max-width: 100%;
                height: auto;
            }
            .caption {
                margin-top: 8px;
                font-size: 12px;
                color: #333;
            }
        </style>
    </head>
    <body>
        @foreach($images as $img)
        <div class="page">
            <img src="file://{{ $img }}" alt="photo" />
        </div>
        @endforeach
    </body>
</html>
