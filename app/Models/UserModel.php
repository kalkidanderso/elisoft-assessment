<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = ['username', 'password_hash', 'full_name', 'role'];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    
    protected $validationRules = [
        'username' => 'required|min_length[3]|max_length[50]|is_unique[users.username,id,{id}]',
        'full_name' => 'required|min_length[3]|max_length[100]',
        'role' => 'required|in_list[admin,user]',
    ];
    
    protected $validationMessages = [
        'username' => [
            'required' => 'Username is required',
            'min_length' => 'Username must be at least 3 characters',
            'is_unique' => 'This username is already taken',
        ],
        'full_name' => [
            'required' => 'Full name is required',
        ],
    ];

    /**
     * Authenticate user with username and password
     */
    public function authenticate(string $username, string $password): ?array
    {
        $user = $this->where('username', $username)->first();
        
        if (!$user) {
            return null;
        }
        
       // Verify password
        if (password_verify($password, $user['password_hash'])) {
            return $user;
        }
        
        return null;
    }

    /**
     * Create new user with hashed password
     */
    public function createUser(array $data): bool
    {
        if (isset($data['password'])) {
            $data['password_hash'] = password_hash($data['password'], PASSWORD_BCRYPT);
            unset($data['password']);
        }
        
        return $this->insert($data);
    }

    /**
     * Update user password
     */
    public function updatePassword(int $userId, string $newPassword): bool
    {
        $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
        return $this->update($userId, ['password_hash' => $hashedPassword]);
    }
}
