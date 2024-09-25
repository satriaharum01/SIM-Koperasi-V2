@extends('template.layout')
@section('content')
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <button type="button" class="btn btn-primary btn-add" style="float: right;"><i class="fa fa-plus"></i> Tambah Data 
        </button>
        <h6 class="m-0 font-weight-bold text-primary" style="padding: 12px 6px;">{{$title}}</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="datawidth" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th width="8%" style="text-align:center; vertical-align: middle;">No</th>
                        <th width="12%" style="text-align:center; vertical-align: middle;">Tanggal</th>
                        <th width="15%" style="text-align:center; vertical-align: middle;">Status</th>
                        <th width="15%" style="text-align:center; vertical-align: middle;">Keperluan</th>
                        <th width="15%" style="text-align:center; vertical-align: middle;">Keterangan</th>
                        <th style="text-align:center; vertical-align: middle;">Kepada</th>
                        <th width="10%" style="text-align:center; vertical-align: middle;">File</th>
                        <th width="15%" style="text-align:center; vertical-align: middle;">#</th>
                    </tr>
                </thead>
                <tbody style="text-align:center; vertical-align: middle;">
                        
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ============ MODAL DATA JADWAL =============== -->

<div class="modal fade" id="compose" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <center><b>
                <h4 class="modal-title" id="exampleModalLabel">Generator Barcode</h4></b></center>    
            </div>
            <form action="#" method="POST" id="compose-form" enctype="multipart/form-data">
            @csrf
            <div class="modal-body text-center"> 
                <div class="form-group d-flex justify-content-center">
                    <div class="mb-3 p-4" id="gen-barcode">Membuat Barcode ...</div> 
                </div>
                <button type="reset" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                <button type="button" class="btn btn-primary btn-simpan" onclick="download()"><i class="fa fa-download"></i> Download</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!--- END MODAL DATA JADWAL--->
@endSection
@section('js')
<script>
    $(function() {
        var stat = 'disabled';
        var hdd = 'hidden';
        var dln = 'hidden';
        var ico = 'spinner';
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
                    data: 'status', render: function(data)
                    {
                        let btn = 'info';
                        if(data === 'Menunggu')
                        {   
                            btn = 'info';
                            stat = '';
                            hdd = '';
                            dln = 'hidden';
                            ico = 'spinner';
                        }else if(data === 'Disetujui')
                        {
                            btn = 'success';
                            hdd = 'hidden';
                            dln = '';
                            stat = 'disabled';
                            ico = 'check';
                        }else{
                            btn = 'danger';
                            stat = 'disabled';
                            dln = 'hidden';
                            hdd = 'hidden';
                            ico = 'ban';
                        }
                        
                        return '<button class="btn btn-'+btn+'"><i class="fa fa-'+ico+'"></i> '+data+'</button>';
                    }
                },
                {
                    data: 'keperluan'
                },
                {
                    data: 'keterangan'
                },
                {
                    data: 'pimpinan'
                },
                {
                    data: 'berkas', render: function(data,type){
                        if(data != null){
                            return '<a href="<?=$path?>/'+data+'" target="_blank"><i class="fa fa-file-text fa-3x"></i></a>';
                        }else{
                            return '<a href="#"><i class="fa fa-ban fa-2x"></i></a>';
                        }
                    }
                },
                {
                    data: 'id_pengurusan',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        return '<button type="button" class="btn btn-success btn-edit" data-id="' + data + '" '+stat+'><i class="fa fa-edit"></i> </button>\
                        <button type="button" class="btn btn-primary btn-barcode" data-id="' + data + '" '+dln+'><i class="fa fa-download"></i> </button>\
                        <a class="btn btn-danger btn-hapus" data-id="' + data + '" data-handler="pengurusan" '+hdd+' href="<?= url('pegawai/pengurusan/delete') ?>/' + data + '">\
                        <i class="fa fa-trash"></i> </a> \
					    <form id="delete-form-' + data + '-pengurusan" action="<?= url('pegawai/pengurusan/delete') ?>/' + data + '" \
                        method="GET" style="display: none;"> \
                        </form>'
                    }
                },
            ]
        });
    });

    $("body").on("click",".btn-add",function(){
       window.location.href = "{{route('pegawai.pengurusan.baru')}}";
    });
    $("body").on("click",".btn-edit",function(){
       var id = jQuery(this).attr("data-id");
       window.location.href = "{{url('/pegawai/pengurusan/edit')}}/"+id;
    });
    
    $("body").on("click",".btn-barcode",function(){
        var id = jQuery(this).attr("data-id");
        $.ajax({
            url: "<?=url($page);?>/barcode/"+id,
            type: "GET",
            cache: false,
            dataType: 'json',
            success: function (dataResult) { 
                console.log(dataResult);
                var resultData = dataResult.data;
                $.each(resultData,function(index,row){
                    jQuery("#gen-barcode").html(row.barcode);
                })
            }
        });
        jQuery("#compose").modal("toggle");
    });


    function download()
    {
        html2canvas(document.querySelector("#gen-barcode")).then(canvas => {
            var element = document.createElement('a');
            document.body.appendChild(element);
            var filename = 'barcode.png';
            element.setAttribute('href', canvas.toDataURL());
            element.setAttribute('download', filename);

            element.click();
        });
        //Setup download button event listener
    }
</script>
@endSection