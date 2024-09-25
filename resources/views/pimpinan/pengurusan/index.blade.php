@extends('template.layout')
@section('content')
<!-- DataTales Example -->
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
                        <th width="12%" style="text-align:center; vertical-align: middle;">Tanggal</th>
                        <th width="15%" style="text-align:center; vertical-align: middle;">Status</th>
                        <th width="15%" style="text-align:center; vertical-align: middle;">Cuti</th>
                        <th width="15%" style="text-align:center; vertical-align: middle;">Keterangan</th>
                        <th style="text-align:center; vertical-align: middle;">Dari</th>
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
                <h4 class="modal-title" id="exampleModalLabel">Tambah Sekolah</h4></b></center>    
            </div>
            <form action="#" method="POST" id="compose-form" enctype="multipart/form-data">
            @csrf
            <div class="modal-body"> 
                <div class="form-group">
                    <label>Tanggal</label>
                    <input type="date" name="tanggal" class="form-control" readonly>
                </div>
                <div class="form-group">
                    <label>Nama Pegawai</label>
                    <input type="text" name="nama" class="form-control" readonly>
                </div>
                <div class="form-group">
                    <label>Keperluan</label>
                    <input type="text" name="keperluan" class="form-control" readonly>
                </div>
                <div class="form-group">
                    <label>Verifikasi</label>
                    <select name="status" class="form-control">
                        <option value="Ditolak">Tolak Permintaan</option>
                        <option value="Disetujui">Setujui</option>
                    </select>
                </div>
                <button type="reset" class="btn btn-danger" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary btn-simpan">Simpan</button>
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
                            ico = 'spinner';
                        }else if(data === 'Disetujui')
                        {
                            btn = 'success';
                            hdd = 'hidden';
                            stat = 'disabled';
                            ico = 'check';
                        }else{
                            btn = 'danger';
                            stat = 'disabled';
                            hdd = 'hidden';
                            ico = 'ban';
                        }
                        
                        return '<button class="btn btn-'+btn+'"><i class="fa fa-'+ico+'"></i> '+data+'</button>';
                    }
                },
                {
                    data: 'jenis'
                },
                {
                    data: 'keterangan'
                },
                {
                    data: 'pegawai'
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
                        return '<button type="button" class="btn btn-warning btn-verif" data-id="' + data + '" '+stat+'><i class="fa fa-check"></i> Verifikasi</button>'
                    }
                },
            ]
        });
    });

    $("body").on("click",".btn-verif",function(){
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
                    jQuery("#compose-form input[name=tanggal]").val(row.tanggal);
                    jQuery("#compose-form input[name=nama]").val(row.pegawai);
                    jQuery("#compose-form input[name=keperluan]").val(row.keperluan);
                })
            }
        });
        jQuery("#compose-form").attr("action",'<?=url($page);?>/update/'+id);
        jQuery("#compose .modal-title").html("Update <?=$title?>");
        jQuery("#compose").modal("toggle");
    });
</script>
@endSection