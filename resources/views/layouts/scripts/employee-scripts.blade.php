<script>
    document.addEventListener("DOMContentLoaded", () => {
        Livewire.hook('message.processed', (component) => {
            setTimeout(function() {
                $('#alert').fadeOut('fast');
            }, 5000);
        });
    });

    window.livewire.on('closeEmployeeModal', () => {
        $('#employeeModal').modal('hide');
    });

    window.livewire.on('openEmployeeModal', () => {
        $('#employeeModal').modal('show');
    });


    window.livewire.on('destroyDataTable', () => {
        $('#dataTableExample').DataTable().destroy();
    });

    window.livewire.on('reinitializeDataTable', () => {
    $('#dataTableExample').DataTable({
        // your DataTable configuration
    });
    });

</script>
