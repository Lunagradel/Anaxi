<template>

    <div class="anaxi-comments">
        <div class="anaxi-comments-items">
            <div class="anaxi-comments-item" v-for="comment in comments">
                <div class="comments-item-user">
                    <p>{{comment.user}}</p>
                </div>
                <div class="comments-item-comment">
                    <p>{{comment.text}}</p>
                </div>
            </div>
        </div>
        <div class="anaxi-comments-input">
            <input type="text" name="comment" v-model="comment" placeholder="Add comment..">
            <div class="anaxi-comments-btn" v-on:click="addComment">
                Send
            </div>
        </div>

    </div>

</template>

<script>



export default {

    props: ['experience'],
    data: function(){
        return {

            comment: '',
            comments: [

            ]

        }
    },

    methods: {
        addComment: function(){

            let self = this;
            let commentText = this.comment;
            let userName = this.$root.store.user.fullName;

            if (!this.comment) {
                //can't post a empty comment!
            } else {
                axios.post('/addcomment', {
                    postId: this.experience._id.$oid,
                    comment: this.comment,
                    userName: this.$root.store.user.fullName
                })
                  .then(function (response) {
                    console.log(response);
                    self.addNewComment(commentText, userName);
                    self.comment = '';
                  })
                  .catch(function (error) {
                    console.log(error);
                  });
            }
        },

        getComments: function(){

            let commentsArr = this.comments;

            let commentsFromDB = this.experience.comments;

            if (!commentsFromDB){
                console.log("no comments");
            } else {
                commentsFromDB.forEach(function(item){

                    let comment = {text: item.comment, user: item.userName};
                    commentsArr.push(comment);
                });
            }



        },

        addNewComment(comment, user){
            let commentsArr = this.comments;
            let newComment = {text: comment, user: user};
            commentsArr.push(newComment);
        }
    },

    mounted: function(){

        this.getComments();


    }

}
</script>
