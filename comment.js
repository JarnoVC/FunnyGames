var post = document.querySelectorAll("#commentquery");

post.forEach((myfunction) => {
    myfunction.querySelector("#btn_add_comment").addEventListener('click', function (event) {
        event.preventDefault();

        var post_id = this.dataset.post_id;
        var comment = myfunction.querySelector("#comment_text").value;

        //naar database
        var formData = new FormData();

        formData.append('comment', comment);
        formData.append('post_id', post_id);

        fetch('ajax/savecomment.php', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(result => {
                var newComment = document.createElement('li');
                newComment.innerHTML = result.body;
                myfunction.querySelector(".list_comments").appendChild(newComment);
                
            })
            .catch(error => {
                console.error('Error:', error);
            });

    })

})
