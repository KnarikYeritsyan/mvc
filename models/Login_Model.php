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
            $sth = $this->db->prepare("SELECT * FROM ".DB_TABLE1." WHERE `username` = :username");
            $sth->execute([
                ':username' => $username,
            ]);

        } catch (PDOException $e) {
            return false;
        }
        $count = $sth->rowCount();
        if ($count > 0) {
            $data = $sth->fetch();
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
        $sql = "SELECT * FROM users WHERE id =" . $id;
        $req = $this->db->prepare($sql);
        $req->execute();
        return $req->fetch();
    }
}