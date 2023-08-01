<?php

class User extends Model {
    protected $table = "users";

    protected $allowedColumns = [
        'name',
        'email',
    ];
}