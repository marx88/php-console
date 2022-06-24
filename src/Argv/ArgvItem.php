<?php

declare(strict_types=1);

namespace Marx\Console\Argv;

/**
 * 命令行参数Item类.
 */
class ArgvItem
{
    /**
     * Key.
     */
    private string $key = '';

    /**
     * Value.
     */
    private string $value = '';

    /**
     * 匹配.
     */
    private bool $matched = false;

    /**
     * 重置.
     */
    public function reset(): void
    {
        $this->key = '';
        $this->value = '';
        $this->matched = false;
    }

    /**
     * 设置Key.
     *
     * @return static
     */
    public function setKey(string $key)
    {
        $this->key = $key;

        return $this;
    }

    /**
     * 获取Key.
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * 是否填充命令行参数.
     */
    public function isFill(): bool
    {
        return '' !== $this->key;
    }

    /**
     * 设置Value.
     *
     * @return static
     */
    public function setValue(string $value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * 获取Value.
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * 设置匹配.
     *
     * @return static
     */
    public function setMatched(bool $matched)
    {
        $this->matched = $matched;

        return $this;
    }

    /**
     * 获取匹配.
     */
    public function isMatched(): bool
    {
        return $this->matched;
    }
}
