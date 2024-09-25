@extends('template.onepage')

@section('css')
<style type="text/css">
    #direction_details,
    #directions_panel {
        font-size: 12px;
    }
</style>
@endSection()

@section('content')
 <!-- start home -->
 <section id="feature1">
	<div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow mb-4">
                    <div class="card-header">
                        <h3 class="card-title">Data <?= ucfirst($title) ?></h3>
                    </div>
                    <div class="card-body">
                        <p>Berikut adalah informasi mengenai profil anda. Untuk memperbarui profil anda silahkan ubah kemudian tekan simpan</a></p>
                        <form action="<?=url($page);?>/update/{{$load->id}}" method="post" id="compose-form" class="row">
                            @csrf
                            <div class="modal-body col-lg-6"> 
                                <div class="form-group">
                                    <label>Status</label>
                                    <input type="text"  value="{{$load->status}}" name="status" class="form-control" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Nama Nasabah</label>
                                    <input type="text" name="nama" value="{{$load->name}}" class="form-control" placeholder="Contoh: M Hutagalung" required>
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" name="email" value="{{$load->email}}" class="form-control" placeholder="Contoh: MHutagalung@gmail.com" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="password" name="password" placeholder="Kosongkan Jika tidak diubah" class="form-control">
                                </div>
                            </div>
                            <div class="modal-body col-lg-6"> 
                                <div class="form-group">
                                    <label>Telepon</label>
                                    <input type="number" name="no_hp" value="0{{$load->no_hp}}" class="form-control" placeholder="Contoh: 085228122928">
                                </div>
                                <div class="form-group">
                                    <label>Alamat</label>
                                    <textarea  name="alamat" class="form-control" value="" placeholder="Contoh: Jl. Asia Megamas No.5" rows="2">{{$load->alamat}}</textarea>
                                </div>
                                <div class="form-group">
                                    <label>Akses Level</label>
                                    <select name="level" class="form-control" readonly>
                                        <option value="Aktif" selected>{{$load->level}}</option>
                                    </select>
                                </div>
                                <button type="reset" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary btn-simpan">Update</button>   
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
	</div>
</section>
<!-- end home -->
@endsection