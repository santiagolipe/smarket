<!-- Scripts -->
<script src="{{ asset('js/bootstrap.js') }}"></script> <!-- jQuery and bootstrap included -->
<script>
    (function($) {
        $(function() {
            $('body').removeClass('is-loading');
        });
    })(jQuery);
</script>
@yield('scripts')
