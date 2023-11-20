<script>
    document.addEventListener("DOMContentLoaded", () => {
        Livewire.hook('message.processed', (component) => {
            setTimeout(function() {
                $('#alert').fadeOut('fast');
            }, 5000);
        });
    });

    window.livewire.on('closePositionModal', () => {
        $('#positionModal').modal('hide');
    });

    window.livewire.on('openPositionModal', () => {
        $('#positionModal').modal('show');
    });
</script>