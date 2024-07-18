@extends('layouts.mobile')
@section('content')
    <div id="gambar_utama">

    </div>
    <div class="container">
        <div style="margin-top: -200px; border-radius: 15px;">
            <div class="card shadow" style="border-radius: 15px; border: none;">
                <div class="card-body">
                    <h4 id="judul_berita"></h4>
                    <div id="tanggal"></div>
                    <div id="gambar_utama2"></div>
                    <div id="content"></div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://unpkg.com/axios@0.27.2/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.7/dist/sweetalert2.all.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable({
                "ordering": false,
                "searching": false,
                language: {
                    paginate: {
                        next: '&#8594;', // or '→'
                        previous: '&#8592;' // or '←' 
                    }
                }
            });
        });

        axios.get('https://poltekbangplg.ac.id/wp-json/wp/v2/posts/{{ request('IDpost') }}').then(function(res) {

            document.querySelector('#gambar_utama').innerHTML = `<div id="gambar_utama"
                style="height: 300px; 
                background: url('${res.data.jetpack_featured_media_url}'); 
                background-position: center; 
                background-size: cover;">
            </div>`

            document.querySelector('#judul_berita').innerHTML = `${res.data.title.rendered}`

            document.querySelector('#tanggal').innerHTML = `<span class="badge bg-primary mb-2">${res.data.date}</span>`

            document.querySelector('#gambar_utama2').innerHTML = `<img src="${res.data.jetpack_featured_media_url}" style="margin-bottom: 20px; object-fit: cover;"  width="100%">`

            document.querySelector('#content').innerHTML = `${res.data.content.rendered}`
        })
    </script>
@endpush
