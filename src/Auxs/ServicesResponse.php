<?php

namespace Cirel\LaravelBasicsAuxs\Auxs;

use Exception;
use Log;
use function App\Auxs\config;

abstract class ServicesResponse
{

    protected bool $ok;
    protected int $status;
    protected string $messageCode;
    protected string $message;
    protected string $title;
    protected mixed $data;

    /**
     * @throws Exception
     */
    public function __construct(int $status)
    {
        $this->setStatus($status);
        $this->setTitle('');
        $this->setOk();
    }

    /**
     * Retorna true si el status es menor a 400 y mayor o igual a 200
     * @throws Exception
     */
    public function itsOk(): bool
    {
        return $this->ok;
    }

    /**
     * Define el valor de ok en función del status
     * @throws Exception
     */
    protected function setOk(bool|null $state = null): void
    {
        $this->ok = $state !== null ? $state : $this->getStatus() < 400 && $this->getStatus() >= 200;
    }

    /**
     * Retorna el HTTP code de la respuesta
     * @return int
     * @throws Exception
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * Define el HTTP code de la respuesta
     * @param int $status
     */
    protected function setStatus(int $status): void
    {
        $this->status = $status;
    }

    /**
     * Retorna el código de error de la respuesta
     * @return string
     */
    public function getMessageCode(): string
    {
        return $this->messageCode;
    }

    /**
     * Define el código de error de la respuesta
     * @param string|int $errorCode
     * @throws Exception
     */
    protected function setMessageCode(string|int $errorCode): void
    {
        if ( $errorCode !== '') {
            $this->messageCode = $errorCode;
        }

        if (!isset($errorCode) || $errorCode == '') {
            $this->messageCode = $this->itsOk() ? 'REQUEST_SUCCESSFULLY' : 'INTERNAL_SERVICE_ERROR';
        }
    }

    /**
     * Retorna el título de la respuesta
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Define el título de la respuesta
     * @param string $title
     * @throws Exception
     */
    protected function setTitle(string $title): void
    {
            $this->title = $title;
    }

    /**
     * Retorna el mensaje de la respuesta
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * Define el mensaje de la respuesta
     * @param string $message
     * @throws Exception
     */
    protected function setMessage(string $message): void
    {
        if ( $message !== '') {
            $this->message = $message;
        }

        if (!isset($message) || $message === '') {
           $this->message = $this->itsOk() ? 'Successful request' : 'Internal service error, try again';
        }
    }

    /**
     * Retorna los datos de la respuesta
     * @return mixed
     */
    public function getData(): mixed
    {
        return $this->data;
    }

    /**
     * Define los datos de la respuesta
     * @param array $data
     */
    public function setData(array $data): void
    {
        $this->data = $data;
    }


    /**
     * Retorna un objeto con los datos seteados en data
     * @return object
     * @throws Exception
     */
    public function dataToObject(): object
    {
        return (object)$this->data;
    }

    /**
     * Retorna un JSON string con los datos en data
     * @return string
     */
    public function dataToJson(): string
    {
        return json_encode($this->data);
    }

    public function getSuccessMessage(): SuccessfulMessage
    {
        return new SuccessfulMessage($this->getMessage(), $this->getMessageCode() );
    }

    public function getErrorMessage(): ErrorMessage
    {
        return new ErrorMessage($this->getMessage(), $this->getMessageCode(), $this->getTitle());
    }

    protected function  convertToArray(mixed $data): array {
        return match (true) {
            is_array($data) => $data,
            is_null($data) => [],
            default => (array)$data
        };
    }

    protected function logginResponse(string | null $traceId = null, string $channel, string $responseClassName = ''): void
    {
        if (config('app.logging_enabled')) {
            if ($this->itsOk()) {
                Log::channel($channel)->info($responseClassName, [
                    'traceId' => $traceId,
                    'isOk' => $this->itsOk(),
                    'statusCode' => $this->getStatus(),
                    'messageCode' => $this->getMessageCode(),
                    'message' => $this->getMessage(),
                    'title' => $this->getTitle(),
                    'data' => $this->getData(),
                ]);
            } else {
                Log::channel($channel)->error($responseClassName, [
                    'traceId' => $traceId,
                    'isOk' => $this->itsOk(),
                    'statusCode' => $this->getStatus(),
                    'messageCode' => $this->getMessageCode(),
                    'message' => $this->getMessage(),
                    'title' => $this->getTitle(),
                    'data' => $this->getData(),
                ]);
            }
        }
    }

    /**
     * Este método debe definirse en relación
     * con la estructura de la respuesta de errores
     * del servicio en cuestión
     * @throws Exception
     */
    abstract protected function handlerErrors(mixed $data): void;

    /**
     * Este método debe definirse en relación
     * con la estructura de la respuesta del
     * servicio en cuestión
     * @throws Exception
     */
    abstract protected function handlerData(mixed $data): void;

}
