<?php

namespace dao;
use Core\Database;


interface INotesDao
{
    public function getNotes($idUser);
    public function getNoteById( $idNote);
    public function createNote($idUser , $body);
    public function updateNote($id,$body);
    public function deleteNote($id);

}