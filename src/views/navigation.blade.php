<div>
    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active">
            <a href="#" class="text-success" role="tab" data-toggle="tab" @click="selectNavigation()">
                全局库（未被分配）
            </a>
        </li>
        <template v-for="(item,key) in navigation">
            <li role="presentation">
                <a href="#" class="text-success" role="tab" data-toggle="tab" @click="selectNavigation(item.id)">
                    @{{ item.title }}
                </a>
            </li>
        </template>
    </ul>
</div>