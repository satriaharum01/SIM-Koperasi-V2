@extends('template.layout')
@section('content')



<!-- Page Heading
<h1 class="h3 mb-2 text-gray-800">Tables</h1>
<p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
    For more information about DataTables, please visit the <a target="_blank"
        href="https://datatables.net">official DataTables documentation</a>.</p>
 -->
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <button type="button" class="btn btn-primary btn-add" style="float: right;" data-toggle="modal" data-target="#compose"><i class="fa fa-plus"></i> Tambah Data 
        </button>
        <h6 class="m-0 font-weight-bold text-primary" style="padding: 12px 6px;">{{$title}}</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="datawidth" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th width="8%" style="text-align:center; vertical-align: middle;">No</th>
                        <th width="20%" style="text-align:center; vertical-align: middle;">Nama Nasabah</th>
                        <th style="text-align:center; vertical-align: middle;">Pinjaman</th>
                        <th style="text-align:center; vertical-align: middle;">Jumlah Pembayaran</th>
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

<!-- ============ MODAL DATA JADWAL =============== -->

<div class="modal fade" id="compose" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <center><b>
                    <h4 class="modal-title" id="exampleModalLabel">Tambah Data</h4></b></center>    
                </div>
                <form action="#" method="POST" id="compose-form" enctype="multipart/form-data">
                @csrf
                <div class="modal-body"> 
                    <div class="form-group">
                        <label>Pinjaman</label>
                        <select name="id_pinjam" id="id_pinjam" class="form-control">
                            <option value="0" selected disabled>-- Pilih Pinjaman --</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Tanggal</label>
                        <input type="date" name="tanggal" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Keterangan</label>
                        <input type="text" name="keterangan" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Jumlah</label>
                        <input type="number" name="jumlah" class="form-control" required>
                    </div>
                    <button type="reset" class="btn btn-danger" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary btn-simpan">Simpan</button>
                </div>
                </form>
            </div>
        </div>
</div>
<!--- END MODAL DATA JADWAL--->
<!-- /.container-fluid -->
@endSection()
@section('js')
<script>
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
                    data: 'nasabah'
                },
                {
                    data: 'pinjaman', render: function(data){
                        return '<div style="display: flex;flex-wrap: nowrap;align-content: center;justify-content: space-between;" class="px-2"><span>Rp. </span><span>'+number_format(data)+'</span></div>';
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
                    data: 'id_bayar',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        return '<button type="button" class="btn btn-success btn-edit" data-id="' + data + '"><i class="fa fa-edit"></i> </button>\
                        <a class="btn btn-danger btn-hapus" data-id="' + data + '" data-handler="pembayaran" href="<?= url('admin/pembayaran/delete') ?>/' + data + '">\
                        <i class="fa fa-trash"></i> </a> \
					    <form id="delete-form-' + data + '-pembayaran" action="<?= url('admin/pembayaran/delete') ?>/' + data + '" \
                        method="GET" style="display: none;"> \
                        </form>';
                    }
                },
            ]
        });

        $.ajax({
            url: "{{ url('/filter/pinjaman/json')}}",
            type: "GET",
            cache: false,
            dataType: 'json',
            success: function(dataResult) {
                console.log(dataResult);
                var resultData = dataResult.data;
                $.each(resultData, function(index, row) {
                    $('#id_pinjam').append('<option value="' + row.id_pinjam + '">' + row.nasabah + ' - Rp. ' + number_format(row.jumlah) + '</option>');
                })
            }
        });
    });

    //Button Trigger
    $("body").on("click",".btn-add",function(){
        kosongkan();
        jQuery("#compose-form").attr("action",'<?=url($page);?>/save');
        jQuery("#compose .modal-title").html("Tambah <?=$title;?>");
        jQuery("#compose").modal("toggle");  
    });

    $("body").on("click",".btn-edit",function(){
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
                    jQuery("#compose-form input[name=keterangan]").val(row.keterangan);
                    jQuery("#compose-form input[name=jumlah]").val(row.jumlah);
                    jQuery("#compose-form input[name=tanggal]").val(row.tanggal);
                    jQuery("#compose-form select[name=id_pinjam]").val(row.id_pinjam);
                })
            }
        });
        jQuery("#compose-form").attr("action",'<?=url($page);?>/update/'+id);
        jQuery("#compose .modal-title").html("Update <?=$title?>");
        jQuery("#compose").modal("toggle");
    });
    
    $("body").on("click",".btn-simpan",function(){
        Swal.fire(
            'Data Disimpan!',
            '',
            'success'
            )
    });
        
    function kosongkan()
    {
        jQuery("#compose-form select[name=id_pinjam]").val('0');
        jQuery("#compose-form input[name=jumlah]").val();
        jQuery("#compose-form input[name=keterangan]").val();
    }
</script>
@endSection