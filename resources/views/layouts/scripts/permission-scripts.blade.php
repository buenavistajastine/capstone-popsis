<script>
    document.addEventListener("DOMContentLoaded", () => {
        Livewire.hook('message.processed', (component) => {
            setTimeout(function() {
                $('#alert').fadeOut('fast');
            }, 5000);
        });
    });

    window.livewire.on('refreshTable', () => {
            dataTable.ajax.reload();
        });

    window.livewire.on('closePermissionModal', () => {
        $('#permissionModal').modal('hide');
    });

    window.livewire.on('openPermissionModal', () => {
        $('#permissionModal').modal('show');
    });
</script>
