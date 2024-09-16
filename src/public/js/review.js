'use strict';
{
    document.addEventListener('DOMContentLoaded', function () {
        const stars = document.querySelectorAll('.star');
        let currentRating = parseInt(document.getElementById('rank').value);

        updateStars(currentRating);

        stars.forEach(star => {
            star.addEventListener('click', function () {
                const rating = parseInt(this.getAttribute('data-value'));
                if (rating === currentRating) {
                    currentRating = 0;
                } else {
                    currentRating = rating;
                }
                updateStars(currentRating);
                document.getElementById('rank').value = currentRating;
            });
        });

        function updateStars(rating) {
            stars.forEach(s => {
                if (parseInt(s.getAttribute('data-value')) <= rating) {
                    s.classList.add('star-blue');
                } else {
                    s.classList.remove('star-blue');
                }
            });
        }
    });

    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var output = document.getElementById('imagePreview');
            output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }
    document.getElementById('image').addEventListener('change', previewImage);
}
