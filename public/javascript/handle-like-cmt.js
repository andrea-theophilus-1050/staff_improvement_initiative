// Handle like and dislike and comments functionality
document.addEventListener("DOMContentLoaded", function () {
    var likeForms = document.querySelectorAll('form[id^="like-form-"]');
    var dislikeForms = document.querySelectorAll('form[id^="dislike-form-"]');
    var commentForms = document.querySelectorAll('form[id^="comment-form-"]');
    var i;

    // Add event listener for each like form
    for (i = 0; i < likeForms.length; i++) {
        likeForms[i].addEventListener("submit", function (event) {
            event.preventDefault(); // prevent form from submitting normally
            var postId = this.dataset.postId; // get the post ID
            var formData = new FormData(this); // get the form data
            var request = new XMLHttpRequest();
            request.open("POST", this.action);
            request.onreadystatechange = function () {
                if (this.readyState === 4 && this.status === 200) {
                    var likeButton = document.getElementById(
                        "like-button-" + postId
                    );
                    var dislikeButton = document.getElementById(
                        "dislike-button-" + postId
                    );

                    // update the like count on the page for the specific post
                    document.getElementById("like-count-" + postId).innerHTML =
                        JSON.parse(this.responseText).likeCount;
                    document.getElementById(
                        "dislike-count-" + postId
                    ).innerHTML = JSON.parse(this.responseText).dislikeCount;

                    // update the like button
                    if (JSON.parse(this.responseText).userStatus == "liked") {
                        likeButton.classList.remove("btn-outline-primary");
                        likeButton.classList.add("btn-primary");
                        dislikeButton.classList.remove("btn-danger");
                        dislikeButton.classList.add("btn-outline-danger");
                    } else {
                        likeButton.classList.remove("btn-primary");
                        likeButton.classList.add("btn-outline-primary");
                        dislikeButton.classList.remove("btn-danger");
                        dislikeButton.classList.add("btn-outline-danger");
                    }
                }
            };
            request.send(formData);
        });
    }

    // Add event listener for each dislike form
    for (i = 0; i < dislikeForms.length; i++) {
        dislikeForms[i].addEventListener("submit", function (event) {
            event.preventDefault(); // prevent form from submitting normally
            var postId = this.dataset.postId; // get the post ID
            var formData = new FormData(this); // get the form data
            var request = new XMLHttpRequest();
            request.open("POST", this.action);
            request.onreadystatechange = function () {
                if (this.readyState === 4 && this.status === 200) {
                    var likeButton = document.getElementById(
                        "like-button-" + postId
                    );
                    var dislikeButton = document.getElementById(
                        "dislike-button-" + postId
                    );

                    // update the dislike count on the page for the specific post
                    document.getElementById(
                        "dislike-count-" + postId
                    ).innerHTML = JSON.parse(this.responseText).dislikeCount;
                    document.getElementById("like-count-" + postId).innerHTML =
                        JSON.parse(this.responseText).likeCount;

                    // update the like button
                    if (
                        JSON.parse(this.responseText).userStatus == "disliked"
                    ) {
                        dislikeButton.classList.remove("btn-outline-danger");
                        dislikeButton.classList.add("btn-danger");
                        likeButton.classList.remove("btn-primary");
                        likeButton.classList.add("btn-outline-primary");
                    } else {
                        dislikeButton.classList.remove("btn-danger");
                        dislikeButton.classList.add("btn-outline-danger");
                        likeButton.classList.remove("btn-primary");
                        likeButton.classList.add("btn-outline-primary");
                    }
                }
            };
            request.send(formData);
        });
    }

    // Add event listener for each comment form
    for (i = 0; i < commentForms.length; i++) {
        commentForms[i].addEventListener("submit", function (event) {
            event.preventDefault(); // prevent form from submitting normally
            var postId = this.dataset.postId; // get the post ID
            var formData = new FormData(this); // get the form data
            var request = new XMLHttpRequest();
            request.open("POST", this.action);
            request.onreadystatechange = function () {
                if (this.readyState === 4 && this.status === 200) {
                    const commentSection = document.getElementById(
                        "comments-section-" + postId
                    );
                    const newComment = document.createElement("div");
                    newComment.classList.add("card", "mb-2");
                    newComment.style.background = "#f5f7ff";

                    var baseUrl = window.location.origin;

                    const innerHTML = `
                                    <div class="card-body">
                                        <div class="media">
                                            <img src="${baseUrl}/img/avatar/${
                                                JSON.parse(this.responseText)
                                                    .commentAvatar
                                            }"
                                                style="width: 30px; height: 30px" class="mr-3"
                                                alt="Profile Image">
                                            <div class="media-body">
                                                <p class="card-text"><b>${
                                                    JSON.parse(
                                                        this.responseText
                                                    ).commentFullname
                                                }:&nbsp;&nbsp;</b>${
                        JSON.parse(this.responseText).newComment
                    }</p>
                                            </div>
                                        </div>
                                        <div class="media ml-5 mt-3">
                                            <div class="mb-2 pull-right" style="font-size: 10px">
                                                <i class="mdi mdi-calendar-clock"></i>&nbsp;&nbsp;${
                                                    JSON.parse(
                                                        this.responseText
                                                    ).commentCreated_at
                                                }
                                            </div>
                                        </div>
                                    </div>`;

                    newComment.innerHTML = innerHTML;
                    commentSection.appendChild(newComment);

                    document.getElementById(
                        "comment-count-" + postId
                    ).innerHTML = JSON.parse(this.responseText).commentCount;
                    document.getElementById("comment-text-" + postId).value =
                        "";
                }
            };
            request.send(formData);
        });
    }
});
