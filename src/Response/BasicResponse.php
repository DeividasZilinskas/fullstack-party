<?php

namespace App\Response;

/**
 * Class BasicResponse
 */
class BasicResponse implements ResponseDataInterface
{
    /**
     * @var mixed
     */
    private $data;
    /**
     * Creates array for response
     *
     * @return array
     */
    public function getResponseArray(): array
    {
        $response['data'] = [];

        if (!is_null($this->data)) {
            $response['data'] = $this->data;
        }

        return $response;
    }

    /**
     * @param mixed $data
     *
     * @return BasicResponse
     */
    public function setData($data): BasicResponse
    {
        $this->data = $data;

        return $this;
    }
}
