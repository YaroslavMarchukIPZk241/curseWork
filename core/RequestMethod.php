<?php
namespace core;

class RequestMethod
{
    protected array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function __get($name)
    {
        return $this->data[$name] ?? null;
    }

    public function all(): array
    {
        return $this->data;
    }
}
