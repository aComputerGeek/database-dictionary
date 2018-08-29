<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

    {{--如果是 全局公共厂库--}}

    <template v-for="(item,key) in plane.table">
        <div class="panel panel-success">
            <div class="panel-heading" style="padding: 7px 15px">
                <div class="row">
                    <div class="col-xs-10">
                        <h4 class="panel-title" style="line-height: 30px">
                            <a role="button" href="javascript:" @click="tablePlaneIsCollapsed(key)">
                                @{{ key + 1 }} . @{{ item.tableName }} --@{{ item.tableComment }}</a>
                        </h4>
                    </div>
                    <div class="col-xs-2">
                        <template v-if="plane.navigation_id === 0">
                            <select class="form-control pull-right input-sm" v-model="item.moduleId"
                                    @change="tableAddToModule(item)">
                                <option v-for="option in navigation" :value="option.id">@{{ option.title }}
                                </option>
                            </select>
                        </template>
                        <template v-else>
                            <div class="col-xs-8  pull-right">
                                <input name="title" type="number" v-model="item.database_dictionary.order"
                                       @change="tableChangeOrder(item.database_dictionary)"
                                       class="form-control input-sm">
                            </div>
                        </template>
                    </div>
                </div>
            </div>
            <transition name="plane-fade">
                <div class="panel-body" v-show="item.tableIsClose !== true">
                    <table class="table table-hover">
                        <tr>
                            <th>Field</th>
                            <th>Type</th>
                            <th>Null</th>
                            <th>Key</th>
                            <th>Default</th>
                            <th>Extra</th>
                            <th>Comment</th>
                        </tr>
                        <template v-for="(value, key) in item.fields">
                            <tr>
                                <td>@{{ value.Field }}</td>
                                <td>@{{ value.Type }}</td>
                                <td>@{{ value.Null }}</td>
                                <td>@{{ value.Key }}</td>
                                <td>@{{ value.Default }}</td>
                                <td>@{{ value.Extra }}</td>
                                <td>@{{ value.Comment }}</td>
                            </tr>
                        </template>
                    </table>
                </div>
            </transition>
        </div>

    </template>
</div>