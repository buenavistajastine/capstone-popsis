<script>
    document.addEventListener("livewire.navigated", () => {
        Livewire.hook('message.processed', (component) => {
            setTimeout(function() {
                $('#alert').fadeOut('fast');
            }, 5000);
        });
        initFlowbite();
    });

    window.livewire.on('closeBookingModal', () => {
        $('#bookingModal').modal('hide');
    });

    window.livewire.on('openBookingModal', () => {
        $('#bookingModal').modal('show');
    });

    window.livewire.on('closeBookingRecordModal', () => {
        $('#bookingRecordModal').modal('hide');
    });

    window.livewire.on('openBookingRecordModal', () => {
        $('#bookingRecordModal').modal('show');
    });

    window.livewire.on('closeQRModal', () => {
        $('#qrModal').modal('hide');
    });

    window.livewire.on('openQRModal', () => {
        $('#qrModal').modal('show');
    });
</script>