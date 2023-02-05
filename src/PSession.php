<?php

namespace Atakde\PSession;

use Atakde\PSession\Exceptions\InvalidOption;

class PSession
{
    /**
     * @var array
     */
    private array $options = [];
    /**
     * @var array|string[]
     */
    private array $phpSessionValidOptions = [
        'save_path',
        'name',
        'save_handler',
        'auto_start',
        'gc_probability',
        'gc_divisor',
        'gc_maxlifetime',
        'serialize_handler',
        'cookie_lifetime',
        'cookie_path',
        'cookie_domain',
        'cookie_secure',
        'cookie_httponly',
        'cookie_samesite',
        'use_strict_mode',
        'use_cookies',
        'use_only_cookies',
        'referer_check',
        'cache_limiter',
        'cache_expire',
        'use_trans_sid',
        'trans_sid_tags',
        'trans_sid_hosts',
        'sid_length',
        'sid_bits_per_character',
        'upload_progress.enabled',
        'upload_progress.cleanup',
        'upload_progress.prefix',
        'upload_progress.name',
        'upload_progress.freq',
        'upload_progress.min-freq',
        'lazy_write'
    ];

    /**
     * @param array $options
     * @throws InvalidOption
     */
    public function __construct(array $options = [])
    {
        // if includes non valid php session options
        foreach ($options as $key => $value) {
            if (!in_array($key, $this->phpSessionValidOptions)) {
                throw new InvalidOption($key);
            }
        }
        $this->options = $options;
    }

    /**
     * @return bool
     */
    public function start(): bool
    {
        return session_start($this->options);
    }

    /**
     * @return bool
     */
    public function destroy(): bool
    {
        return session_destroy();
    }

    /**
     *
     */
    public function clear(): void
    {
        session_unset();
    }

    /**
     * @return bool
     */
    public function regenerateId(): bool
    {
        return session_regenerate_id();
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return session_id();
    }

    /**
     * @param string $id
     */
    public function setId(string $id): void
    {
        session_id($id);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return session_name();
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        session_name($name);
    }

    /**
     * @return array
     */
    public function all(): array
    {
        return $_SESSION ?? [];
    }

    /**
     * @return bool
     */
    public function isStarted(): bool
    {
        return $this->getStatus() === PHP_SESSION_ACTIVE;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return session_status();
    }

    /**
     * @return bool
     */
    public function isNotStarted(): bool
    {
        return $this->getStatus() === PHP_SESSION_NONE;
    }

    /**
     * @return bool
     */
    public function isDestroyed(): bool
    {
        return $this->getStatus() === PHP_SESSION_DISABLED;
    }

    /**
     * @param string $key
     * @return mixed|null
     */
    public function __get(string $key)
    {
        return $this->get($key, null);
    }

    /**
     * @param string $key
     * @param $value
     */
    public function __set(string $key, $value): void
    {
        $this->set($key, $value);
    }

    /**
     * @param string $key
     * @param null $defaultValue
     * @return mixed|null
     */
    public function get(string $key, $defaultValue = null)
    {
        $keys = explode('.', $key);
        $session = $_SESSION;
        foreach ($keys as $key) {
            // allow both object and array access
            if (is_array($session) && isset($session[$key])) {
                $session = $session[$key];
            } elseif (is_object($session) && isset($session->$key)) {
                $session = $session->$key;
            } else {
                return $defaultValue;
            }
        }

        return $session ?? $defaultValue;
    }

    /**
     * @param string $key
     * @param null $value
     */
    public function set(string $key, $value = null): void
    {
        // both object and array access
        $keys = explode('.', $key);
        $session = &$_SESSION;
        foreach ($keys as $key) {
            if (is_array($session) && !isset($session[$key])) {
                $session[$key] = [];
            } elseif (is_object($session) && !isset($session->$key)) {
                $session->$key = [];
            }

            if (is_array($session)) {
                $session = &$session[$key];
            } elseif (is_object($session)) {
                $session = &$session->$key;
            }
        }

        $session = $value;
    }

    /**
     * @param string $key
     * @return bool
     */
    public function __isset(string $key): bool
    {
        return $this->has($key);
    }

    /**
     * @param string $key
     * @return bool
     */
    public function has(string $key): bool
    {
        return isset($_SESSION[$key]);
    }

    /**
     * @param string $key
     */
    public function __unset(string $key): void
    {
        $this->remove($key);
    }

    /**
     * @param string $key
     */
    public function remove(string $key): void
    {
        unset($_SESSION[$key]);
    }
}
