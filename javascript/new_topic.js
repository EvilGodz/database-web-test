$(document).ready(function() {
    $('.comment-section').submit(function(e) {
        e.preventDefault(); // Prevent the default form submission

        var form = $(this); // Get the current form
        var formData = {
            post: form.find('.comment-input').val(),
            body: form.data('topic-id') // Get the topic ID from data attribute
        };

        $.ajax({
            url: 'new_topic.php',
            type: 'POST',
            data: formData,
            success: function(response) {
                location.reload(); // Reload the page to see the new comment
            },
            error: function(xhr, status, error) {
                console.error('Error posting comment:', error);
            }
        });
    });
});