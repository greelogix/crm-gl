<?php
use App\Models\User;
use Illuminate\Support\Facades\Auth;

if (!function_exists('auth_user')) {
    function auth_user(): ?User
    {
        return Auth::user();
    }
}
