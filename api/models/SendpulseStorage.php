<?php

namespace api\models;

use App\SendPulse\TokenStorage\TokenStorageException;
use App\SendPulse\TokenStorage\TokenStorageInterface;

class SendpulseStorage implements TokenStorageInterface
{
    /**
     * Сохраняет токен
     * @param string  $token Токен
     * @param string $clientId ID клиента
     * @param string $clientSecret Секрет клиента
     * @return void
     * @throws TokenStorageException
     */
    public function save(string $token, string $clientId, string $clientSecret)
    {
        // Здесь токен сохраняется в базе данных
    }

    /**
     * Загружает токен
     * @param string $clientId ID клиента
     * @param string $clientSecret Секрет клиента
     * @return array|null
     * @throws TokenStorageException
     */
    public function load(string $clientId, string $clientSecret)
    {
        // Здесь токен извлекается из базы данных
    }

    /**
     * Проверяет существуют ли токен для заданного ID клиента и секрета клиента
     * @param string $clientId ID клиента
     * @param string $clientSecret Секрет клиента
     * @return bool
     * @throws TokenStorageException
     */
    public function hasToken(string $clientId, string $clientSecret): bool
    {
        // Здесь проверяется существование токена в базе данных
    }
}