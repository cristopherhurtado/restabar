<?php


namespace App\Enums;


enum Role: string {
    case Admin = 'admin';
    case Frontline = 'frontline';
    case Kitchen = 'kitchen';
    case Manager = 'manager';
    case Customer = 'customer';
}