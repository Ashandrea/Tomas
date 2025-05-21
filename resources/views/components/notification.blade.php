@if (session()->has('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                icon: 'success',
                position: 'top',
                showConfirmButton: false,
                timer: 10000,
                timerProgressBar: true,
                toast: true
            });
        });
    </script>
@endif

@if (session()->has('error'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: 'Gagal!',
                text: "{{ session('error') }}",
                icon: 'error',
                position: 'top',
                showConfirmButton: false,
                timer: 10000,
                timerProgressBar: true,
                toast: true
            });
        });
    </script>
@endif 