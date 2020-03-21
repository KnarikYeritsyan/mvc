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
                if ($data['logged_in'] && $data['token']){
                    $id = \Session::get('user_id');
                    $this->db_logout($id);
                    \Session::destroy();
                    return 'logoff';
                }else {
                    Session::set('user_id', $data['id']);
                    Session::set('loggedIn', true);
                    return 'login';
                }
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
    public function set_tab($id,$tab_id)
    {
        $query = $this->db->prepare("UPDATE users SET logged_in = '1', token = :token WHERE id = " . $id);
        return $query->execute([
            'token' => $tab_id,
        ]);
    }
    public function db_logout($id)
    {
        $query = $this->db->prepare("UPDATE users SET logged_in = '0', token = NULL WHERE id = " . $id);
        return $query->execute();
    }
    public function check_tab($id,$tab_id)
    {
        $query = $this->db->prepare("SELECT * FROM users WHERE id = :id AND token = :token");
        $query->execute([
            'id'=>$id,
            'token'=>$tab_id
        ]);
        return $query->fetch();
    }
}