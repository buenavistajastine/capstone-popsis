<script>
    document.addEventListener("DOMContentLoaded", () => {
        Livewire.hook('message.processed', (component) => {
            setTimeout(function() {
                $('#alert').fadeOut('fast');
            }, 5000);
        });
    });

    window.livewire.on('closeFoodOrderModal', () => {
        $('#foodOrderModal').modal('hide');
    });

    window.livewire.on('openFoodOrderModal', () => {
        $('#foodOrderModal').modal('show');
    });
</script>