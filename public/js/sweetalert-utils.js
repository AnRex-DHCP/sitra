const SweetAlertUtils = {
    showDeleteConfirmation: function(itemId = null) {
        return Swal.fire({
            html: `<div class="mt-3">
                    <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json"
                        trigger="loop"
                        colors="primary:#405189,secondary:#f06548"
                        style="width:90px;height:90px">
                    </lord-icon>
                    <h4 class="fs-semibold mt-3">${itemId ? '¿Estas a punto de eliminar un registro?' : '¿Estas a punto de eliminar registros del sistema?'}</h4>
                    <p class="text-muted fs-14 mb-4 pt-1">Al eliminar ${itemId ? 'el registro' : 'los registros'} se eliminará la información de nuestra base de datos.</p>
                </div>`,
            icon: "custom",
            buttonsStyling: false,
            showCancelButton: true,
            confirmButtonText: `<i class="ri-delete-bin-fill"></i> Si, eliminar${itemId ? 'lo' : 'los'}!`,
            cancelButtonText: '<i class="ri-close-line me-1 align-middle"></i> No, cancelar',
            customClass: {
                icon: 'border-0',
                cancelButton: "btn btn-link link-success fw-medium text-decoration-none material-shadow-none",
                confirmButton: "btn btn-danger",
            }
        });
    },

    showDeleteSuccess: function(isMultiple = false) {
        return Swal.fire({
            html: `<div class="mt-3">
                    <lord-icon src="https://cdn.lordicon.com/tqywkdcz.json"
                           trigger="loop"
                           colors="primary:#0ab39c,secondary:#405189"
                           style="width:90px;height:90px">
                    </lord-icon>
                    <h4 class="fs-semibold mt-3">${isMultiple ? 'Los registros' : 'El registro'} ha${isMultiple ? 'n' : ''} sido eliminado${isMultiple ? 's' : ''}!</h4>
                    <p class="text-muted fs-14 mb-4 pt-1">Se ha eliminado la información de la base de datos.</p>
                </div>`,
            icon: "custom",
            confirmButtonText: '<i class="ri-check-line me-1"></i> Aceptar',
            buttonsStyling: false,
            customClass: {
                confirmButton: "btn btn-success",
                popup: 'sweet-alerts'
            }
        });
    }
};
