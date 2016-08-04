$(document).ready(function() {
    $('[data-toggle="tooltip"]').tooltip();
    $('#submitVote').hover(
        function() {
            alert('Hi');
            $(this).tooltip('show');
        },
        function() {
            $(this).tooltip('hide');
        }
    );
});