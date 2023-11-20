<script>
    document.addEventListener("DOMContentLoaded", () => {
        Livewire.hook('message.processed', (component) => {
            setTimeout(function() {
                $('#alert').fadeOut('fast');
            }, 5000);
        });
    });

    window.livewire.on('closeDishModal', () => {
        $('#dishModal').modal('hide');
    });

    window.livewire.on('openDishModal', () => {
        $('#dishModal').modal('show');
    });
</script>