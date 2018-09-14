<?php

/**
 *
 * 第一部分：
 * @note: 返回：
 *      1. 定义个授权方式 （ 这里默认 给出的是 api key ， 具体的其他授权方式比如  http、oauth2 自行查找）
 *      2. 对某一个请求进行授权
 *
 * @OA\SecurityScheme(
 *      type="apiKey",
 *      in="header",
 *      securityScheme="api_key",
 *      name="Authorization",
 *      description="这是一个认证，比如jwt认证",
 * )
 *
 * @OA\Get(
 *      path="/path",
 *      tags={"pet"},
 *      summary="simple summary of this api request",
 *      description=" A detailed description about  this api how to be using",
 *      operationId="addPet",
 *
 *      @OA\Parameter(name="username", in="query", @OA\Schema(type="string"), required=true, example="melody", description="姓名"),
 *      @OA\Response(response=400, description="Invalid status value"),
 *     security={{"api_key": {}}}
 * )
 *
 *
 *
 */

