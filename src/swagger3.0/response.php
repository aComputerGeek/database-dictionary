<?php

/**
 *
 * 第一部分：
 * @note: 返回：
 *      1. 非200 的返回
 *      2. 200 的返回内容, 其写法与 request body 一样
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
 *      @OA\Response(
 *          response=200,
 *          description="successful operation",
 *          @OA\JsonContent(
 *              allOf={
 *                  @OA\Schema(ref="#/components/schemas/UserModel"),
 *                  @OA\Schema(@OA\Property(property="classModel", ref="#/components/schemas/ClassModel")),
 *                  @OA\Schema(@OA\Property(property="teacherModel", type="array", @OA\Items(ref="#/components/schemas/TeacherModel"))),
 *                  @OA\Schema(@OA\Property(property="book", type="array", @OA\Items(type="integer",example=1))),
 *              },
 *          ),
 *      )
 * )
 *
 *
 *
 *
 */

