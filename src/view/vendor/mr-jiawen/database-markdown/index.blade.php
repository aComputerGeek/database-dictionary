<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <title>数据库markdown工具</title>

    <!-- Bootstrap -->
    <link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://cdn.bootcss.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
        #app {
            margin: 0 5%;
            width: 90%;
        }
    </style>

</head>
<body>
<div id="app">
    <div class="page-header">
        <h1>数据库 字典工具
            <small> 当然也可以
                <a href="#">
                    <button type="button" class="btn btn-success  btn-sm get-file">生成markdown文件</button>
                </a>
                (<a href="#" data-toggle="modal" data-target="#myModal">模块管理</a>)
            </small>
        </h1>

        <div>
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" id="nav-tab" role="tablist">
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
                <br>
                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingOne">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne"
                                   aria-expanded="true" aria-controls="collapseOne">
                                    Collapsible Group Item #1
                                </a>
                            </h4>
                        </div>
                        <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel"
                             aria-labelledby="headingOne">
                            <div class="panel-body">
                                Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad
                                squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck
                                quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it
                                squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica,
                                craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur
                                butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth
                                nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">模块管理</h4>
            </div>
            <div class="modal-body">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        以下是对数据库模块进行管理，可以对其进行CURD(公共库是不能进行管理)
                        <span class="pull-right "><a href="#" class="module-add">新增</a></span>
                    </div>
                    <table class="table table-striped"></table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>
<script>
    $(function () {
        // 设置全局的 ajax
        $.ajaxSetup({
            url: ".",
            type: "POST",
            dataType: 'JSON',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var database = {
            // 模块划分
            modules: [{
                created_at: '',
                father_id: 0,
                id: 0,
                name: "公共库",
                order: 0,
                type: 1,
                updated_at: "",
                active: true
            }],
        };

        // 获取模块数量
        function getModule() {
            $.ajax({
                data: {url: 'modules'},
                success: function (response) {
                    database.modules = [{
                        created_at: '',
                        father_id: 0,
                        id: 0,
                        name: "公共库",
                        order: 0,
                        type: 1,
                        updated_at: "",
                        active: true
                    }];
                    if (response.ServerNo == 200) {
                        for (var i = 0; i < response.ServerData.length; i++) {
                            response.ServerData[i].active = false;
                            database.modules[i + 1] = response.ServerData[i];
                        }
                    }
                    render();
                },
                error: function () {
                    alert('error!!!');
                }
            });
        }

        getModule();

        function render() {
            // 渲染nav tab
            $("#nav-tab").empty();
            database.modules.map(function (e) {
                $("#nav-tab").append(`<li role="presentation" data-id="${e.id}" class="${e.active ? 'active' : ''}">
                                        <a href="#nav-tab-${e.id}"  role="tab" data-toggle="tab">${e.name}</a>
                                      </li>`);
            });

            // 渲染模态框的的table
            $("#myModal table").empty();
            $("#myModal table").append(`<tr><th>id号</th><th>名称</th><th>序号</th><th>管理</th></tr>`);
            database.modules.map(function (e) {
                $("#myModal table").append(`<tr data-id="${e.id}">
                    <td>${e.id}</td>
                    <td><input type="text" name="name" value="${e.name}"></td>
                    <td><input type="number" name="order" value="${e.order}"></td>
                    <td><a class="module-update">修改</a>&nbsp;&nbsp;&nbsp;&nbsp;<a class="module-del">删除</a></td>
                </tr>`);
            })

            // 渲染 内容区块
            var id;
            database.modules.map(function (e) {
                if (e.active) {
                    id = e.id
                }
            });
            console.log("此刻的模块id值为" + id);
            $.ajax({
                data: {url: 'getContain', id: id},
                success: function (response) {
                    console.log(response);
                    renderContain(response.ServerData.tableInfo, response.ServerData.moduleInfo)
                },
                error: function () {
                    alert('error!!!');
                }
            });

            var database_out = database;

            function renderContain(database, moduleInfo) {
                console.log("此刻模块的所有的表信息为：", database, moduleInfo);
                $("#accordion").empty();
                for (var i = 0; i < database.length; i++) {
                    //获取排序值
                    var order = 0;
                    for (var j = 0; j < moduleInfo.length; j++) {
                        if (database[i].TABLE_NAME == moduleInfo[j].name) {
                            order = moduleInfo[j].order
                        }
                    }
                    $("#accordion").append(`
                    <div class="panel panel-default" data-table_name="${database[i].TABLE_NAME}">
                        <div class="panel-heading" role="tab" id="heading-${database[i].TABLE_NAME}" style="display: flex;justify-content: space-between">
                            <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
                                   href="#collapse-${database[i].TABLE_NAME}" aria-expanded="false" aria-controls="collapse-${database[i].TABLE_NAME}">
                                    ${ i + 1 + '. ' + database[i].TABLE_NAME}&nbsp;&nbsp;&nbsp;&nbsp;${database[i].TABLE_COMMENT}
                                </a>
                            </h4>
                            <div>
                                ${ id == 0 ? ' <select name="father_id" ></select>' : ''}
                                ${ id != 0 ? ' <input type="number" name="order" value="' + order + '" style="width: 50px">' : ''}
                                ${ id != 0 ? ' <a href="#" class="delete"> 删除</a>' : ''}
                            </div>
                        </div>
                        <div id="collapse-${database[i].TABLE_NAME}" class="panel-collapse collapse" role="tabpanel"
                             aria-labelledby="heading-${database[i].TABLE_NAME}">
                            <div class="panel-body">
                                <table class="table table-hover">

                                </table>
                            </div>
                        </div>
                    </div>`);
                }
                $("[name='select_module']").empty();
                database_out.modules.map(function (e) {
                    $("[name='father_id']").append(`<option value="${e.id}">${e.name}</option>`);
                });

            }

        }

        // 生成文件
        $(".get-file").click(function () {
            $.ajax({
                data: {url: 'getFile'},
                success: function (response) {
                    alert('success');
                },
                error: function () {
                    alert('error!!!');
                }
            });
        });

        // 新添一个模块
        $("#accordion").on("focusout", "[name='father_id']", function () {
            var father_id = $(this).val();
            var table_name = $(this).parents(".panel").data("table_name");
            if(father_id == 0){
                return ;
            }
            $.ajax({
                type: 'get',
                data: {url: 'updateTableInfo', name: table_name, father_id: father_id},
                success: function (response) {
                    alert('success');
                    render();
                },
                error: function () {
                    alert('error!!!');
                }
            });
        })

        // 修改一个表所在模块的信息
        $("#accordion").on("focusout", "[name='order']", function () {
            var order = $(this).val();
            var table_name = $(this).parents(".panel").data("table_name");

            $.ajax({
                type: 'get',
                data: {url: 'updateTableInfo', name: table_name, order: order},
                success: function (response) {
                    alert('success')
                    render();
                },
                error: function () {
                    alert('error!!!');
                }
            });
        })

        // 删除一个表所在模块的信息
        $("#accordion").on("click", ".delete", function () {
            var table_name = $(this).parents(".panel").data("table_name");
            $.ajax({
                type: 'get',
                data: {url: 'updateTableInfo', name: table_name, delete: true},
                success: function (response) {
                    alert('success')
                    render();
                },
                error: function () {
                    alert('error!!!');
                }
            });
        })

        // 获取表字段并且填充
        $("#accordion").on('shown.bs.collapse', function () {
            var table_name = $(this).find("[aria-expanded='true']").parents('.panel').data('table_name');

            $.ajax({
                type: 'get',
                data: {url: 'getTableInfo', name: table_name},
                success: function (response) {
                    console.log("获取了表的字段信息:", response);
                    $(`#collapse-${table_name} .table`).empty().append(`<tr><th>Field</th><th>Type</th><th>Null</th><th>Default</th><th>Comment</th><th>Key</th></tr>`);
                    for (var i = 0; i < response.ServerData.length; i++) {
                        $(`#collapse-${table_name} .table`).append(`<tr>
                                    <td>${response.ServerData[i].Field}</td>
                                    <td>${response.ServerData[i].Type}</td>
                                    <td>${response.ServerData[i].Null}</td>
                                    <td>${response.ServerData[i].Default}</td>
                                    <td>${response.ServerData[i].Comment}</td>
                                    <td>${response.ServerData[i].Key}</td>
                                </tr>`);
                    }

                },
                error: function () {
                    alert('error!!!');
                }
            });

        });


        // 选择一个模块
        $("#nav-tab").on("click", "li", function () {
            var id = $(this).data('id');
            for (var i = 0; i < database.modules.length; i++) {
                database.modules[i].active = false;
                if (database.modules[i].id == id) {
                    database.modules[i].active = true;
                }
            }
            render();
        });

        // 添加一个模块
        $("#myModal").on("click", '.module-add', function () {
            $.ajax({
                data: {url: 'modulesAdd'},
                success: function (response) {
                    getModule();
                },
                error: function () {
                    alert('error!!!');
                }
            });
        });
        // 删除一个模块
        $("#myModal").on("click", '.module-del', function () {
            $.ajax({
                data: {url: 'modulesDel', id: $(this).parents('tr').data('id')},
                success: function (response) {
                    getModule();
                },
                error: function () {
                    alert('error!!!');
                }
            });
        });
        // 修改一个模块
        $("#myModal").on("click", '.module-update', function () {
            $.ajax({
                data: {
                    url: 'modulesUpdate',
                    id: $(this).parents('tr').data('id'),
                    name: $(this).parents('tr').find('[name="name"]').val(),
                    order: $(this).parents('tr').find('[name="order"]').val(),
                },
                success: function (response) {
                    alert("success");
                    getModule();
                },
                error: function () {
                    alert('error!!!');
                }
            });
        });

    });
</script>