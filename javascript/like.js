// like.js
function handleLike(topicId, button) {
    $.ajax({
        url: 'like.php',
        type: 'POST',
        data: { topic_id: topicId },
        dataType: 'json',
        success: function(response) {
            // Update the like count
            $(button).find('.like-count').text(response.like_count);

            // Toggle the heart icon
            var svgPath = $(button).find('svg path');
            if (response.user_has_liked) {
                svgPath.attr('fill', 'red').removeAttr('stroke');
            } else {
                svgPath.attr('stroke', 'black').attr('stroke-width', '2').removeAttr('fill');
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error:', status, error);
        }
    });
}

function copy(element){
    const href = element.closest('.post').querySelector('a.copy').href;
    navigator.clipboard.writeText(href).then(
      ()=>toastr.success("คัดลอกลิงค์เรียบร้อย", "แชร์"),
      toastr.options = {
        "positionClass": "toast-bottom-right",
        "timeOut": "1000"},
      (err)=>console.log("err")
    );
    }