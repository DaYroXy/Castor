<?php

    class User {
        private $db;

        public function __construct() {
            // set database class to private $db
            $this->db = new Database();
        }

        // Register user
        public function register($data) {
            // Run query
            $this->db->query('INSERT INTO users(name, email, password, role) VALUES(:name, :email, :password, :role)');
            
            // bind params to query
            $this->db->bind(':name', $data["name"]);
            $this->db->bind(':email', $data["email"]);
            $this->db->bind(':password', $data["password"]);
            $this->db->bind(':role', 'guest');
            
            // Execute and check for errors
            if($this->db->execute()) {
                return true;
            }

            return false;
        }

        // Login user
        public function login($email, $password) {
            // Run query
            $this->db->query('SELECT * FROM users WHERE email = :email');
                        
            // bind params to query
            $this->db->bind(':email', $email);
            
            // Get Single Result
            $row = $this->db->single();

            if(password_verify($password, $row->password)) {
                return $row;
            }
            
            return false;
        }

        // find user by email
        public function findUserByEmail($email) {
            $this->db->query('SELECT * FROM users WHERE email = :email');
            $this->db->bind(':email', $email);
            // Execute and return rows, we only want to check if email exists so we dont need to store the data
            $this->db->single();
            
            // if email exists
            if($this->db->rowCount() > 0) {
                return true;
            } 

            return false;
        }
    }