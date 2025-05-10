<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>404 - Halaman Tidak Ditemukan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        :root {
            --bg-light: #f8fafc;
            --text-light: #2d3748;
            --desc-light: #4a5568;
            --btn-light: #4299e1;
            --btn-hover-light: #2b6cb0;

            --bg-dark: #1a202c;
            --text-dark: #e2e8f0;
            --desc-dark: #a0aec0;
            --btn-dark: #63b3ed;
            --btn-hover-dark: #3182ce;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            text-align: center;
            background-color: var(--bg-light);
            color: var(--text-light);
        }

        h1 {
            font-size: 6rem;
            margin: 0;
        }

        p {
            font-size: 1.5rem;
            margin-bottom: 2rem;
            color: var(--desc-light);
        }

        a {
            padding: 0.8rem 1.6rem;
            font-size: 1rem;
            background-color: var(--btn-light);
            color: white;
            border: none;
            border-radius: 6px;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        a:hover {
            background-color: var(--btn-hover-light);
        }

        @media (prefers-color-scheme: dark) {
            body {
                background-color: var(--bg-dark);
                color: var(--text-dark);
            }

            p {
                color: var(--desc-dark);
            }

            a {
                background-color: var(--btn-dark);
            }

            a:hover {
                background-color: var(--btn-hover-dark);
            }
        }
    </style>
</head>
<body>
    <h1>404</h1>
    <p>Oops! Halaman yang kamu cari tidak ditemukan.</p>

    @php
    use Filament\Facades\Filament;
    
    $redirectPath = Filament::getUrl();
    @endphp
    @auth
        <a href="{{ $redirectPath }}">Kembali ke Halaman Utama</a>
    @else
        <a href="{{ route('login') }}">Login Sekarang</a>
    @endauth
</body>
</html>
