@extends('template.onepage')

@section('content')
        <!-- start home -->
        <section id="feature1">
			<div class="container">
                <h2 class="text-uppercase my-3">{{$title}} {{Auth::user()->name}}</h2>
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <a href="#tambahdata" class="btn btn-primary btn-add" style="float: right;">
                        <i class="fa fa-plus"></i> Tambah Data</a>
                        <h6 class="m-0 font-weight-bold text-primary" style="padding: 12px 6px;">{{$title}}</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="datawidth" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th width="8%" style="text-align:center; vertical-align: middle;">No</th>
                                        <th style="text-align:center; vertical-align: middle;">Status</th>
                                        <th width="15%" style="text-align:center; vertical-align: middle;">Tenor</th>
                                        <th style="text-align:center; vertical-align: middle;">Jumlah Pinjaman</th>
                                        <th style="text-align:center; vertical-align: middle;">Keterangan</th>
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
        <section id="tambahdata" hidden>
			<div class="container wow fadeInUp animated">
                <div class="modal-content">
                    <div class="modal-header">
                        <center><b>
                        <h4 class="modal-title" id="exampleModalLabel">Tambah Data</h4></b></center>    
                    </div>
                    <form action="#" method="POST" id="compose-form" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body"> 
                            <input type="number" name="id_user" class="form-control d-none" value="{{Auth::user()->id}}" readonly>
                        <div class="form-group">
                            <label>Tenor</label>
                            <input type="number" name="tenor" onchange="hitung_pinjam()" placeholder="Ex: 5 ( 5 Bulan )" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Keterangan</label>
                            <input type="text" name="keterangan" class="form-control" placeholder="Ex: Pinjaman Modal Usaha" required>
                        </div>
                        <div class="form-group">
                            <label>Jumlah</label>
                            <input type="number" name="jumlah" onchange="hitung_pinjam()" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Cicilan</label>
                            <input type="number" name="b_cicilan" value="0" class="form-control" readonly>
                        </div>
                        <button type="reset" class="btn btn-danger" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary btn-simpan" disabled>Simpan</button>
                    </div>
                    </form>
                </div>
			</div>
		</section>
		<!-- end home -->
        <!-- start home -->
        <section id="ubahdata" hidden>
			<div class="container wow fadeInUp animated">
                <div class="modal-content">
                    <div class="modal-header">
                        <center><b>
                        <h4 class="modal-title" id="exampleModalLabel">Ubah Data</h4></b></center>    
                    </div>
                    <form action="#" method="POST" id="update-form" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body"> 
                        <label id="error" class="text-danger">Pinjaman Tidak Diizinkan</label>
                            <input type="number" name="id_user" class="form-control d-none" value="{{Auth::user()->id}}" readonly>
                        <div class="form-group">
                            <label>Tenor</label>
                            <input type="number" name="tenor" class="form-control" placeholder="Ex: 5 ( 5 Bulan )" onchange="hitung_pinjam()" required>
                        </div>
                        <div class="form-group">
                            <label>Keterangan</label>
                            <input type="text" name="keterangan" class="form-control" placeholder="Ex: Pinjaman Modal Usaha" required>
                        </div>
                        <div class="form-group">
                            <label>Jumlah</label>
                            <input type="number" name="jumlah" class="form-control" onchange="hitung_pinjam()" required>
                        </div>
                        <div class="form-group">
                            <label>Cicilan</label>
                            <input type="number" name="b_cicilan" value="0" class="form-control" readonly>
                        </div>
                        <button type="reset" class="btn btn-danger" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary btn-simpan" disabled>Simpan</button>
                    </div>
                    </form>
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
    let suku_bunga = {{$bunga}};
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
                    data: 'status', render: function(data)
                    {
                        let btn = 'info';
                        let ico = 'spinner';
                        if(data === 'Menunggu')
                        {   
                            btn = 'info';
                            ico = 'spinner';
                            btnstat = '';
                        }else if(data === 'Disetujui')
                        {
                            btn = 'success';
                            ico = 'check';
                            btnstat = 'disabled';
                        }else if(data === 'Ditolak'){
                            btn = 'danger';
                            ico = 'ban';
                            btnstat = 'disabled';
                        }else{
                            btn = 'primary';
                            ico = 'check';
                            btnstat = 'disabled';
                        }
                        
                        return '<button class="btn btn-'+btn+'"><i class="fa fa-'+ico+'"></i> '+data+'</button>';
                    }
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
                    data: 'keterangan'
                },
                {
                    data: 'id_pinjam',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        
                        return '<a href="#ubahdata" class="btn btn-success btn-edit" data-id="' + data + '" '+btnstat+'>\
                        <i class="fa fa-edit mx-0"></i></a>'
                    }
                },
            ]
        });
    });
    //Button Trigger
    $("body").on("click",".btn-add",function(){
        jQuery("#compose-form").attr("action",'<?=url($page);?>/save');
        jQuery("#tambahdata .modal-title").html("Tambah <?=$title;?>");
        jQuery("#tambahdata").prop("hidden",false);  
        jQuery("#ubahdata").prop("hidden",true);  
    });
    
    $("body").on("click",".btn-simpan",function(){
        Swal.fire(
            'Data Disimpan!',
            '',
            'success'
            )
    });

    $("body").on("click",".btn-edit",function(){

        jQuery("#tambahdata").prop("hidden",true);  
        jQuery("#ubahdata").prop("hidden",false);  
        var id = jQuery(this).attr("data-id");
                    
        $.ajax({
            url: "<?=url($page);?>/find/"+id,
            type: "GET",
            cache: false,
            dataType: 'json',
            success: function (dataResult) { 
                console.log(dataResult);
                var resultData = dataResult.data;
                $.each(resultData,function(index,row){
                    jQuery("#update-form input[name=tenor]").val(row.tenor);
                    jQuery("#update-form input[name=jumlah]").val(row.jumlah);
                    jQuery("#update-form input[name=keterangan]").val(row.keterangan);
                })
            }
        });
        jQuery("#update-form").attr("action",'<?=url($page);?>/update/'+id);
        jQuery("#ubahdata .modal-title").html("Update <?=$title?>");
    });
</script>
<script>
    $(function() {
        hitung_pinjam();
        $("#error").prop('hidden',true);
    })
    function hitung_pinjam()
    {
        var jumlah = jQuery("input[name=jumlah]").val();
        var tenor = jQuery("input[name=tenor]").val();
        var bunga = jumlah * suku_bunga/100;
        var cair = jumlah;
        var cicilan = (jumlah/tenor)+bunga ;
        if(tenor < 3 ){
            $(".btn-simpan").prop('disabled',true);
            $("#error").prop('hidden',false);
        }else{
            jQuery("input[name=b_cicilan]").val(cicilan.toFixed(0));
            $(".btn-simpan").prop('disabled',false);
            $("#error").prop('hidden',true);
        }
    }
</script>
@endsection