
console.log('LIKE.JS LOADED');

document.addEventListener('DOMContentLoaded', function () {

    const forms = document.querySelectorAll('.like-form');

    console.log('LIKE FORMS:', forms.length);

    forms.forEach(function (form) {

        form.addEventListener('submit', function (event) {
            event.preventDefault();

            const heart = form.querySelector('.fa-heart');
            const postId = form.dataset.postId;
            const likeCount = document.querySelector('#like-count-' + postId);

            const storeUrl = form.dataset.likeStoreUrl;
            const destroyUrl = form.dataset.likeDestroyUrl;

            let url;
            let method;

            // Remove the like
            if (heart.dataset.liked === 'true') {

                console.log('Remove the like');
                console.log('post id:', postId);

                url = destroyUrl;
                method = 'DELETE';

            // Give it a like
            } else {

                console.log('Give it a like');
                console.log('post id:', postId);

                url = storeUrl;
                method = 'POST';
            }

            fetch(url, {
                method: method,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector(
                        'meta[name="csrf-token"]'
                    ).content,
                    'Accept': 'application/json'
                }
            })
            .then(response => {

                console.log('Status:', response.status);

                if (!response.ok) {
                    throw new Error('Like処理に失敗しました');
                }

                return response.json();
            })
            .then(data => {

                console.log(data.message);

                if (method === 'DELETE') {

                    // Put it back
                    heart.classList.remove('fa-solid');
                    heart.classList.add('fa-regular');
                    heart.classList.remove('text-danger');
                    heart.dataset.liked = 'false';

                    // Decrease the like count by 1
                    likeCount.textContent =
                        Number(likeCount.textContent) - 1;

                } else {

                    // Turn the heart red
                    heart.classList.remove('fa-regular');
                    heart.classList.add('fa-solid');
                    heart.classList.add('text-danger');
                    heart.dataset.liked = 'true';

                    // Increase the like count by 1
                    likeCount.textContent =
                        Number(likeCount.textContent) + 1;
                }
            })
            .catch(error => {
                console.error(error);
            });
        });
    });
});