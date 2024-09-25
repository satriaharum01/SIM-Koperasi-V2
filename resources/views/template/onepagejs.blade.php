<script src="{{ asset('nasabah/js/jquery.js')}}"></script>
<script src="{{ asset('nasabah/js/bootstrap.min.js')}}"></script>
<script src="{{ asset('nasabah/js/wow.min.js')}}"></script>
<script src="{{asset('assets/vendor/chart.js/Chart.min.js')}}"></script>
<script src="{{ asset('nasabah/js/custom.js')}}"></script>
<!-- Page level plugins -->
<script src="{{asset('assets/js/dashboard-chart-area.js')}}"></script>
<script src="{{ asset('assets/vendor/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
<script>
    $(function () {
        $(".alert").fadeOut(3000);
    });
    $("body").on("click", ".btn-hapus", function() {
        var x = jQuery(this).attr("data-id");
        var y = jQuery(this).attr("data-handler");
        var xy = x + '-' + y;
        event.preventDefault()
        Swal.fire({
            title: 'Hapus Data ?',
            text: "Data yang dihapus tidak dapat dikembalikan !",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if (result.value) {
                Swal.fire(
                    'Data Dihapus!',
                    '',
                    'success'
                );
                document.getElementById('delete-form-' + xy).submit();
            }
        });
    })
</script>