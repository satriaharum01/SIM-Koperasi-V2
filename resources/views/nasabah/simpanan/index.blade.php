@extends('template.onepage')

@section('content')
        <!-- start home -->
        <section id="feature1">
			<div class="container">
                <h2 class="text-uppercase my-3">{{$title}} {{Auth::user()->name}}</h2>
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary" style="padding: 12px 6px;">{{$title}}</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="datawidth" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th width="8%" style="text-align:center; vertical-align: middle;">No</th>
                                        <th style="text-align:center; vertical-align: middle;">Tanggal</th>
                                        <th style="text-align:center; vertical-align: middle;">Keterangan</th>
                                        <th style="text-align:center; vertical-align: middle;">Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody style="text-align:center; vertical-align: middle;">
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
			</div>
		</section>
		<!-- end home -->
		<!-- start footer -->
@endsection
@section('js')
<script src="{{asset('node_modules/axios/dist/axios.min.js')}}"></script>
<script>
     let btnstat = '';
    $(function() {
        table = $('#datawidth').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{url("$page/json")}}'
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'tanggal'
                },
                {
                    data: 'keterangan'
                },
                {
                    data: 'jumlah' , render: function(data){
                        return '<div style="display: flex;flex-wrap: nowrap;align-content: center;justify-content: space-between;" class="px-2"><span>Rp. </span><span>'+number_format(data)+'</span></div>';
                    }
                },
            ]
        });
    });
</script>
@endsection