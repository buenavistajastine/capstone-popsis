<script>
    document.addEventListener("DOMContentLoaded", () => {
        Livewire.hook('message.processed', (component) => {
            setTimeout(function() {
                $('#alert').fadeOut('fast');
            }, 5000);
        });
    });

    window.livewire.on('closePackageModal', () => {
        $('#packageModal').modal('hide');
    });

    window.livewire.on('openPackageModal', () => {
        $('#packageModal').modal('show');
    });
</script>