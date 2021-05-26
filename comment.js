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
                var date = document.createElement('div');
                date.style = 'color:#5671A2;  margin-bottom: 1.5vw;'
                newComment.innerHTML = result.body;
                date.innerHTML = " just now";
                myfunction.querySelector(".list_comments").appendChild(newComment);
                newComment.appendChild(date);
                myfunction.querySelector("#comment_text").value = "";

            })
            .catch(error => {
                console.error('Error:', error);
            });

    })
    myfunction.querySelector("#comment_text").addEventListener("keyup", function (event) {
        if (event.keyCode === 13) {
            event.preventDefault();
            myfunction.querySelector("#btn_add_comment").click();
        }
    });

})
