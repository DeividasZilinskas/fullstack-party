<?php

namespace App\Model\Api\Login;

/**
 * Class AccessToken
 */
class AccessToken
{
    /**
     * @var string
     */
    private $code;
    /**
     * @var string
     */
    private $state;

    /**
     * @return string|null
     */
    public function getCode(): ?string
    {
        return $this->code;
    }

    /**
     * @param string|null $code
     *
     * @return AccessToken
     */
    public function setCode(string $code = null): AccessToken
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getState(): ?string
    {
        return $this->state;
    }

    /**
     * @param string|null $state
     *
     * @return AccessToken
     */
    public function setState(string $state = null): AccessToken
    {
        $this->state = $state;

        return $this;
    }
}
