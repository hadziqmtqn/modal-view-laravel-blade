@extends('dashboard.layouts.master')
@section('judul')
{{$title}}
@endsection
@section('content')
@section('main_sidebar')
@include('dashboard.layouts.include_sidebar.sid_prestasi')
@endsection

@if(\Auth::user()->role > 0)
<div class="row">
    <div class="col-md-12">
        <h4>{{ $title }}</h4>
        <div class="box box-warning">
            <div class="box-header">
                <button class="btn btn-sm btn-flat btn-warning btn-refresh"><i class="fa fa-refresh"></i> Refresh</button>
                <a href="{{ url('peserta') }}" class="btn btn-sm btn-flat btn-primary"><i class="fa fa-users"></i> Semua Peserta</a>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama</th>
                                <th>Juara 1 Kecamatan</th>
                                <th>Nilai Juara 1 Kecamatan</th>
                                <th>Juara 1 Kabupaten</th>
                                <th>Juara 2 Kabupaten</th>
                                <th>Juara 3 Kabupaten</th>
                                <th>Juara 1 Provinsi</th>
                                <th>Juara 2 Provinsi</th>
                                <th>Juara 3 Provinsi</th>
                                <th>Juara Nasional</th>
                                <th>Peringkat 1</th>
                                <th>Hafal Juz Al Qur`an</th>
                                <th>Ijazah TPQ</th>
                                <th>Ijazah MDA</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($prestasi as $e=>$dt)
                            <tr>
                                <td>{{$e+1}}</td>
                                <td>
                                    <div style="width: 200px">
                                        {{$dt->prestasi_r->name}}
                                    </div>
                                </td>
                                <!-- juara 1 kec -->
                                <td>
                                    <div style="width: 200px">
                                        @if(empty($dt->juara1_kec))
                                        @else
                                        <!-- <a href="{{url($dt->juara1_kec)}}" target="_blank" class="btn btn-xs btn-primary"><i class="fa fa-eye"></i> Lihat</a> -->
                                        <button type="button" class="btn btn-primary btn-xs btn-view" data-modal="{{ $dt->id }}"><i class="fa fa-eye"></i>
                                            Lihat
                                        </button>
                                        <!-- validasi -->
                                        @if($dt->juara1_kec_valid == 0)
                                        <a href="{{ url('prestasi_valid/kec/'.$dt->id) }}" class="btn btn-xs btn-warning">Belum Valid</a>
                                        @elseif($dt->juara1_kec_valid == 1)
                                        <a href="{{ url('prestasi_undo_valid/kec/'.$dt->id) }}" class="btn btn-xs btn-primary">Sudah Valid</a>
                                        @endif
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div style="width: 200px">
                                        <a href="#" class="nilai" data-type="text" data-pk="{{$dt->nilai_juara1_kec}}" data-url="/api/prestasi/{{$dt->id}}" data-title="Masukan Nilai">{{$dt->nilai_juara1_kec}}</a>
                                    </div>
                                </td>
                                <!-- akhir juara 1 kec -->
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="pull-right">
                    {!! $prestasi->links() !!}
                </div>
            </div>
        </div>
    </div>
</div/>
@else
<div class="alert alert-danger alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h4><i class="icon fa fa-ban"></i> Peringatan!</h4>
    Maaf. Anda tidak diizinkan mengakses halaman ini.
</div>
@endif
@endsection
@section('scripts')

<!-- modal view prestasi -->
@foreach($prestasi as $e=>$dt)
<div class="modal fade" id="modal-view-{{ $dt->id }}" tabindex="-1" role="dialog" aria-labelledby="modal-notification" aria-hidden="true">
    <div class="modal-dialog modal-default modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title"><i class="fa fa-info-circle"></i> Juara 1 Kecamatan</h4>
            </div>
            <div class="modal-body">
                <img src="{{asset($dt->juara1_kec)}}" alt="" width="100%">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Tutup</button>
                <a href="{{asset($dt->juara1_kec)}}" target="_blank" type="button" class="btn btn-primary" name="button"><i class="fa fa-download"></i> Download</a>
            </div>
        </div>
    </div>
</div>
@endforeach
<!-- Modal -->

<script type="text/javascript">

$(document).ready(function(){

    $('#table-datatables').DataTable({
        dom: 'Bfrtip',
        buttons: ['copy', 'csv', 'excel', 'print']
    });

    // btn refresh
    $('.btn-refresh').click(function(e){
        e.preventDefault();
        $('.preloader').fadeIn();
        location.reload();
    })

    $('.nilai').editable();

    $('.btn-view').on('click',function(event){
        event.preventDefault();
        var id = $(this).attr('data-modal');
        // $('#modal-view').find('form').attr('action',url);
        $('#modal-view-'+id).modal();
    });

})
</script>

@endsection
