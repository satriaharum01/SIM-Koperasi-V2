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
        <h6 class="m-0 font-weight-bold text-primary" style="padding: 12px 6px;">{{$title}}</h6>
    </div>
    <div class="card-body">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3>Cetak SHU Periode</h3> 
                    <button class="btn btn-danger btn-print">
                  <i class="fa fa-print"> </i> Print</button>
                <div class="pull-left">
                <label for="">Periode : </label>
                <input style="margin: 5px;" type="month" id="awal" value="<?php echo date('Y-m'); ?>" onchange="change_tgl()">
                <label for="">S/d </label>
                <input style="margin: 5px;" type="month" id="akhir" value="<?php echo date('Y-m'); ?>" onchange="change_tgl()">
            </div>
        </div>
		<!-- /.box-header -->
    </div>
</div>
<!-- /.container-fluid -->
@endSection()
@section('js')
<script>
   
    //Button Print 
    $("body").on("click",".btn-print",function(){
        var awal = $("#awal").val();
        var akhir = $("#akhir").val();
        window.location.href = '<?=url($page);?>/cetak/'+awal+'/'+akhir;
        return false
    });
</script>
@endSection