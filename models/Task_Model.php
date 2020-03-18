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
    public function getTasksPaginated($page = null,$field=null,$sort=null)
    {
        $page = isset($page) && is_numeric($page) ? $page : 1;
        $field = isset($field) ? $field : 'created_at';
        $sort = isset($sort) ? $sort : 'ASC';
        $perPage = 3;
        $startAt = $perPage * ($page - 1);
        $total_rows = $this->db->query('SELECT * FROM tasks')->rowCount();
        $total_pages = ceil($total_rows/$perPage);
        $query = $this->db->prepare("SELECT * FROM tasks ORDER BY ".$field." ".$sort." LIMIT ".$startAt.", ".$perPage);
        $query->execute();
        $tasks['tasks'] = $query->fetchAll();
        $tasks['total_pages'] = $total_pages;
        $tasks['field'] = $field;
        $tasks['sort'] = $sort;
        return $tasks;
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
    public function update($data)
    {
        $q = $this->db->prepare("SELECT * FROM tasks WHERE id =" . $data['id']);
        $q->execute();
        $task = $q->fetch();
        if ($task['text'] != $data['text']) {
            $query = $this->db->prepare("UPDATE tasks SET text_status = 1, text = :text , updated_at = :updated_at WHERE id = :id");
        }else{
            $query = $this->db->prepare("UPDATE tasks SET text = :text , updated_at = :updated_at WHERE id = :id");
        }
            return $query->execute([
                'id' => $data['id'],
                'text' => $data['text'],
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
    }
    public function update_check($data)
    {
        $query = $this->db->prepare("UPDATE tasks SET status = :status WHERE id = :id");
        return $query->execute([
            'id' => $data['id'],
            'status' => $data['status'],
        ]);
    }
}