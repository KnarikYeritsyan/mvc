<?php
class Login_Model extends Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function authenticate($username,$password)
    {
        try {
            $query = $this->db->prepare("SELECT * FROM users WHERE `username` = :username");
            $query->execute([
                ':username' => $username,
            ]);
        } catch (PDOException $e) {
            return false;
        }
        $count = $query->rowCount();
        if ($count > 0) {
            $data = $query->fetch();
            if (password_verify($password,$data['password'])) {
                Session::init();
                Session::set('user_id', $data['id']);
                Session::set('loggedIn', true);
            return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
    public function get_user($id)
    {
        $query = $this->db->prepare("SELECT * FROM users WHERE id =" . $id);
        $query->execute();
        return $query->fetch();
    }
}