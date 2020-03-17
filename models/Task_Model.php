<?php
class Task_Model extends Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getAllTasks()
    {
        $query = $this->db->prepare("SELECT * FROM tasks");
        $query->execute();
        return $query->fetchAll();
    }
    public function showTask($id)
    {
        $query = $this->db->prepare("SELECT * FROM tasks WHERE id =" . $id);
        $query->execute();
        return $query->fetch();
    }
    public function create($data)
    {
        $query = $this->db->prepare("INSERT INTO tasks (`name`, `email`, `text`) VALUES (:name, :email, :text)");

        return $query->execute([
            'name' => $data['name'],
            'email' => $data['email'],
            'text' => $data['text'],
        ]);
    }

}