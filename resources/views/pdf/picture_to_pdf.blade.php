<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        @page {
            margin: 0; /* Reset default page margin */
        }
        body {
            font-family: DejaVu Sans, sans-serif;
            margin: 0;
        }
        .page {
            width: 100%;
            height: 100vh; /* Full viewport height */
            padding: 2cm; /* Proportional padding */
            box-sizing: border-box; /* Include padding in width/height calculation */
            display: flex;
            align-items: center;
            justify-content: center;
            page-break-after: always; /* Each .page div will be a new page */
        }
        .page:last-child {
            page-break-after: avoid; /* Avoid a blank page after the last image */
        }
        img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain; /* Scale image to fit within the box while maintaining aspect ratio */
        }
    </style>
</head>
<body>
    @foreach($images as $image)
        <div class="page">
            <img src="file://{{ $image }}" alt="photo">
        </div>
    @endforeach
</body>
</html>

