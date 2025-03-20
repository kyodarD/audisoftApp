$(document).ready(function() {
    $('.delete-form').submit(function(e) {
        e.preventDefault();
        Swal.fire({
            title: '¿Estás seguro?',
            text: 'Este registro se eliminará definitivamente',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Aceptar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                this.submit();
            }
        });
    });
});