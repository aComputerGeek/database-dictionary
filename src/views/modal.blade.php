<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
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
                        以下是对数据库模块进行管理
                    </div>
                    <table class="table table-striped text-center">
                        <tr>
                            <th class="text-center">序号 （ID）</th>
                            <th class="text-center">名称</th>
                            <th class="text-center">排序</th>
                            <th class="text-center">操作</th>
                        </tr>
                        <template v-for="(item,key) in navigation">
                            <tr>
                                <td>@{{ item.id }}</td>
                                <template v-if="item.is_edit==false">
                                    <td>@{{ item.title }}</td>
                                    <td>@{{ item.order }}</td>
                                </template>
                                <template v-else>
                                    <td class="form-group">
                                        <input name="title" v-model="item.title" class="form-control ">
                                    </td>
                                    <td class="form-group">
                                        <input type="number" v-model="item.order" name="order" class="form-control"
                                               placeholder="默认值为0">
                                    </td>
                                </template>
                                <td>
                                    <a class="btn btn-default btn-success" href="#" role="button"
                                       v-if="item.is_edit==false" @click="moduleChangeToEdit(key)">修改</a>
                                    <a class="btn btn-default btn-success" href="#" role="button" v-else
                                       @click="updateModule(key)">保存</a>
                                    <a class="btn btn-default btn-info" href="#" @click="deleteModule(item.id)"
                                       role="button">删除</a>
                                </td>
                            </tr>
                        </template>
                        <tr>
                            <td class="form-group">
                                <input class="form-control " disabled="disabled" placeholder="自动生成">
                            </td>
                            <td class="form-group">
                                <input name="title" v-model="form.modal.title" class="form-control ">
                            </td>
                            <td class="form-group">
                                <input type="number" v-model="form.modal.order" name="order" class="form-control"
                                       placeholder="默认值为0">
                            </td>
                            <td>
                                <a class="btn btn-default btn-success" href="#" @click="createModule" role="button">新增--提交</a>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>