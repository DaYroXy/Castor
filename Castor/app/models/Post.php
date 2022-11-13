
<?php
    class Post {
        private $db;

        public function __construct() {
            $this->db = new Database;
        }

        public function getPosts() {
            // Run query
            $this->db->query('SELECT *,
                posts.id as postId,
                users.id as userId,
                posts.created_at as postCreated,
                users.created_at as userCreated
                FROM posts INNER JOIN users ON posts.user_id = users.id
                ORDER BY posts.created_at DESC');
            // Return all Results
            return $this->db->resultSet();
  
        }

        public function addPost($data) {
            $this->db->query('INSERT INTO posts(user_id, title, content) VALUES(:user_id, :title, :content)');
            $this->db->bind(':user_id', $data['user_id']);
            $this->db->bind(':title', $data['title']);
            $this->db->bind(':content', $data['content']);
            if($this->db->execute()) {
                return true;
            }

            return false;
        }

        public function editPost($data) {
            $this->db->query('UPDATE posts set title = :title, content = :content WHERE id = :id');
            $this->db->bind(':title', $data['title']);
            $this->db->bind(':content', $data['content']);
            $this->db->bind(':id', $data['id']);
            if($this->db->execute()) {
                return true;
            }

            return false;
        }

        public function delete($id) {
            $this->db->query('DELETE FROM posts WHERE id = :id');
            $this->db->bind(':id', $id);
            if($this->db->execute()) {
                return true;
            }

            return false;
        }

        public function getPostById($id) {
             // Run query
             $this->db->query('SELECT *,
             posts.id as postId,
             users.id as userId,
             posts.created_at as postCreated,
             users.created_at as userCreated
             FROM posts INNER JOIN users ON posts.user_id = users.id WHERE posts.id = :id
             ORDER BY posts.created_at DESC');

            $this->db->bind(':id', $id);
             
            // Return all Results
            return $this->db->single();

        }

    }