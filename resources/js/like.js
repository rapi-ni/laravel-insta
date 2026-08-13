
console.log('LIKE.JS LOADED');

document.addEventListener('DOMContentLoaded', function () {

    //  Comment / Reply Like 
    const commentLikeForms =
       document.querySelectorAll('.comment-like-form');
       
    console.log('COMMENT LIKE FORMS:', commentLikeForms.length);
    
    commentLikeForms.forEach(function(form){

        form.addEventListener('submit', function(event){
            event.preventDefault();

            // const button = form.querySelector('button');

            // if (button.disabled) {
            //     return;
            // }

            // button.disabled = true;

            const commentId = form.dataset.commentId;
            const heart = form.querySelector('.comment-heart');

            const isLiked = heart.dataset.liked === 'true';

            console.log('COMMENT LIKE - IS LIKED:', isLiked);
            console.log('COMMENT LIKE - DATA LIKED:', heart.dataset.liked);
            console.log('COMMENT LIKE - STORE URL:', form.dataset.likeStoreUrl);
            console.log('COMMENT LIKE - DESTROY URL:', form.dataset.likeDestroyUrl);

            const url = isLiked
               ? form.dataset.likeDestroyUrl
               : form.dataset.likeStoreUrl;

            const method = isLiked ? 'DELETE' : 'POST';

            console.log('COMMENT LIKE - URL:', url);
            console.log('COMMENT LIKE - METHOD:', method);

            fetch(url, {
                method: method,
                headers: {
                    'X-CSRF-TOKEN': document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute('content'),
                    'Accept': 'application/json'
                }    
            })
            .then(response => {
                if (!response.ok){
                    throw new Error('Like request failed');
                }

                return response.json();
            })
            .then(data => {
                const countElement = 
                    document.getElementById(
                        'comment-like-count-' + commentId
                    );

                let count = parseInt(countElement.textContent);

                if(isLiked){
                    // remove
                    count--;

                    heart.classList.remove(
                        'fa-solid',
                        'text-danger'
                    );

                    heart.classList.add('fa-regular');
                    heart.dataset.liked = 'false';
                } else {
                    // change red
                    count++;

                    heart.classList.remove('fa-regular');

                    heart.classList.add('fa-solid', 'text-danger');
                    heart.dataset.liked = 'true';
                }

                countElement.textContent = count;
            })
            .catch(error => {
                console.error('Coment Like Error', error);
            })
            // .finally(() => {
            //     // click again if finish
            //     button.disabled = false;
            // });
        });
    });

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
                    throw new Error('mistake the like');
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