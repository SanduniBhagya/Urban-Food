$(document).ready(function () {
    loadReviews();

    // Rating UI
    $('.rating-input i').click(function () {
        let rating = $(this).data('rating');
        $('#rating').val(rating);
        $('.rating-input i').removeClass('fas').addClass('far');
        $('.rating-input i').each(function () {
            if ($(this).data('rating') <= rating) {
                $(this).removeClass('far').addClass('fas');
            }
        });
    });

    // Submit Review
    $('#submitReview').click(function () {
        const rating = $('#rating').val();
        const review = $('textarea[name="review"]').val();

        if (!rating || !review) {
            alert('Please provide both rating and review.');
            return;
        }

        $.post('php/submit_review.php', { rating, review })
            .done(function () {
                $('#writeReviewModal').modal('hide');
                $('#reviewForm')[0].reset();
                $('#rating').val('');
                $('.rating-input i').removeClass('fas').addClass('far');
                loadReviews();
            })
            .fail(function (xhr) {
                console.error('AJAX error:', xhr);
                alert(xhr.responseJSON?.error || 'Failed to submit review.');
            });
    });
});

function loadReviews() {
    $.getJSON('php/load_reviews.php', function (data) {
        const container = $('#reviews-list');
        container.empty();

        if (data.length === 0) {
            container.append("<p class='text-muted'>No reviews yet.</p>");
            return;
        }

        data.forEach(function (review) {
            const stars = '<i class="fas fa-star text-warning"></i>'.repeat(review.rating) +
                          '<i class="far fa-star text-warning"></i>'.repeat(5 - review.rating);

            const html = `
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <strong>${review.username}</strong>
                            <div>${stars}</div>
                        </div>
                        <p class="mt-2">${review.review}</p>
                        <small class="text-muted">${review.created_at}</small>
                    </div>
                </div>
            `;
            container.append(html);
        });
    });
}
