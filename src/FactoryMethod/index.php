<?php

namespace Patterns\FactoryMethod;

interface SocialNetworkConnector
{
    public function logIn(): void;

    public function logOut(): void;

    public function createPost($content): void;
}

class FacebookConnector implements SocialNetworkConnector
{
    private $login, $password;

    public function __construct(string $login, string $password)
    {
        $this->login = $login;
        $this->password = $password;
    }

    public function logOut(): void
    {
        echo "logout\n";
    }

    public function createPost($content): void
    {
        echo "post to facebook\n";
    }

    public function logIn(): void
    {
        echo "login\n";
    }
}

class LinkedInConnector  implements SocialNetworkConnector
{
    private $email, $password;

    public function __construct(string $email, string $password)
    {
        $this->email = $email;
        $this->password = $password;
    }

    public function logIn(): void
    {
        echo "login with linkedin\n";
    }

    public function logOut(): void
    {
        echo "logout with linkedin\n";
    }

    public function createPost($content): void
    {
        echo "create post with linkedin\n";
    }
}


abstract class SocialNetworkPoster
{
    abstract public function getSocialNetwork(): SocialNetworkConnector;

    public function post($content): void
    {
        $network = $this->getSocialNetwork();

        $network->logIn();
        $network->createPost($content);
        $network->logOut();
    }
}

class FacebookPoster extends SocialNetworkPoster
{
    private $login, $password;

    public function __construct(string $login, string $password)
    {
        $this->login = $login;
        $this->password = $password;
    }

    public function getSocialNetwork(): SocialNetworkConnector
    {
        return new FacebookConnector($this->login, $this->password);
    }
}

class LinkedInPoster extends SocialNetworkPoster
{
    private $login, $password;

    public function __construct(string $login, string $password)
    {
        $this->login = $login;
        $this->password = $password;
    }

    public function getSocialNetwork(): SocialNetworkConnector
    {
        return new LinkedInConnector($this->login, $this->password);
    }
}

function clientCode(SocialNetworkPoster $creator)
{
    $creator->post("hello world");
    $creator->post("im rich");
}

clientCode(new FacebookPoster("username", "password"));
clientCode(new LinkedInPoster("username", "password"));
