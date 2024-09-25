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
                        <th width="15%" style="text-align:center; vertical-align: middle;">Tenor</th>
                        <th style="text-align:center; vertical-align: middle;">Jumlah Pinjaman</th>
                        <th style="text-align:center; vertical-align: middle;">Status</th>
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
                        <label>Nasabah</label>
                        <select name="id_user" id="id_user" class="form-control">
                            <option value="0" selected disabled>-- Pilih Nasabah --</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Tanggal</label>
                        <input type="date" name="tanggal" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Suku Bunga %</label>
                        <input type="number" name="bunga" value="{{$bunga->value ?? 1}}" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label>Tenor</label>
                        <input type="number" name="tenor" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Jumlah</label>
                        <input type="number" name="jumlah" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control">
                            <option value="Menunggu" selected>Menunggu</option>
                            <option value="Disetujui" selected>Disetujui</option>
                            <option value="Ditolak" selected>Ditolak</option>
                            <option value="Lunas" selected>Lunas</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Keterangan</label>
                        <input type="text" name="keterangan" class="form-control" required>
                    </div>
                    <button type="reset" class="btn btn-danger" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary btn-simpan">Simpan</button>
                </div>
                </form>
            </div>
        </div>
</div>
<!--- END MODAL DATA JADWAL--->
<!--- Modal Validasi -->

<div class="modal fade" id="compose-2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <center><b>
                <h4 class="modal-title" id="exampleModalLabel-2">Tambah Data</h4></b></center>    
            </div>
            <form action="#" method="POST" id="validasi-form" enctype="multipart/form-data">
            @csrf
            <div class="modal-body"> 
                <div class="form-group">
                    <label>Status</label>
                    <input type="text" name="status" class="form-control">
                </div>
                <button type="reset" class="btn btn-danger" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary btn-simpan">Simpan</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- /.Modal Validasi -->
<!-- /.container-fluid -->
@endSection()
@section('js')
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
                    data: 'name'
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
                        if(data === 'Menunggu')
                        {   
                            btn = 'info';
                            ico = 'spinner';
                            btnstat = '';
                        }else if(data === 'Disetujui')
                        {
                            btn = 'success';
                            ico = 'check';
                            btnstat = '';
                        }else if(data === 'Ditolak'){
                            btn = 'danger';
                            ico = 'ban';
                            btnstat = 'disabled'
                        }else{
                            btn = 'primary';
                            ico = 'check';
                            btnstat = 'disabled';
                        }
                        
                        return '<button class="btn btn-'+btn+'"><i class="fa fa-'+ico+'"></i> '+data+'</button>';
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
                        
                        return '<button class="btn btn-primary btn-validasi" data-id="' + data + '" '+btnstat+'>\
                        <i class="fa fa-check"></i> </button>\
                        <button class="btn btn-primary btn-eye" data-id="' + data + '">\
                        <i class="fa fa-eye"></i> </button>'
                    }
                },
            ]
        });

        $.ajax({
            url: "{{ url('/admin/nasabah/json')}}",
            type: "GET",
            cache: false,
            dataType: 'json',
            success: function(dataResult) {
                console.log(dataResult);
                var resultData = dataResult.data;
                $.each(resultData, function(index, row) {
                    $('#id_user').append('<option value="' + row.id + '">' + row.name + ' - ' + row.email + '</option>');
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
    
    $("body").on("click",".btn-simpan",function(){
        var nasabah = $('#id_user').val();
        if(nasabah != 0){
            Swal.fire(
                'Data Disimpan!',
                '',
                'success'
                )
        }else{
            alert('Nasabah Tidak Boleh Kosong !');
        }
    });
    $("body").on("click",".btn-eye",function(){
        var id = jQuery(this).attr("data-id");
        window.location.href = "{{url($page)}}/detail/"+id;
    })

    $("body").on("click",".btn-validasi",function(){
        var id = jQuery(this).attr("data-id");
                    
        jQuery("#validasi-form").attr("action",'<?=url($page);?>/validasi/'+id);
        $.ajax({
            url: "<?=url($page);?>/find/"+id,
            type: "GET",
            cache: false,
            dataType: 'json',
            success: function (dataResult) { 
                console.log(dataResult);
                var resultData = dataResult.data;
                $.each(resultData,function(index,row){
                    if(row.status === 'Disetujui')
                    {
                        jQuery("#validasi-form input[name=status]").val('Lunas');
                        event.preventDefault()
                        Swal.fire({
                            title: 'Pinjaman Lunas ?',
                            text: "Data pinjaman yang sudah dirubah tidak dapat dikembalikan !",
                            type: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes',
                            cancelButtonText: 'Tidak'
                        }).then((result) => {
                            if (result.value) {
                                Swal.fire(
                                    'Data Diupdate!',
                                    '',
                                    'success'
                                );
                                document.getElementById('validasi-form').submit();
                            }
                        });
                    }else{
                        jQuery("#validasi-form input[name=status]").val('Disetujui');
                        event.preventDefault()
                        Swal.fire({
                            title: 'Setujui Pinjaman ?',
                            text: "Data yang sudah dirubah tidak dapat dikembalikan !",
                            type: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes',
                            cancelButtonText: 'Tidak'
                        }).then((result) => {
                            if (result.value) {
                                Swal.fire(
                                    'Data Diupdate!',
                                    '',
                                    'success'
                                );
                                document.getElementById('validasi-form').submit();
                            }
                        });
                    }
                })
            }
        });
        
    });
    
    function kosongkan()
    {
        jQuery("#compose-form select[name=id_user]").val('0');
        jQuery("#compose-form input[name=tanggal]").val();
        jQuery("#compose-form input[name=jumlah]").val();
        jQuery("#compose-form input[name=keterangan]").val();
    }
</script>
@endSection