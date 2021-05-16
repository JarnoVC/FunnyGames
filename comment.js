var post = document.querySelectorAll("#post");

post.forEach((e) => {
    e.querySelector("#btn_add_comment").addEventListener('click', function (event) {
        //event.preventDefault();

        var post_id = this.dataset.post_id;
        //var date = this.dataset.date;
        var comment = e.querySelector("#comment_text").value;


        //naar database
        var formData = new FormData();

        formData.append('comment', comment);
        formData.append('post_id', post_id);
        //formData.append('date', date);
        fetch('ajax/savecomment.php', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(result => {
                var newComment = document.createElement('li');
                newComment.innerHTML = result.body;
                document
                    .querySelector(".list_comments")
                    .appendChild(newComment);
            })
            .catch(error => {
                console.error('Error:', error);
            });
    })
})

/*

var post = document.querySelectorAll(".post");
var commentBtns = document.getElementById('btn_add_comment');
var bntlength = commentBtns.lenght;

for (i = 0; i < bntlength; i++) {
    post.forEach((i) => {
        i.querySelector("#btn_add_comment").addEventListener('click', function (event) {
            event.preventDefault();

            var post_id = this.dataset.post_id;
            //var date = this.dataset.date;
            var comment = document.querySelector("#comment_text").value;


            //naar database
            var formData = new FormData();

            formData.append('comment', comment);
            formData.append('post_id', post_id);
            //formData.append('date', date);
            fetch('ajax/savecomment.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(result => {
                    var newComment = document.createElement('li');
                    newComment.innerHTML = result.body;
                    document
                        .querySelector(".list_comments")
                        .appendChild(newComment);
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        })
    })

}


*/

/*  ALTER TABLE comments AUTO_INCREMENT = 1*/