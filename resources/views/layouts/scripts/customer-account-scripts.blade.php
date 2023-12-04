<script>
    document.addEventListener("DOMContentLoaded", () => {
        Livewire.hook('message.processed', (component) => {
            setTimeout(function() {
                $('#alert').fadeOut('fast');
            }, 5000);
        });
    });

    window.livewire.on('closeCustomerAccountEditModal', () => {
        $('#customerAccountEditModal').modal('hide');
    });

    window.livewire.on('openCustomerAccountEditModal', () => {
        $('#customerAccountEditModal').modal('show');
    });
</script>
