<template>
  <div>
      <h2> Posts </h2>
      <!-- add post -->
        <form @submit.prevent="addPost" class="mb-3">
            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" class="form-control" id="title" v-model="post.title" placeholder="Title">
            </div>
            <div class="form-group">
                <label for="pwd">Body:</label>
                <textarea class="form-control" id="pwd" v-model="post.body" placeholder="Write here..."></textarea>
            </div>
            <button type="submit" class="btn btn-success">Submit</button>
        </form>

    <!-- all post -->
      <nav aria-label="Page navigation">
        <ul class="pagination">
            <li :class="[{disabled: !pagination.prev_page_url}]">
                <a href="#" aria-label="Previous" @click="fetchPosts(pagination.prev_page_url)">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
            <li class="disabled">
                <a class="text-dark" href="#">
                    Page {{ pagination.current_page }} of {{ pagination.last_page }}
                </a>
            </li>
            <li :class="[{disabled: !pagination.next_page_url}]">
                <a href="#" aria-label="Next"  @click="fetchPosts(pagination.next_page_url)">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
      </nav>
      <div v-for="post in posts" v-bind:key="post.id">
          <div class="row">
                <div class="col-sm-10 col-md-8">
                    <div class="thumbnail">
                        <div class="caption">
                            <h3>{{ post.title }}</h3>
                            <p>{{ post.body }}</p>
                            <p>
                                <a href="#" class="btn btn-info" role="button" @click="editPost(post)">Edit</a>
                                <a href="#" class="btn btn-danger" role="button" @click="deletePost(post.id)">Delete</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
      </div>
  </div>
</template>

<script>
    export default {
        data () {
            return {
                posts: [],
                post: {
                    id: '',
                    title: '',
                    body: ''
                },
                post_id: '',
                pagination: {},
                edit: false
            }
        },
        created () {
            this.fetchPosts();
        },
        methods: {
            fetchPosts(page_url) {
                let vm = this;
                page_url = page_url || 'api/posts' ;
                fetch(page_url)
                    .then(res => res.json())
                        .then(res => {
                            this.posts = res.data;
                            vm.makePagination(res.meta, res.links);
                        })
                        .catch(err => console.log(err));
            },
            makePagination (meta, links) {
                let pagination = {
                    current_page: meta.current_page,
                    last_page: meta.last_page,
                    next_page_url: links.next,
                    prev_page_url: links.prev
                }
                this.pagination = pagination;
            },
            deletePost (id) {
                if(confirm('Are You Sure?')){
                    fetch('api/post/'+id, {
                        method: 'delete'
                    })
                    .then(res => res.json())
                        .then(data => {
                            alert('Post Removed!');
                            this.fetchPosts();
                        })
                        .catch(err => console.log(err));
                }
            },
            addPost () {
                if(this.edit === false) {
                    //add
                    fetch('api/post', {
                        method: 'post',
                        body: JSON.stringify(this.post),
                        headers: {
                            'content-type': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        this.post.title = '';
                        this.post.body = '';
                        alert('Post Added!');
                        this.fetchPosts();
                    })
                    .catch(err => console.log(err));
                }else{
                //update
                    fetch('api/post', {
                        method: 'put',
                        body: JSON.stringify(this.post),
                        headers: {
                            'content-type': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        this.post.title = '';
                        this.post.body = '';
                        alert('Post Updated');
                        this.fetchPosts();
                    })
                    .catch(err => console.log(err));
                }
            },
            editPost (post) {
                this.edit =true;
                this.post.id = post.id;
                this.post.post_id = post.id;
                this.post.title = post.title;
                this.post.body = post.body;
            }
        }
    }
</script>