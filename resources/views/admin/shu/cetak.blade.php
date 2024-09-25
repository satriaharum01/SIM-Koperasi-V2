<?php
error_reporting(0);
if(!empty($_GET['download'] == 'doc')) {
    header("Content-Type: application/vnd.ms-word");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("content-disposition: attachment;filename=" . date('d-m-Y') . "_laporan_rekam_medis.doc");
}
if(!empty($_GET['download'] == 'xls')) {
    header("Content-Type: application/force-download");
    header("Cache-Control: no-cache, must-revalidate");
    header("Expires: 0");
    header("content-disposition: attachment;filename=" . date('d-m-Y') . "_laporan_rekam_medis.xls");
}
?>
<?php
$tgla = $start;
$tglk = $end;
$bulan = array(
    '01' => 'Januari',
    '02' => 'Februari',
    '03' => 'Maret',
    '04' => 'April',
    '05' => 'Mei',
    '06' => 'Juni',
    '07' => 'Juli',
    '08' => 'Agustus',
    '09' => 'September',
    '10' => 'Oktober',
    '11' => 'November',
    '12' => 'Desember',
);

$array1 = explode("-", $tgla);
$tahun = $array1[0];
$bulan1 = $array1[1];
$hari = $array1[2];
$bl1 = $bulan[$bulan1];
$tgl1 =  $bl1 . ' ' . $tahun;


$array2 = explode("-", $tglk);
$tahun2 = $array2[0];
$bulan2 = $array2[1];
$hari2 = $array2[2];
$bl2 = $bulan[$bulan2];
$tgl2 =  $bl2 . ' ' . $tahun2;
$no = 1;
?>

<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" href="{{asset('bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
        <link rel="stylesheet" href="{{asset('bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
		<link rel="stylesheet" href="{{asset('bower_components/font-awesome/css/font-awesome.min.css')}}">
		<title><?= $title;?></title>
		<style>
            .table-new{
                margin-left: auto;
                margin-right: auto;
                margin-top:2rem;
                margin-bottom:2rem;
            }

			body {
				background: rgba(0,0,0,0.2);
			}
			page[size="A4"] {
				background: white;
				height: auto;
				width: 29.7cm;
				display: block;
				margin: 0 auto;
				margin-bottom: 0.5pc;
				box-shadow: 0 0 0.5cm rgba(0,0,0,0.5);
				padding-left:2.54cm;
				padding-right:2.54cm;
				padding-top:1.54cm;
				padding-bottom:1.54cm;
			}
			@media print {
				body, page[size="A4"] {
					margin: 0;
					box-shadow: 0;
				}
			}
		</style>
	</head>
	<body>
        <div class="container">
            <br/> 
            <div class="pull-left">
                Cetak {{$title}} - Preview HTML to DOC [ size paper A4 ]
            </div>
            <div class="pull-right"> 
            <button type="button" class="btn btn-success btn-md" onclick="printDiv('printableArea')">
                <i class="fa fa-print"> </i> Print File
            </button>
            </div>
        </div>
        <br/>
        <div id="printableArea">
            <page size="A4">
				<div class="">
					<div class="panel-body">
						<h4 class="text-center">
                            {{strtoupper(env('APP_NAME'))}} <br>
                            SISA HASIL USAHA</h4>
						<br/>
                        <label>Periode {{$tgl1}} S/d {{$tgl2}}</label><br>
                        <label>Data Koperasi</label>
                        <div class="row">
                            <table class="table table-bordered table-striped table" width="100%">
                                <tbody>
                                    <tr>
                                        <th class="text-center">Keterangan</td>
                                        <th class="text-center"><b>Jumlah</b></td>
                                    </tr>
                                    <tr>
                                        <td>Pendapatan Koperasi</td>
                                        <td class="text-right"><b> {{number_format($load->pendapatan)}}</b></td>
                                    </tr>
                                    <tr>
                                        <td>Pinjaman Anggota Koperasi </td>
                                        <td class="text-right"><b> {{number_format($load->pinjaman)}}</b></td>
                                    </tr>
                                    <tr>
                                        <td>Simpanan Anggota Koperasi </td>
                                        <td class="text-right"><b> {{number_format($load->simpanan)}}</b></td>
                                    </tr>
                                    <tr>
                                        <td>Biaya Koperasi </td>
                                        <td class="text-right"><b> {{number_format($load->biaya)}}</b></td>
                                    </tr>
                                    <tr>
                                        <td>Sisa Hasil Usaha </td>
                                        <td class="text-right"><b> {{number_format($load->shu)}}</b></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <label>Rincian SHU </label>
						<div class="row">
						<div class="table-responsive">
                            <table class="table table-bordered table-striped table" width="100%">
                                <thead >
                                    <tr>
                                        <th width="10%" class="text-center">No</th>
                                        <th width="60%" colspan="2" class="text-center">Keterangan</th>
                                        <th class="text-center">Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    <tr>
                                        <td>1</td>
                                        <td class="text-left">Jasa Anggota</td>
                                        <td class="text-center">{{$load->a}}</td>
                                        <td class="text-right"><b> {{number_format($load->jasa_anggota)}}</b></td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td class="text-left">Jasa Modal </td>
                                        <td class="text-center">{{$load->b}}</td>
                                        <td class="text-right"><b> {{number_format($load->jasa_modal)}}</b></td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td class="text-left">Jasa Pengurus </td>
                                        <td class="text-center">{{$load->c}}</td>
                                        <td class="text-right"><b> {{number_format($load->pengurus)}}</b></td>
                                    </tr>
                                    <tr>
                                        <td>4</td>
                                        <td class="text-left">Cadangan Modal Anggota </td>
                                        <td class="text-center">{{$load->d}}</td>
                                        <td class="text-right"><b> {{number_format($load->modal)}}</b></td>
                                    </tr>
                                </tbody>
                            </table>
			            </div>
						</div>
                        
                        <label>Pembagian SHU Anggota</label>
						<div class="row">
						<div class="table-responsive">
                            <table class="table table-bordered table-striped table" width="100%">
                                <thead>
                                <tr>
                                    <th width="8%" style="text-align:center; vertical-align: middle;">No</th>
                                    <th width="35%" style="text-align:center; vertical-align: middle;">Nama Anggota</th>
                                    <th style="text-align:center; vertical-align: middle;">SHU Jasa Anggota</th>
                                    <th style="text-align:center; vertical-align: middle;">SHU Jasa Modal</th>
                                    <th style="text-align:center; vertical-align: middle;">SHU Cadangan <br>Modal Anggota</th>
                                </tr>
                                </thead>
                                <tbody class="text-center">
                                @foreach($anggota as $row)
                                <tr>
                                    <td>{{$no++}}</td>
                                    <td>{{$row->name}}</td>
                                    <td>{{number_format($row->jasa_anggota,2)}}</td>
                                    <td>{{number_format($row->jasa_modal,2)}}</td>
                                    <td>{{number_format($row->modal,2)}}</td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
			            </div>
						</div>
					</div>
				</div>
            </page>
        </div>
  </body>
    <!-- jQuery 3 -->
    <script src="{{asset('bower_components/jquery/dist/jquery.min.js')}}"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="{{asset('bower_components/bootstrap/dist/js/bootstrap.js')}}"></script>
    <!-- DataTables -->
    <script src="{{asset('bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>

  <script>
    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }
  </script>
</html>