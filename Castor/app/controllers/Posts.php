<?php

    class Posts extends Controller {
        private $postModel;
        
        public function __construct() {
            if(!isLoggedIn()) {
                redirect('users/login');
            }

            $this->postModel = $this->model('post');
        }

        public function index() {
            // Get Posts
            $posts = $this->postModel->getPosts();

            $data = [
                'posts' => $posts
            ];

            $this->view('posts/index', $data);
        }
        
        public function add() {
            if($_SERVER["REQUEST_METHOD"] === "POST") {
                // Sanitize the post array
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                $data = [
                    'title' => trim($_POST["title"]),
                    'content' => trim($_POST["content"]),
                    'user_id' => $_SESSION['user']['id'],
                    'title_error' => '',
                    'content_error' => ''
                ];

                // Validate title
                if(empty($data['title'])) {
                    $data['title_error'] = 'Title is required.';
                }
                
                // Validate content
                if(empty($data['content'])) {
                    $data['content_error'] = 'Content is required.';
                }

                if(empty($data['title_error']) && empty($data['content_error'])) {
                    // Validated
                    if($this->postModel->addPost($data)) {
                        flash('post_message', 'Post Added');
                        redirect('posts');
                    } else {
                        die('something went wrong');
                    }
                }

            } else {
                $data = [
                    'title' => '',
                    'content' => ''
                ];
            }

            $this->view('posts/add', $data);
        }

        public function edit($id = '') {
            // check if owner
            $post = $this->postModel->getPostById($id); 
            if($post->user_id !== $_SESSION['user']['id']) {
                redirect('posts/index');
            }

            if($_SERVER["REQUEST_METHOD"] === "POST") {
                // Sanitize the post array
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                $data = [
                    'id' => $id,
                    'title' => trim($_POST["title"]),
                    'content' => trim($_POST["content"]),
                    'user_id' => $_SESSION['user']['id'],
                    'title_error' => '',
                    'content_error' => ''
                ];

                // Validate title
                if(empty($data['title'])) {
                    $data['title_error'] = 'Title is required.';
                }
                
                // Validate content
                if(empty($data['content'])) {
                    $data['content_error'] = 'Content is required.';
                }

                if(empty($data['title_error']) && empty($data['content_error'])) {
                    // Validated
                    if($this->postModel->editPost($data)) {
                        flash('post_message', 'Post Updated', 'alert alert-warning');
                        redirect('posts');
                    } else {
                        die('something went wrong');
                    }
                }

            } else {
                $data = [
                    'id' => $id,
                    'title' => $post->title,
                    'content' => $post->content
                ];
            }

            $this->view('posts/edit', $data);
        }

        public function delete($id = '') {
            // check if owner
            if($_SERVER['REQUEST_METHOD'] !== "POST") {
                redirect('posts');
            }

            $post = $this->postModel->getPostById($id); 
            if(!$post || ($post->user_id !== $_SESSION['user']['id'])) {
                redirect('posts');
            }
            
            $this->postModel->delete($id);
            flash('post_message', 'Post Deleted', 'alert alert-danger');
            redirect('posts');
            

        }

        // posts/show/id
        public function show($id = '') {
            $post = $this->postModel->getPostById($id); 
            // if post doesnt exist
            if(!$post) {
                redirect("posts");
            }
            $data = [
                'post' => $post
            ];
            $this->view('posts/show', $data);
        }
    }