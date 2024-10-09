$(document).ready(function() {
    $('.comment-section').submit(function(e) {
        e.preventDefault(); // Prevent the default form submission

        var form = $(this); // Get the current form
        var formData = {
            comment: form.find('.comment-input').val(),
            topic_id: form.data('topic-id') // Get the topic ID from data attribute
        };

        $.ajax({
            url: 'post_comment.php',
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