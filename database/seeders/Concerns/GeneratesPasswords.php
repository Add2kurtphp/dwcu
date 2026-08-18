<?php

namespace Database\Seeders\Concerns;

trait GeneratesPasswords
{
    protected function randomPassword(int $length = 10): string
    {
        // Avoids ambiguous characters (0/O, 1/l/I/o) so passwords are easy to read and type.
        $chars = 'ABCDEFGHJKLMNPQRSTUVWXYZabcdefghjkmnpqrstuvwxyz23456789';
        $out = '';
        for ($i = 0; $i < $length; $i++) {
            $out .= $chars[random_int(0, strlen($chars) - 1)];
        }
        return $out;
    }

    protected function logCredential(string $role, string $name, string $id, string $password): void
    {
        $line = str_pad($role, 10) . str_pad($name, 34) . str_pad($id, 18) . $password;
        file_put_contents(storage_path('app/seeded-credentials.txt'), $line . PHP_EOL, FILE_APPEND);

        if (isset($this->command)) {
            $this->command->line($line);
        }
    }
}
