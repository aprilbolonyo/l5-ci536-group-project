<?php
    class UserAPI {
        private $resp = array();
        private static $sql_pwd = ini_get("sql_ci536_pwd");

        private function get_user() {
            
        }

        private function auth_request() { // returns logged in user ID or false
            if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
                $mysqli = new mysqli('localhost', 'asm89_ci536', self::$sql_pwd, 'asm89_ci536');
                if ($mysqli->connect_errno) {
                    http_response_code(500);
                    return mysqli_connect_error();
                } else {
                    $token = $mysqli->real_escape_string($_SERVER['HTTP_AUTHORIZATION']);
                    $result = $mysqli->query("SELECT * FROM sessions WHERE token='$token'");
                    if (!$result) {
                        http_response_code(500);
                        return $mysqli->error;
                    }
                    $row = $result->fetch_assoc();
                    if (isset($row)) {
                        
                    }
                }
            } else {
                http_response_code(401);
                return false;
            }
        }

        public function handle_session_request() {
            if (isset($_SERVER['REQUEST_METHOD'])) {
                if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
                    if ($this->auth_request()) {
                        $mysqli = new mysqli('localhost', 'asm89_ci536', self::$sql_pwd, 'asm89_ci536');
                        if ($mysqli->connect_errno) {
                            http_response_code(500);
                            return mysqli_connect_error();
                        } else {
                            $token = $mysqli->real_escape_string($_SERVER['HTTP_AUTHORIZATION']);
                            $query = "DELETE FROM sessions WHERE token='$token'";
                            // if (isset($_GET['source'])) {
                            //     $source = $mysqli->real_escape_string($_GET['source']);
                            //     $query = $query . "source='$source'";
                            //     if (isset($_GET['target'])) {
                            //         $target = $mysqli->real_escape_string($_GET['target']);
                            //         $query = $query . " AND target='$target'";
                            //     }
                            // } else {
                            //     $target = $mysqli->real_escape_string($_GET['target']);
                            //     $query = $query . "target='$target'";
                            // }
                            // $result = $mysqli->query($query);
                            // if (!$result) {
                            //     http_response_code(500);
                            //     return $mysqli->error;
                            // }
                            // $rows = $result->fetch_all(MYSQLI_ASSOC);
                            // if (count($rows) == 0) {
                            //     http_response_code(204);
                            // }
                            // $this->resp['messages'] = $rows;
                            $mysqli->close();
                        }
                    } else {
                        http_response_code(400);
                        return null;
                    }
                } elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    if ($this->validate_post()) {
                        $mysqli = new mysqli('localhost', 'asm89_ci527', self::$sql_pwd, 'asm89_ci527');
                        if ($mysqli->connect_errno) {
                            http_response_code(500);
                            return mysqli_connect_error();
                        } else {
                            $source = $mysqli->real_escape_string($_POST['source']); // whilst I only need to escape the message because of
                            $target = $mysqli->real_escape_string($_POST['target']); // username validation it is better to be safe than sorry
                            $message = $mysqli->real_escape_string($_POST['message']); // prevent SQL injection
                            $query = "INSERT INTO messages (source, target, message)"
                                    . "VALUES ('$source', '$target', '$message')";
                            $result = $mysqli->query($query);
                            if (!$result) {
                                http_response_code(500);
                                return $mysqli->error;
                            }
                            http_response_code(201);
                            $this->resp['id'] = $mysqli->insert_id;
                            $mysqli->close();
                        }
                    } else {
                        http_response_code(400);
                        return null;
                    }
                } else {
                    http_response_code(405);
                    return null;
                }
            }
            return json_encode($this->resp);
        }
    }
?>