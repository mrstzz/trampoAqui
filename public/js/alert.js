// alert index
document.addEventListener('DOMContentLoaded', () => {
            if (typeof flashMessage !== 'undefined') {
                Swal.fire({
                    toast: true,
                    position: 'top-end', // Canto superior direito
                    showConfirmButton: false,
                    timer: 5000, // Duração em milissegundos
                    timerProgressBar: true,
                    icon: flashMessage.type === 'error' ? 'error' : 'success', 
                    
                    title: flashMessage.message,
                    showClass: {
                        popup: 'swal2-show',
                        backdrop: 'swal2-backdrop-show',
                        icon: 'swal2-icon-show'
                    },
                    hideClass: {
                        popup: 'swal2-hide',
                        backdrop: 'swal2-backdrop-hide',
                        icon: 'swal2-icon-hide'
                    }
                });
            }
        });