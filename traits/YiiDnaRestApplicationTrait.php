<?php

/**
 * YiiDnaRestApplicationTrait trait file.
 * Provides error handling for REST applications with proper responses.
 * Relies on the weavora/wrest library for the responses (https://github.com/weavora/wrest).
 */
trait YiiDnaRestApplicationTrait
{
    use YiiDnaWebApplicationTrait;

    /**
     * @var string The API response format, i.e. json or xml.
     */
    public $responseFormat = 'json';

    /**
     * @var array error/exception response object component configs.
     */
    public $responseDataObjects = array(
        'error' => array(
            'class' => 'YiiDnaRestResponseError'
        ),
        'exception' => array(
            'class' => 'YiiDnaRestResponseException'
        ),
    );

    /**
     * @var array additional headers returned when sending response.
     * @see YiiDnaRestApplicationTrait::sendResponse
     */
    public $responseHeaders = array(
        'Access-Control-Allow-Origin: *',
        'Access-Control-Allow-Headers: Authorization, Origin, Content-Type, Accept',
    );

    /**
     * @inheritdoc
     */
    public function displayError($code, $message, $file, $line)
    {
        $object = $this->getResponseDataObject('error');
        $object->init($code, $message, $file, $line);
        $this->sendResponse($object, $object->status);
    }

    /**
     * @inheritdoc
     */
    public function displayException($exception)
    {
        $object = $this->getResponseDataObject('exception');
        $object->init($exception);
        $this->sendResponse($object, $object->status);
    }

    /**
     * Creates the response data object specified by given name.
     * @param string $name the response data object name.
     * @return YiiDnaRestResponseError|YiiDnaRestResponseException the response data object.
     * @throws CException if the response data object cannot be created.
     */
    public function getResponseDataObject($name)
    {
        if (!isset($this->responseDataObjects[$name])) {
            throw new CException(sprintf('Failed to create response data object %s.', $name));
        }
        return Yii::createComponent($this->responseDataObjects[$name]);
    }

    /**
     * Getter for the REST response object.
     * @return WRestResponse
     */
    public function getResponse()
    {
        return WRestResponse::factory($this->responseFormat);
    }

    /**
     * Sends the API response to the client.
     * @param mixed $data the data to send as the response body.
     * @param int $statusCode the status code of the response.
     * @throws CHttpException if response component cannot be found.
     */
    public function sendResponse($data, $statusCode = 200)
    {
        $response = $this->getResponse();
        $response->setStatus($statusCode);
        $headers = array_merge($response->getHeaders(), $this->responseHeaders);
        foreach ($headers as $header) {
            header($header);
        }
        echo $response->setParams($data)->getBody();
    }
}
