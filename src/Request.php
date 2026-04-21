<?php

namespace App;

class Request
{
  private string $method;
  private string $uri;
  private array $query;
  private array $post;
  private array $cookie;
  private array $server;
  private array $routeParams = [];

  public function __construct()
  {
    $this->method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
    $this->uri = $this->parseUri();
    $this->query = $_GET;
    $this->post = $_POST;
    $this->cookie = $_COOKIE;
    $this->server = $_SERVER;
  }

  private function parseUri(): string
  {
    $uri = $_SERVER['REQUEST_URI'] ?? '/';

    // Remove query string
    if (($pos = strpos($uri, '?')) !== false) {
      $uri = substr($uri, 0, $pos);
    }

    // Remove trailing slash except for root
    if ($uri !== '/' && str_ends_with($uri, '/')) {
      $uri = rtrim($uri, '/');
    }

    return $uri;
  }

  public function getMethod(): string
  {
    return $this->method;
  }

  public function getUri(): string
  {
    return $this->uri;
  }

  public function getQuery(?string $key = null, mixed $default = null): mixed
  {
    if ($key === null) {
      return $this->query;
    }
    return $this->query[$key] ?? $default;
  }

  public function getPost(?string $key = null, mixed $default = null): mixed
  {
    if ($key === null) {
      return $this->post;
    }
    return $this->post[$key] ?? $default;
  }

  public function getCookie(?string $key = null, mixed $default = null): mixed
  {
    if ($key === null) {
      return $this->cookie;
    }

    return $this->cookie[$key] ?? $default;
  }

  public function getHeader(string $name, mixed $default = null): mixed
  {
    $serverKey = 'HTTP_' . strtoupper(str_replace('-', '_', $name));

    if ($name === 'Content-Type') {
      $serverKey = 'CONTENT_TYPE';
    } elseif ($name === 'Content-Length') {
      $serverKey = 'CONTENT_LENGTH';
    }

    return $this->server[$serverKey] ?? $default;
  }

  public function input(string $key, mixed $default = null): mixed
  {
    return $this->post[$key] ?? $this->query[$key] ?? $default;
  }

  public function isPost(): bool
  {
    return $this->method === 'POST';
  }

  public function isGet(): bool
  {
    return $this->method === 'GET';
  }

  public function isAjax(): bool
  {
    return isset($this->server['HTTP_X_REQUESTED_WITH'])
      && strtolower($this->server['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
  }

  public function setRouteParams(array $params): void
  {
    $this->routeParams = $params;
  }

  public function getRouteParam(string $key, mixed $default = null): mixed
  {
    return $this->routeParams[$key] ?? $default;
  }

  public function getRouteParams(): array
  {
    return $this->routeParams;
  }
}
