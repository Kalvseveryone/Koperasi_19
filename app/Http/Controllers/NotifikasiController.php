<?php
namespace App\Models;

use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notification extends DatabaseNotification
{
    use HasFactory;

    protected $keyType = 'string';  // Agar menggunakan UUID sebagai key
    public $incrementing = false;   // Menonaktifkan auto increment
}
