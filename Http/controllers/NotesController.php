<?php

namespace Http\controllers;

use Core\Session;
use Core\Validator;
use dao\DAOFactory;


class NotesController
{

    public function create()
    {

        view("notes/create.view.php", [
            'heading' => 'Create Note',
            'errors' => []
        ]);

    }

    public function destroy()
    {
        $noteDao = new DAOFactory();

        $url = $_SERVER['REQUEST_URI'];
        $segments = explode('/', $url);

        $id = end($segments);
        $note = $noteDao->getNoteDAO()->getNoteById($id);
        $this->authorizeNoteOwner($note);

        $noteDao->getNoteDAO()->deleteNote($id);

        $this->redirectTo('/notes');
    }

    public function edit()
    {
        $noteDao = new DAOFactory();
        // Obtener la URL actual
        $url = $_SERVER['REQUEST_URI'];
        // Dividir la URL por '/' y tomar el último segmento
        $segments = explode('/', $url);
        $id = $segments[2];

        $note = $noteDao->getNoteDAO()->getNoteById($id);
        $this->authorizeNoteOwner($note);

        view("notes/edit.view.php", [
            'heading' => 'Edit Note',
            'errors' => [],
            'note' => $note
        ]);
    }

    public function index()
    {
        $noteDao = new DAOFactory();
        $notes = $noteDao->getNoteDAO()->getNotes($_SESSION['user']['id']);

        view("notes/index.view.php", [
            'heading' => 'My Notes',
            'notes' => $notes
        ]);

    }

    public function show(){
        $noteDao = new DAOFactory();
        // Obtener la URL actual
        $url = $_SERVER['REQUEST_URI'];

        // Dividir la URL por '/' y tomar el último segmento
        $segments = explode('/', $url);
        $id = end($segments);

        $note = $noteDao->getNoteDAO()->getNoteById($id);
        $this->authorizeNoteOwner($note);

        view("notes/show.view.php", [
            'heading' => 'Note',
            'note' => $note
        ]);
    }

    public function store()
    {
        $body = $_POST['body'];
        $noteDao = new DAOFactory();
        $errors = $this->validateNoteBody($body, 1, 1000);

        if (!empty($errors)) {
            return view("notes/create.view.php", [
                'heading' => 'Create Note',
                'errors' => $errors
            ]);
        }

        $noteDao->getNoteDAO()->createNote($_SESSION['user']['id'], $body);

        $this->redirectTo('/notes');
    }

    public function update()
    {
        $noteDao = new DAOFactory();
        $note = $noteDao->getNoteDAO()->getNoteById($_POST['id']);
        $this->authorizeNoteOwner($note);

        $errors = $this->validateNoteBody($_POST['body'], 1, 1000);

        if (!empty($errors)) {
            return view("notes/edit.view.php", [
                'heading' => 'Edit Note',
                'errors' => $errors,
                'note' => $note
            ]);
        }

        $noteDao->getNoteDAO()->updateNote($_POST['id'], $_POST['body']);

        $this->redirectTo('/notes');
    }

    private function getNoteById($id)
    {
        $noteDao = new DAOFactory();

        return $noteDao->getNoteDAO()->getNoteById($id);
    }

    private function authorizeNoteOwner($note)
    {
        authorize($note['user_id'] === $_SESSION['user']['id']);
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