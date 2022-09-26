<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta name="Description" content="Enter your description here" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.0/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css" />
    <style>
        a {
            text-decoration: none;
        }

        body {
            /* background: linear-gradient(white, #d3d3d3); */
            /* background: url('Rectangle.png');
            background-position: center; */
            /* background-size: cover; */
            height: 100%;
        }

        .search::placeholder {
            color: #c5c9d2;
        }

        .nav-lt-tab .nav-item .nav-link.active {
            border-top: 2.5px solid #624bff;
        }

        .nav {
            display: inline-block;
            overflow: auto;
            overflow-y: hidden;
            max-width: 100%;
            /* margin: 0 0 1em; */
            white-space: nowrap;
        }

        .nav li {
            display: inline-block;
            vertical-align: top;
        }

        .nav-item {
            margin-bottom: 0 !important;
        }

        .nav:hover> ::-webkit-scrollbar-thumb {
            visibility: visible;
        }

        ::-webkit-scrollbar {
            width: 0.5rem;
        }

        .dataTables_length {
            display: none;
        }

        .dataTables_wrapper .dataTables_filter {
            float: none;
            text-align: start !important;
        }

        div.dataTables_wrapper div.dataTables_filter input {
            width: 100% !important;
            height: 35px;
            border-radius: 10px;
        }

        div.dataTables_wrapper div.dataTables_filter label {
            color: white;
        }

        .select2-container--bootstrap .select2-selection--single {
            height: 40px !important;
        }

        table.dataTable td.dataTables_empty, table.dataTable th.dataTables_empty {
            color: white;
        }


        /* div.dataTables_wrapper div.dataTables_filter input:focus::placeholder {
            content: 'Cari Taruna'
        } */
    </style>
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.12.1/datatables.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.min.css"
        integrity="sha512-kq3FES+RuuGoBW3a9R2ELYKRywUEQv0wvPTItv3DSGqjpbNtGWVdvT8qwdKkqvPzT93jp8tSF4+oN4IeTEIlQA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <nav class="navbar bg-white navbar-expand fixed-bottom" style="bottom: -10px; left: -15px; right: -15px;">
        <ul class="navbar-nav nav-justified w-100">
            <li class="nav-item">
                <a href="{{ url('/mobile/welcome') }}" class="nav-link">
                    <i style="font-size: 20px;" class="bi bi-house-door"></i>
                    <br>
                    <span style="font-size: 10px">HOME</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('mobile/berita') }}" class="nav-link">
                    <i style="font-size: 20px;" class="bi bi-newspaper"></i>
                    <br>
                    <span style="font-size: 10px">BERITA</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('mobile/nilai') }}" class="nav-link">
                    <i style="font-size: 20px;" class="bi bi-journal-text"></i>
                    <br>
                    <span style="font-size: 10px">NILAI</span>
                </a>
            </li>
            {{-- <li class="nav-item">
                <a href="{{ url('mobile/profil') }}" class="nav-link">
                    <i style="font-size: 20px;" class="bi bi-person"></i>
                    <br>
                    <span style="font-size: 10px">PROFILE</span>
                </a>
            </li> --}}
        </ul>
    </nav>
    @yield('content')
    <br><br><br><br>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>

    <script src="{{ asset('template/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('template/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.12.1/datatables.min.js"></script>

    @stack('script')
</body>

</html>
