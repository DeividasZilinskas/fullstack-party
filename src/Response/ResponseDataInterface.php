<?php

namespace App\Response;

/**
 * Interface ResponseDataInterface
 */
interface ResponseDataInterface
{
    /**
     * Creates array for response
     *
     * @return array
     */
    public function getResponseArray(): array;
}
