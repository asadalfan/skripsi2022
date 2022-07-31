<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <!-- Styles -->
    <style>
        html,
        body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .links>a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }
    </style>

    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">
</head>

<body>
    <div class="flex-center position-ref full-height">
        @if (Route::has('login'))
            @auth
            <div class="top-right links">
                <a href="{{ url('/home') }}">Home</a>
            </div>
            @else
            <div class="top-right links">
                <a href="{{ route('login') }}">Login</a>
                @if (Route::has('register'))
                <a href="{{ route('register') }}">Register</a>
                @endif
            </div>
            <div>
                <div class="container-fluid">
                    <div class="row">
                        @foreach ($pekerjaans as $pekerjaan)
                        <div class="col">
                            <div class="card bg-light mb-3" style="width: 18rem;">
                                <div class="card-header h4">
                                    <div class="h4">
                                        {{ $pekerjaan->name }}
                                    </div>
                                    <div class="card-title btn-link h5">
                                        {{ $pekerjaan->perusahaan->name }}
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="card-text text-success">
                                        Diperbarui {{ date_format($pekerjaan->updated_at, 'd-m-Y') }}
                                    </div>
                                    <p class="card-title m-0 w-100">{{ $pekerjaan->description }}</p>
                                    <div>
                                        @if ($pekerjaan->status)
                                            <span class="badge badge-pill badge-success">Dibuka</span>
                                        @else
                                            <span class="badge badge-pill badge-danger">Ditutup</span>
                                        @endif
                                        <span class="badge badge-pill badge-info">{{ count($pekerjaan->lamarans) }} Pendaftar</span>
                                    </div>
                                    <div class="text-right">
                                        <button type="button" class="btn btn-link text-right p-0 m-0" onclick="daftarPekerjaan()">
                                            Daftar >>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endauth
        @endif
    </div>
</body>
<script>
    function daftarPekerjaan() {
        alert('Login terlebih dahulu untuk mendaftar!!');
    }
</script>

</html>
