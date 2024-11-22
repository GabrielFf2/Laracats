<?php

namespace dao;
interface INotesControllerDao
{
    public function create();
    public function destroy();
    public function edit();
    public function index();
    public function show();
    public function store();
    public function update();
}
