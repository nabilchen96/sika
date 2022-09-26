@extends('layouts.mobile')
@section('content')
    <div
        style="height: 300px; background: linear-gradient(130deg, black, transparent, transparent), url('{{ asset('plane.png') }}'); background-position: center; background-size: cover;">

    </div>
    <div class="container">
        <div class="ps-2" style="margin-top: -270px;">
            <h2 class="text-white">Info & Berita</h2>
            <h4 class="text-white">poltekbangplg.ac.id</h4>
        </div>
        <div style="margin-top: 20px; border-radius: 15px;">
            <div id="post">

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

        axios.get('https://poltekbangplg.ac.id/wp-json/wp/v2/posts').then(function(res) {
            
            console.log(res.data);
            
            let postData = ''

            res.data.forEach(e => {

                if(e.categories[0] != 216){

                    postData += `<a style="color: black;" href="/mobile/detail-berita?IDpost=${e.id}">
                                    <div class="card shadow mb-3" style="border-radius: 15px;">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-4">
                                                    <div class="div"
                                                        style="border-radius: 15px; 
                                                        width: 100%; 
                                                        background: url('${e.jetpack_featured_media_url}');
                                                        background-size: cover;
                                                        backgorund-position: center;
                                                        aspect-ratio: 1/1;">
                                                    </div>
                                                </div>
                                                <div class="col-8">
                                                    ${e.title.rendered}<br>
                                                    <span class="badge bg-primary">${e.date}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>`
                }
            });


            document.querySelector('#post').innerHTML = postData
        })
    </script>
@endpush
