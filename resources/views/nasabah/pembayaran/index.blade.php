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
                                        <th style="text-align:center; vertical-align: middle;">Keterangan</th>
                                        <th width="15%" style="text-align:center; vertical-align: middle;">Tenor</th>
                                        <th style="text-align:center; vertical-align: middle;">Jumlah Pinjaman</th>
                                        <th style="text-align:center; vertical-align: middle;">Status</th>
                                        <th style="text-align:center; vertical-align: middle;">#</th>
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
        
        <!-- start home -->
        <section id="pembayaranData" hidden>
			<div class="container wow fadeInUp animated">
                <div class="modal-content">
                    <div class="modal-header">
                        <center><b>
                        <h4 class="modal-title" id="exampleModalLabel">Data Pembayaran Cicilan</h4></b></center>    
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                          <table class="table table-bordered" id="data-bayar" width="100%" cellspacing="0">
                              <thead>
                                  <tr>
                                        <th width="8%" style="text-align:center; vertical-align: middle;">No</th>
                                        <th width="25%" style="text-align:center; vertical-align: middle;">Jumlah</th>
                                        <th style="text-align:center; vertical-align: middle;">Keterangan</th>
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
                    data: 'keterangan'
                },
                {
                    data: 'tenor', render: function(data){
                        return data+' Bulan';
                    }
                },
                {
                    data: 'jumlah', render: function(data){
                        return '<div style="display: flex;flex-wrap: nowrap;align-content: center;justify-content: space-between;" class="px-2"><span>Rp. </span><span>'+number_format(data)+'</span></div>';
                    }
                },
                {
                    data: 'status', render: function(data)
                    {
                        let btn = 'info';
                        let ico = 'spinner';
                        if(data === 'Lunas')
                        {   
                            btn = 'success';
                            ico = 'check';
                        }else{
                            btn = 'primary';
                            ico = 'spinner';
                            data = 'Berjalan';
                        }
                        
                        return '<button class="btn btn-'+btn+'"><i class="fa fa-'+ico+'"></i> '+data+'</button>';
                    }
                },
                {
                    data: 'id_pinjam',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        
                        return '<a href="#pembayaranData" class="btn btn-primary btn-eye" data-id="' + data + '" '+btnstat+'>\
                        <i class="fa fa-eye mx-0"></i></a>'
                    }
                },
            ]
        });
        table1 = $('#data-bayar').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{url("$page/find/0")}}'
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'jumlah', render: function(data){
                        return '<div style="display: flex;flex-wrap: nowrap;align-content: center;justify-content: space-between;" class="px-2"><span>Rp. </span><span>'+number_format(data)+'</span></div>';
                    }
                },
                {
                    data: 'keterangan'
                },
            ]
        });
    });
    $("body").on("click",".btn-eye",function(){
        jQuery("#pembayaranData").prop("hidden",false);  
        var id = jQuery(this).attr("data-id");

        table1.ajax.url('{{("$page/find")}}/' + id).load();
    });
</script>
@endsection