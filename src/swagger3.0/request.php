<?php

/**
 * #################################################################################
 * 第一部分：
 * @note: 发送请求部分 的注意事项 ：
 *      1. 请求方式： Get、Post、Put、Delete 等
 *      2. 路径 ： 必填
 *      3. 剩余的 summary、description 对api 描述的接口是必填的
 *      4. operationId 它必须唯一，如果不唯一也不会报错， 但是可以看到折叠窗 会同时打开多个
 * #################################################################################
 */

/**
 * #################################################################################
 * 第二部分 ：
 * @note： 请求参数的传递方式 (如果参数在 path 或者 query 中)
 *      2.1. 当参数在 query中的表示方式
 *      2.2. 当参数在 path中的表示方式
 *      2.3. 当参数是一个数组的时候
 *          * 没有默认值
 *          * 参数的名称 为数组形式 name="username[]"
 *      2.4. 当一个参数是来自某一个数据模型的时候 schema
 *          *  没有默认值
 *          * 在发送http 请求的时候，它会自动的散开，而最外层的 name (比如 username) 并不存在请求中，只是为了说明而已
 * #################################################################################
 * 2.1 当参数是query string 的时候
 * @OA\Get(
 *      path="/path",
 *      tags={"pet"},
 *      summary="simple summary of this api request",
 *      description=" A detailed description about  this api how to be using",
 *      operationId="addPet",
 *
 *      @OA\Parameter(name="username", in="query", @OA\Schema(type="string"), required=true, example="melody", description="姓名"),
 *      @OA\Response(response=400, description="Invalid status value"),
 * )
 *
 * 2.2 当参数在path 的时候
 * @OA\Get(
 *      path="/user/{username}",
 *      tags={"pet"},
 *      summary="simple summary of this api request",
 *      description=" A detailed description about  this api how to be using",
 *      operationId="addPet",
 *
 *      @OA\Parameter(name="username", in="path",  @OA\Schema(type="string"), required=true, example="melody", description="姓名"),
 *      @OA\Response(response=400, description="Invalid status value"),
 * )
 *
 *  2.3 当参数是某一个数组：(需要注意一点)
 *      * 没有默认值
 *      * 参数的名称 为数组形式 name="username[]"
 * @OA\Get(
 *      path="/path",
 *      tags={"pet"},
 *      summary="simple summary of this api request",
 *      description=" A detailed description about  this api how to be using",
 *      operationId="addPet",
 *
 *      @OA\Parameter(name="username[]", in="query", @OA\Schema(type="array", @OA\Items(type="string")), required=true, description="姓名"),
 *      @OA\Response(response=400, description="Invalid status value"),
 * )
 *
 *  2.4 当一个参数是来自某一个数据模型的时候 schema
 *      *  没有默认值
 *      * 在发送http 请求的时候，它会自动的散开，而最外层的 name (比如 username) 并不存在请求中，只是为了说明而已
 *
 * @OA\Get(
 *      path="/path",
 *      tags={"pet"},
 *      summary="simple summary of this api request",
 *      description=" A detailed description about  this api how to be using",
 *      operationId="addPet",
 *
 *      @OA\Parameter(name="username", in="query", @OA\Schema(ref="#/components/schemas/UserModel"), required=true, description="姓名"),
 *      @OA\Response(response=400, description="Invalid status value"),
 * )
 *
 */

/**
 *
 * #################################################################################
 * 第三部分 ：
 * @note： 请求参数的传递方式 (如果参数在 body 中)
 *      3.1. 当参数在 body 中的表示方式
 *      3.2  当参数在 body 中以数组方式呈现
 *      3.3  当参数在body 中需要嵌套其他字段时候, 当（这个字段是一个对象）
 *      3.4  当参数在body 中需要嵌套其他字段时候, 当（这个字段是一个数组 , 数据里面是schema）
 *      3.5  当参数在body 中需要嵌套其他字段时候, 当（这个字段是一个数组 ,数组里面是标量）
 * #################################################################################
 *
 * 3.1. 当参数在 body 中的表示方式
 * @OA\Post(
 *      path="/path",
 *      tags={"pet"},
 *      summary="simple summary of this api request",
 *      description=" A detailed description about  this api how to be using",
 *      operationId="addPet",
 *
 *      @OA\RequestBody(
 *          @OA\JsonContent(ref="#/components/schemas/UserModel"),
 *          description="this is a user model schema",
 *          required=true,
 *     ),
 *      @OA\Response(response=400, description="Invalid status value"),
 * )
 *
 * 3.2 当参数在 body 中以数组方式呈现
 * @OA\Post(
 *      path="/path",
 *      tags={"pet"},
 *      summary="simple summary of this api request",
 *      description=" A detailed description about  this api how to be using",
 *      operationId="addPet",
 *
 *      @OA\RequestBody(
 *          @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/UserModel")),
 *          description="this is a user model schema",
 *          required=true,
 *     ),
 *      @OA\Response(response=400, description="Invalid status value"),
 * )
 *
 * 3.3  当参数在body 中需要嵌套其他字段时候, 当（这个字段是一个对象）
 * 3.4  当参数在body 中需要嵌套其他字段时候, 当（这个字段是一个数组 , 数据里面是schema）
 * 3.5  当参数在body 中需要嵌套其他字段时候, 当（这个字段是一个数组 ,数组里面是标量）
 * @OA\Post(
 *      path="/path",
 *      tags={"pet"},
 *      summary="simple summary of this api request",
 *      description=" A detailed description about  this api how to be using",
 *      operationId="addPet",
 *
 *      @OA\RequestBody(
 *          @OA\JsonContent(
 *              allOf={
 *                  @OA\Schema(ref="#/components/schemas/UserModel"),
 *                  @OA\Schema(@OA\Property(property="classModel", ref="#/components/schemas/ClassModel")),
 *                  @OA\Schema(@OA\Property(property="teacherModel", type="array", @OA\Items(ref="#/components/schemas/TeacherModel"))),
 *                  @OA\Schema(@OA\Property(property="book", type="array", @OA\Items(type="integer",example=1))),
 *              },
 *          ),
 *          description="this is a user model schema",
 *          required=true,
 *     ),
 *      @OA\Response(response=400, description="Invalid status value"),
 * )
 *
 *
 */