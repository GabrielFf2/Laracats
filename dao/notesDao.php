<?php

namespace dao;
use Core\Database;

class notesDao implements INotesDao
{

    private Database $db;

    public function __construct(Database $connection)
    {
        $this->db = $connection;
    }

    public function getNotes($idUser)
    {
        return $this->db->query('SELECT * FROM notes WHERE user_id = :id', [
            'id' => $idUser
        ])->get();
    }

    public function getNoteById($idNote)
    {
        return $this->db->query('SELECT * FROM notes WHERE id = :id', ['id' => $idNote])
            ->findOrFail();
    }

    public function createNote($idUser, $body)
    {
        return $this->db->query('INSERT INTO notes(body, user_id) VALUES(:body, :user_id)', [
            'body' => $body,
            'user_id' => $idUser
        ]);
    }

    public function updateNote($id, $body)
    {
        return $this->db->query('UPDATE notes SET body = :body WHERE id = :id', [
            'body' => $body,
            'id' => $id
        ]);
    }

    public function deleteNote($id)
    {
        return $this->db->query('DELETE FROM notes WHERE id = :id', ['id' => $id]);

    }
}