<?php namespace Visiosoft\ConnectModule\Traits;

trait ApiReturnResponseTrait
{
    protected $schema = [
        'success' => true,
        'response' => [],
        'message' => '',
        'error_code' => 0
    ];

    public function sendResponse($data, $message = '')
    {
        $schema = $this->schema;
        $schema['response'] = $data;
        $schema['message'] = $message;
        return response($schema, 200);
    }

    public function sendError($message, $errorCode = 404, $data = [], $responseCode = 200)
    {
        $schema = $this->schema;
        $schema['success'] = false;
        $schema['response'] = $data;
        $schema['message'] = $message;
        $schema['error_code'] = $errorCode;
        return response($schema, $responseCode);
    }

    public function sendExceptionError(\Exception $e)
    {
        $schema['success'] = false;
        $schema['message'] = 'Server Error';
        $schema['error_code'] = 500;
        if (config('app.debug')) {
            $schema['message'] = $e->getMessage() . ' LINE: ' . $e->getLine();
            $schema['response'] = $e->getTrace();
        }
        return response($schema, 500);
    }
}
