$(document).ready(function() {
    $('[data-toggle="tooltip"]').tooltip();
    $('[disabled="disabled"]').hover(
        function() {
            alert('Hi');
            $(this).tooltip('show');
        },
        function() {
            $(this).tooltip('hide');
        }
    );
});