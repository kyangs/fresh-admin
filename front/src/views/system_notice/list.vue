<template>
    <div class="app-container">
        <!-- 搜索 -->
        <el-form :inline="true" :model="query_from" class="demo-form-inline">
            <el-form-item label="创建人">
                <el-input v-model="query_from.username" placeholder="创建人" clearable></el-input>
            </el-form-item>
            <el-form-item label="时间">
                <el-date-picker
                        clearable
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
                <el-button type="primary" @click="listQuery">查询</el-button>
                <el-button type="primary" @click="saveNotice({},false)">新增</el-button>
            </el-form-item>
        </el-form>
        <!--数据-->
        <el-table
                :data="table.list"
                height="550"
                border
                style="width: 100%">

            <el-table-column label="标题" prop="title"></el-table-column>
            <el-table-column label="标签" width="80" prop="tag"></el-table-column>
            <el-table-column
                    prop="sort"
                    label="排序"
                    width="80">
            </el-table-column>
            <el-table-column label="状态" width="140">
                <template slot-scope="scope">
                    <el-switch
                            v-model="scope.row.is_enabled"
                            active-text="启用"
                            :active-value="1"
                            :inactive-value="0"
                            @change="switchEnabled(scope.row)"
                            inactive-text="禁用">
                    </el-switch>
                </template>
            </el-table-column>

            <el-table-column label="时间">
                <template slot-scope="scope">
                    {{ scope.row.start_time}}~{{ scope.row.end_time}}
                </template>
            </el-table-column>
            <el-table-column
                    prop="creator"
                    label="创建者"
                    width="80">
            </el-table-column>

            <el-table-column
                    prop="create_time"
                    label="创建日期"
                    width="160">
            </el-table-column>

            <el-table-column label="操作" width="120">
                <template slot-scope="scope">
                    <el-link type="success" @click="saveNotice(scope.row,false)">编辑</el-link>
                    <el-link type="warning" @click="deleteNotice(scope.row,false)">删除</el-link>
                </template>
            </el-table-column>
        </el-table>

        <el-dialog
                title="新增/编辑"
                :visible.sync="dialogVisible"
                width="40%" :close-on-click-modal="false">
            <el-form :model="data_from"
                     label-position="right"
                     label-width="120px">
                <el-form-item label="标题">
                    <el-input v-model="data_from.title" style="width: 360px;" clearable placeholder="链接"></el-input>
                </el-form-item>
                <el-form-item label="标签">
                    <el-input v-model="data_from.tag" style="width: 360px;" clearable placeholder="链接"></el-input>
                </el-form-item>

                <el-form-item label="起止时间">
                    <el-date-picker
                            clearable
                            style="width: 360px;"
                            v-model="data_from.time_range"
                            type="datetimerange"
                            format="yyyy-MM-dd HH:mm:ss"
                            value-format="yyyy-MM-dd HH:mm:ss"
                            range-separator="至"
                            start-placeholder="开始日期"
                            end-placeholder="结束日期">
                    </el-date-picker>
                </el-form-item>
                <el-form-item label="内容">
                    <el-input v-model="data_from.content"
                              style="width: 360px;"
                              type="textarea"
                              :rows="15"
                              clearable
                              placeholder="请输入内容">
                    </el-input>
                </el-form-item>

                <el-form-item label="排序">
                    <el-input v-model="data_from.sort" style="width: 360px;" clearable placeholder="排序"></el-input>
                </el-form-item>

                <el-form-item label="状态">
                    <el-switch
                            v-model="data_from.is_enabled"
                            active-text="启用"
                            :active-value="1"
                            :inactive-value="0"
                            @change="switchEnabled(scope.row)"
                            inactive-text="禁用">
                    </el-switch>
                </el-form-item>

            </el-form>
            <span slot="footer" class="dialog-footer">
            <el-button @click="dialogVisible = false">取 消</el-button>
            <el-button type="primary" @click="saveNotice(data_from,true)">确 定</el-button>
            </span>
        </el-dialog>
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
                query_from: {
                    username: '',
                    time_range: [],
                },
                params: {
                    position: {},
                },
                data_from: {
                    id: '',
                    is_enabled: 1,
                    content: '',
                    title: '',
                    tag: '',
                    sort: 100,
                    time_range: [],
                },
                origin_data_from: {
                    id: '',
                    tag: '',
                    is_enabled: 1,
                    content: '',
                    title: '',
                    sort: 100,
                    time_range: [],
                },
            }
        },
        created() {
            this.listQuery()
        },
        methods: {
            selectFile: function () {
                const _this = this
                _this.$refs["file_upload"].openDialog('getFileList')
            },
            switchEnabled: function (row) {
                const _this = this
                request({
                    url: '/admin/notice/enable',
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
            deleteNotice: function (row) {
                let _this = this
                this.$confirm('此操作将永久删除, 是否继续?', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning'
                }).then(() => {
                    request({
                        url: '/admin/notice/delete',
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
            saveNotice(row, submit) {
                const _this = this
                if (submit === false) {
                    _this.dialogVisible = true
                    Object.assign(_this.data_from, _this.origin_data_from)
                    if (Object.keys(row).length > 0) {
                        Object.assign(_this.data_from, row)
                        _this.data_from.time_range = [row.start_time, row.end_time]
                    }
                    return
                }
                request({
                    url: '/admin/notice/notice',
                    method: 'post',
                    data: _this.data_from
                }).then(function (res) {
                    if (res.code === 10000) {
                        _this.$message.success('保存成功')
                        _this.dialogVisible = false
                        _this.listQuery()
                        return
                    }
                    _this.$message.error('保存失败')
                })
            },

            listQuery() {
                const _this = this
                request({
                    url: '/admin/notice/list',
                    method: 'post',
                    data: _this.query_from
                }).then(function (res) {
                    console.log(res.data)
                    _this.table.list = res.data
                })
            }
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
