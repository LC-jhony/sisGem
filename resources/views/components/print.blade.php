<html>

<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <link rel="stylesheet" href="{{ public_path('print_pdf.css') }}" type="text/css">
</head>

<body>

    <head>
        <div class="logo">
            <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('img/logo.jpeg'))) }}"
                alt="Logo">
        </div>
    </head>
    <main>
        {{ $slot }}
    </main>

</body>

</html>
