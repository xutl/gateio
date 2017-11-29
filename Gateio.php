<?php

namespace xutl\gateio;

use Psr\Http\Message\RequestInterface;

class Gateio
{
    /** @var array Configuration settings */
    private $config;

    /**
     * Gateio constructor.
     * @param array $config
     */
    public function __construct($config)
    {
        $this->config = [
            'accessKey' => '123456',
            'accessSecret' => '654321',
        ];
        foreach ($config as $key => $value) {
            $this->config[$key] = $value;
        }
    }

    /**
     * Called when the middleware is handled.
     *
     * @param callable $handler
     *
     * @return \Closure
     */
    public function __invoke(callable $handler)
    {
        return function ($request, array $options) use ($handler) {
            $request = $this->onBefore($request);
            return $handler($request, $options);
        };
    }

    /**
     * 请求前调用
     * @param RequestInterface $request
     * @return RequestInterface
     */
    private function onBefore(RequestInterface $request)
    {
        $body = $request->getBody()->getContents();
        //签名
        $signature = hash_hmac('sha512', $body, $this->config['accessSecret']);
        /** @var RequestInterface $request */
        $request = $request->withHeader('KEY', $this->config['accessKey']);
        $request = $request->withHeader('SIGN', $signature);
        return $request;
    }
}