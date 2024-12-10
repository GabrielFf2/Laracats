<?php

namespace Http\controllers;

use Core\App;
use Core\Database;
use Core\Session;
use Core\Validator;
use dao\DAOFactory;
use dao\INotesControllerDao;
use dao\notesDao;


class NotesController
{

    public function create()
    {

        view("notes/create.view.php", [
            'heading' => 'Create Note',
            'errors' => []
        ]);

    }

    public function destroy($param, $user, $request)
    {
        $noteDao = new DAOFactory();
        // Obtener la URL actual
        $url = $_SERVER['REQUEST_URI'];

        // Dividir la URL por '/' y tomar el último segmento
        $segments = explode('/', $url);
        $id = end($segments);
        $note = $this->getNoteById($id);
        $this->authorizeNoteOwner($note);

        $noteDao->getNoteDAO()->deleteNote($id);

        $this->redirectTo('/notes');
    }

    public function edit()
    {
        // Obtener la URL actual
        $url = $_SERVER['REQUEST_URI'];
        // Dividir la URL por '/' y tomar el último segmento
        $segments = explode('/', $url);
        $id = $segments[2];

        $note = $this->getNoteById($id);
        $this->authorizeNoteOwner($note);

        view("notes/edit.view.php", [
            'heading' => 'Edit Note',
            'errors' => [],
            'note' => $note
        ]);
    }

    public function index($param, $user, $request)
    {
        $noteDao = new DAOFactory();
        $notes = $noteDao->getNoteDAO()->getNotes($user['idUser']);


        view("notes/index.view.php", [
            'heading' => 'My Notes',
            'notes' => $notes
        ]);
    }

    public function show(){
        // Obtener la URL actual
        $url = $_SERVER['REQUEST_URI'];

        // Dividir la URL por '/' y tomar el último segmento
        $segments = explode('/', $url);
        $id = end($segments);

        $note = $this->getNoteById($id);
        $this->authorizeNoteOwner($note);

        view("notes/show.view.php", [
            'heading' => 'Note',
            'note' => $note
        ]);
    }

    public function store()
    {
        $errors = $this->validateNoteBody($_POST['body'], 1, 1000);

        if (!empty($errors)) {
            return view("notes/create.view.php", [
                'heading' => 'Create Note',
                'errors' => $errors
            ]);
        }

        $this->db->query('INSERT INTO notes(body, user_id) VALUES(:body, :user_id)', [
            'body' => $_POST['body'],
            'user_id' => $this->currentUserId
        ]);

        $this->redirectTo('/notes');
    }

    public function update()
    {
        $note = $this->getNoteById($_POST['id']);
        $this->authorizeNoteOwner($note);

        $errors = $this->validateNoteBody($_POST['body'], 1, 1000);

        if (!empty($errors)) {
            return view("notes/edit.view.php", [
                'heading' => 'Edit Note',
                'errors' => $errors,
                'note' => $note
            ]);
        }

        $this->db->query('UPDATE notes SET body = :body WHERE id = :id', [
            'body' => $_POST['body'],
            'id' => $_POST['id']
        ]);

        $this->redirectTo('/notes');
    }

    private function getNoteById($id)
    {
        return $this->db->query('SELECT * FROM notes WHERE id = :id', ['id' => $id])
            ->findOrFail();
    }

    private function authorizeNoteOwner($note)
    {
        authorize($note['user_id'] === $this->currentUserId);
    }

    private function validateNoteBody($body, $minLength, $maxLength)
    {
        $errors = [];
        if (!Validator::string($body, $minLength, $maxLength)) {
            $errors['body'] = "No pot tenir mes de $maxLength caracters.";
        }
        return $errors;
    }

    private function redirectTo($url)
    {
        header("Location: $url");
        exit();
    }
}