$(document).ready(function() {
    $('[data-toggle="tooltip"]').tooltip();
    $('[disabled="disabled"]').hover(
        function() {
            $(this).toolstip('show');
        },
        function() {
            $(this).tooltip('hide');
        }
    );
});