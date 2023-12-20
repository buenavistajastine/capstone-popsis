<script>
    document.addEventListener('livewire:after', function () {
        // Initialize Perfect Scrollbar after Livewire component is rendered
        if ($('.perfect-scrollbar-example').length) {
            var scrollbarExample = new PerfectScrollbar('.perfect-scrollbar-example');
        }
    });
</script>