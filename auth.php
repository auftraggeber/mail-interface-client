<?php
namespace de\langner_dev\mail;

abstract class IAuthManager {
    private static ?IAuthManager $shared = null;

    public static function setAuthManager(IAuthManager $m): void  {
        self::$shared = $m;
    }

    public static function shared(): IAuthManager {
        return self::$shared ?? new NullAuthManager();
    }

    public function getAuthHeaderName(): string {
        return "Authorization";
    }

    public abstract function getAuthKey(): string;
}

final class NullAuthManager extends IAuthManager {
    public function getAuthKey(): string
    {
        return "Bearer ";
    }
}

final class DefaultAuthManager extends IAuthManager {
    private string $header_name = "Authorization";
    private string $auth_key;

    public function __construct(string $auth_key)
    {
        $this->auth_key = $auth_key;
    }

    public function setAuthHeaderName(string $name): void {
        $this->header_name = $name;
    }

    public function getAuthKey(): string
    {
        return $this->auth_key;
    }

    public function getAuthHeaderName(): string
    {
        return $this->header_name;
    }
}
?>