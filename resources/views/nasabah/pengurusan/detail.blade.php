@extends('template.layout')
@section('content')
<div class="card shadow mb-4">
    <div class="card-header"><strong>{{$title}}</strong></div>
    <div class="card-body">
        <div class="example">
            <form action="{{$link}}" method="post" id="compose-form" class="row" enctype="multipart/form-data">
                @csrf
                <div class="modal-body col-md-6">
                    <div class="form-group">
                        <label>Tanggal</label>
                        <input type="date" name="tanggal" class="form-control" value="{{$load->tanggal ?? ''}}">
                    </div>
                    <div class="form-group">
                        <label>Keperluan</label>
                        <input type="text" name="keperluan" class="form-control" value="{{$load->keperluan ?? ''}}" >
                    </div>
                    <div class="form-group">
                        <label>Keterangan</label>
                        <textarea name="keterangan" rows="2" class="form-control">{{$load->keterangan ?? ''}}</textarea>
                    </div>
                </div>
                <div class="modal-body col-md-6">
                    <div class="form-group">
                        <label>Tujuan Berkas</label>
                        <select name="id_pimpinan" class="form-control" id="pimpinan" style="width:100%;">
                            <option value="0" selected disabled>-- Pilih Pimpinan --</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>File Berkas </label>
                        <label class="text-success">{{$load->berkas ?? ''}}</label>
                        <input type="file" name="berkas" class="form-control" accept="application/pdf">
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="{{route('pegawai.pengurusan')}}" class="btn btn-danger">Kembali</a>
                    <button type="button" class="btn btn-primary btn-simpan">Simpan</button>
                </div>
            </form>
        </div>
</div>
@endsection
@section('js')
<script>
    $(function() {
        var pmp = '{{$load->id_pimpinan ?? 0}}';
        $.ajax({
            url: "{{ url('/get/pimpinan/json/')}}",
            type: "GET",
            cache: false,
            dataType: 'json',
            success: function(dataResult) {
                console.log(dataResult);
                var resultData = dataResult.data;
                var slct = '';
                $.each(resultData, function(index, row) {
                    if(pmp == row.id)
                    {
                        slct = 'selected';
                    }else{
                        slct = '';
                    }
                    $('#pimpinan').append('<option value="' + row.id + '" '+ slct+'>' + row.name + ' - ' +row.jabatan+ '</option>');
                })
            }
        });
        
    })

    $("body").on("click", ".btn-simpan", function() {
        var tanggal = jQuery("#compose-form input[name=tanggal]").val();
        var keperluan = jQuery("#compose-form input[name=keperluan]").val();
        var keterangan = jQuery("#compose-form textarea[name=keterangan]").val();
        var pmp = jQuery("#compose-form select[name=id_pimpinan]").val();
        if (keperluan === "" || tanggal === "" || keterangan === "" || pmp === "0") {
            alert("Data Tidak Boleh Kosong");
            return false;
        } else {
            Swal.fire(
                'Data Disimpan!',
                '',
                'success'
            );
            document.getElementById('compose-form').submit();
        }
    });
</script>
@endsection