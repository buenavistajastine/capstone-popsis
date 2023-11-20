<script>
    document.addEventListener("DOMContentLoaded", () => {
        Livewire.hook('message.processed', (component) => {
            setTimeout(function() {
                $('#alert').fadeOut('fast');
            }, 5000);
        });
    });

    window.livewire.on('closeRoleModal', () => {
        $('#roleModal').modal('hide');
    });

    window.livewire.on('openRoleModal', () => {
        $('#roleModal').modal('show');
    });
</script>