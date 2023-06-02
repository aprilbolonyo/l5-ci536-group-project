<?php
    class UserAPI {
        private $resp;
        private $sql_pwd = "";

        function __construct() {
            $sql_pwd = ini_get("sql_ci536_pwd");
        }

        private function get_user() {
            
        }

        private function auth_request() { // returns logged in user ID or false
            if (isset(getallheaders()['Authorization'])) {
                if (substr(getallheaders()['Authorization'], 7)) {
                    $mysqli = new mysqli('localhost', 'asm89_ci536', $this->sql_pwd, 'asm89_ci536');
                    if ($mysqli->connect_errno) {
                        http_response_code(500);
                        return false;
                    } else {
                        $token = $mysqli->real_escape_string(getallheaders()['Authorization']);
                        $result = $mysqli->query("SELECT * FROM sessions WHERE token='$token'");
                        if (!$result) {
                            http_response_code(500);
                        } else {
                            $row = $result->fetch_assoc();
                            if (isset($row)) {
                                $expiry = strtotime($row['expiry']);
                                if ($expiry < time()) {
                                    http_response_code(403);
                                    $result = $mysqli->query("DELETE FROM sessions WHERE token='$token");
                                } else {
                                    $mysqli->close();
                                    return $row['user'];
                                }
                            } else {
                                http_response_code(403);
                            }
                        }
                    }
                    $mysqli->close();
                } else {
                    http_response_code(401);
                }
            } else {
                http_response_code(401);
            }
            return false;
        }

        public function handle_session_request() {
            if (isset($_SERVER['REQUEST_METHOD'])) {
                if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
                    $user = $this->auth_request();
                    if ($user) {
                        $mysqli = new mysqli('localhost', 'asm89_ci536', $this->sql_pwd, 'asm89_ci536');
                        if ($mysqli->connect_errno) {
                            http_response_code(500);
                        } else {
                            $token = $mysqli->real_escape_string(getallheaders()['Authorization']);
                            $query = "DELETE FROM sessions WHERE token='$token'";
                            $result = $mysqli->query($query);
                            if ($result) {
                                http_response_code(204);
                            } else {
                                http_response_code(500);
                            }
                            $mysqli->close();
                        }
                    } else {
                        //return;
                    }
                } elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    if (isset($_POST['email']) && isset($_POST['password'])) {
                        $mysqli = new mysqli('localhost', 'asm89_ci536', $this->sql_pwd, 'asm89_ci536');
                        if ($mysqli->connect_errno) {
                            http_response_code(500);
                            return;
                        } else {
                            $email = $mysqli->real_escape_string($_POST['email']);
                            $query = "SELECT * FROM users WHERE email='$email'";
                            $result = $mysqli->query($query);
                            if (!$result) {
                                http_response_code(500);
                            } else {
                                $row = $result->fetch_assoc();
                                if (!isset($row)) {
                                    http_response_code(403);
                                } elseif (password_verify($_POST['password'], $row['password'])) {
                                    if (password_needs_rehash($row['password'], PASSWORD_DEFAULT)) {
                                        $new_pwd = $mysqli->real_escape_string(password_hash($_POST['password'], PASSWORD_DEFAULT));
                                        $query = "UPDATE users SET password = '$new_pwd' WHERE email='$email'";
                                        $result = $mysqli->query($query);
                                        // silently fail if failed
                                    }
                                }
                            }
                            $mysqli->close();
                        }
                    } else {
                        http_response_code(400);
                        return;
                    }
                } else {
                    http_response_code(405);
                    return;
                }
            } else {
                http_response_code(405);
                return;
            }
            return json_encode($this->resp);
        }
    }
?>