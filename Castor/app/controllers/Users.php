<?php

    class Users extends Controller {
        private $userModel;

        public function __construct() {
            $this->userModel = $this->model('User');
        }

        // Index Page
        public function index() {
            header("location: ./");
        }

        public function register() {
            
            // Check for post request
            if($_SERVER["REQUEST_METHOD"] === "POST") {
                // process form

                // Sanitize Post Data
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                // init data
                $data = [
                    'name' => trim($_POST['name']),
                    'email' => trim($_POST['email']),
                    'password' => trim($_POST['password']),
                    'confirm_password' => trim($_POST['confirm_password']),
                    'name_error' => '',
                    'email_error' => '',
                    'password_error' => '',
                    'confirm_password_error' => ''
                ];

                // Validate Email
                if(empty($data["email"])) {
                    $data["email_error"] = 'Please enter email';
                } else {
                    // check email;
                    if($this->userModel->findUserByEmail($data["email"])) {
                        $data["email_error"] = 'Email is already taken';
                    }
                }

                // Validate Name
                if(empty($data["name"])) {
                    $data["name_error"] = 'Please enter name';
                }

                // Validate Password
                if(empty($data["password"])) {
                    $data["password_error"] = 'Please enter password';
                } elseif(strlen($data["password"]) < 6) {
                    $data["password_error"] = 'Password must be at least 6 characters.';
                }

                // Confirm Password
                if(empty($data["confirm_password"])) {
                    $data["confirm_password_error"] = 'Please enter confirm password';
                } else {
                    if($data["password"] != $data["confirm_password"]) {
                        $data["confirm_password_error"] = 'Password do not much';
                    }
                }

                // Make sure there are no errors.
                if(empty($data["name_error"]) && empty($data["email_error"]) &&
                 empty($data["password_error"]) && 
                 empty($data["confirm_password_error"])) {

                    // Validated

                    // Hash password
                    $data["password"] = password_hash($data["password"], PASSWORD_DEFAULT);
                    
                    // Register user
                    if($this->userModel->register($data)) {
                        flash('register_success', 'You are registerd and can log in');
                        redirect("users/login");
                    } else {
                        die("Something went wrong.");
                    }
                }
                // Load view
                $this->view('users/register', $data);
                return;
            }

            $data = [
                'name' => '',
                'email' => '',
                'password' => '',
                'confirm_password' => '',
                'name_error' => '',
                'email_error' => '',
                'password_error' => '',
                'confirm_password_error' => ''
            ];

            // Load view
            $this->view('users/register', $data);
        }

        // Login Function
        public function login() {
            if($_SERVER["REQUEST_METHOD"] === "POST") {
                
                // Sanitize Post Data
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                // init data
                $data = [
                    'email' => trim($_POST["email"]),
                    'password' => trim($_POST["password"]),
                    'email_error' => '',
                    'password_error' => '',
                ];

                // Validate Email
                if(empty($data["email"])) {
                    $data["email_error"] = 'Please enter email';
                }

                // Check for used email
                if($this->userModel->findUserByEmail($data["email"])) {
                    // User found
                } else {
                    $data["email_error"] = "No user found.";
                }

                // Validate Password
                if(empty($data["password"])) {
                    $data["password_error"] = 'Please enter password';
                }

                if(empty($data["email_error"]) && empty($data["password_error"])) {
                    $loggedInUser = $this->userModel->login($data['email'], $data['password']);
                    
                    if($loggedInUser) {
                        // Create Session
                        $this->createUserSession($loggedInUser);
                    }
                    
                    $data["password_error"] = 'Incorrect password';
                    $this->view('users/login', $data);
                    return;
                }

                // Load view
                $this->view('users/login', $data);
                return;
            }
            
            
            // init data
            $data = [
                'email' => '',
                'password' => '',
            ];

            // Load view
            $this->view('users/login', $data);

        }

        // Logout function
        public function logout() {
            unset($_SESSION['user']);
            session_destroy();
            redirect('user/login');
        }


        // Create user session
        public function createUserSession($loggedInUser) {
            $_SESSION['user']['id'] = $loggedInUser->id;
            $_SESSION['user']['email'] = $loggedInUser->email;
            $_SESSION['user']['name'] = $loggedInUser->name;
            $_SESSION['user']['role'] = $loggedInUser->role;
            redirect('');
        }

    }