<template>
    <div class="app-container">
        <!-- 搜索 -->
        <el-form :inline="true" :model="query_from" class="demo-form-inline">
            <el-form-item label="创建时间">
                <el-date-picker size="mini"                         clearable
                        v-model="query_from.time_range"
                        type="datetimerange"
                        format="yyyy-MM-dd HH:mm:ss"
                        value-format="yyyy-MM-dd HH:mm:ss"
                        range-separator="至"
                        start-placeholder="开始日期"
                        end-placeholder="结束日期">
                </el-date-picker>
            </el-form-item>
            <el-form-item>
                <el-button  size="mini" type="primary" @click="listQuery">查询</el-button>
            </el-form-item>
        </el-form>
        <!--数据-->
        <el-table
                :data="table.list"
                height="550"
                border
                size="mini"
                style="width: 100%">

            <el-table-column label="商品名" prop="goods_name"></el-table-column>
            <el-table-column label="主图" width="120">
                <template slot-scope="scope">
                    <el-image :src="scope.row.main_image_url"
                              style="width: 100px;height: 40px"
                              :preview-src-list="[scope.row.main_image_url]"
                              class="avatar">
                    </el-image>
                </template>
            </el-table-column>
            <el-table-column
                    prop="sort"
                    label="排序"
                    width="80">
            </el-table-column>
            <el-table-column label="状态" width="140">
                <template slot-scope="scope">
                    <el-switch
                            v-model="scope.row.is_enabled"
                            active-text="上架"
                            :active-value="1"
                            :inactive-value="0"
                            @change="switchEnabled(scope.row)"
                            inactive-text="下架">
                    </el-switch>
                </template>
            </el-table-column>

            <el-table-column label="创建时间">
                <template slot-scope="scope">
                    {{ scope.row.create_time}}
                </template>
            </el-table-column>
            <el-table-column label="操作" width="120">
                <template slot-scope="scope">
                    <router-link :to="'/goods/create?id='+scope.row.id">
                        <el-link type="success">编辑</el-link>
                    </router-link>

                    <el-link type="warning" @click="deleteGoods(scope.row,false)">删除</el-link>
                </template>
            </el-table-column>
        </el-table>
    </div>

</template>

<script>
    import request from '@/utils/jsonrequest'

    export default {
        name: 'List',
        data() {
            return {
                dialogVisible: false,
                table: {
                    list: []
                },
                total: 0,
                query_from: {
                    username: '',
                    time_range: [],
                },
                params: {
                    position: {},
                },
            }
        },
        created() {
            this.listQuery()
        },
        methods: {
            deleteGoods(row){
                const _this = this

                this.$confirm('此操作将永久删除, 是否继续?', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning'
                }).then(() => {
                    request({
                        url: '/admin/goods/delete',
                        method: 'post',
                        data: row
                    }).then(function (res) {
                        if (res.code === 10000) {
                            _this.$message.success('操作成功')
                            _this.listQuery()
                            return
                        }
                        _this.$message.error('操作失败')
                    })
                }).catch(() => {
                    this.$message({
                        type: 'info',
                        message: '已取消删除'
                    });
                });
            },
            listQuery() {
                const _this = this
                request({
                    url: '/admin/goods/list',
                    method: 'post',
                    data: _this.query_from
                }).then(function (res) {
                    console.log(res.data)
                    _this.table.list = res.data.data
                    _this.total = res.data.total
                })
            },
            switchEnabled: function (row) {
                const _this = this
                request({
                    url: '/admin/goods/enable',
                    method: 'post',
                    data: row
                }).then(function (res) {
                    if (res.code === 10000) {
                        _this.$message.success('操作成功')
                        row.is_enabled = res.data.is_enabled
                        return
                    }
                    _this.$message.error('操作失败')
                })
            },
        }
    }
</script>
<style rel="stylesheet/scss" lang="scss">
    .text-red {
        color: red;
        cursor: pointer;
    }

    .text-green {
        color: green;
        cursor: pointer;
    }
</style>
