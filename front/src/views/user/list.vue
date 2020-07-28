<template>
    <div class="app-container">
        <!-- 搜索 -->
        <el-form :inline="true" :model="query_from" class="demo-form-inline">
            <el-form-item label="用户名">
                <el-input v-model="query_from.username" placeholder="用户名" clearable></el-input>
            </el-form-item>
            <el-form-item label="手机号">
                <el-input v-model="query_from.phone" placeholder="手机号" clearable></el-input>
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
                <el-button type="primary" @click="saveAdv({},false)">新增</el-button>
            </el-form-item>
        </el-form>
        <!--数据-->
        <el-table
                :data="table.list"
                height="550"
                border
                style="width: 100%">
            <el-table-column label="用户名" width="100" prop="username"></el-table-column>
            <el-table-column label="真实姓名" width="100" prop="username"></el-table-column>
            <el-table-column label="图片" width="120">
                <template slot-scope="scope">
                    <el-image :src="scope.row.full_path"
                              style="width: 100px;height: 40px"
                              :preview-src-list="[scope.row.full_path]"
                              class="avatar">
                    </el-image>
                </template>
            </el-table-column>
            <el-table-column label="广告位置" width="200">
                <template slot-scope="scope">
                    {{ params.position[scope.row.position] }}
                </template>
            </el-table-column>
            <el-table-column label="链接" width="200" prop="link"></el-table-column>
            <el-table-column
                    prop="sort"
                    label="排序"
                    width="80">
            </el-table-column>
            <el-table-column label="状态" width="160">
                <template slot-scope="scope">
                    <el-switch
                            v-model="scope.row.is_enabled==='1'"
                            active-text="启用"
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
                    prop="username"
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
                    <el-link type="success" @click="saveAdv(scope.row,false)">编辑</el-link>
                    <el-link type="warning" @click="deleteAdv(scope.row,false)">删除</el-link>
                </template>
            </el-table-column>
        </el-table>

        <el-dialog
                title="广告新增/编辑"
                :visible.sync="dialogVisible"
                width="40%" :close-on-click-modal="false">
            <el-form :model="data_from"
                     label-position="right"
                     label-width="120px">
                <el-form-item label="位置">
                    <el-select v-model="data_from.position" style="width: 360px;" clearable placeholder="位置">
                        <el-option v-for="(v,k) in params.position"
                                   :label="v" :key="v" :value="k"></el-option>
                    </el-select>
                </el-form-item>
                <el-form-item label="链接">
                    <el-input v-model="data_from.link" style="width: 360px;" clearable placeholder="链接"></el-input>
                </el-form-item>

                <el-form-item label="图片">
                    <el-image v-if="data_from.full_path" :src="data_from.full_path"
                              style="width: 80px;height: 80px">
                    </el-image>
                    <el-button type="primary" @click="selectFile">
                        选择图片<i class="el-icon-upload el-icon--right"></i>
                    </el-button>
                </el-form-item>

                <el-form-item label="时间">
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
                <el-form-item label="排序">
                    <el-input v-model="data_from.sort" style="width: 360px;" clearable placeholder="排序"></el-input>
                </el-form-item>
                <el-form-item label="状态">
                    <el-radio v-model="data_from.is_enabled" label="1" key="1" :value="1">启用</el-radio>
                    <el-radio v-model="data_from.is_enabled" label="0" key="0" :value="0">禁用</el-radio>
                </el-form-item>
            </el-form>
            <span slot="footer" class="dialog-footer">
            <el-button @click="dialogVisible = false">取 消</el-button>
            <el-button type="primary" @click="saveAdv(data_from,true)">确 定</el-button>
            </span>
        </el-dialog>
        <File ref="file_upload" @getFileList="getFileList"></File>
    </div>

</template>

<script>
    import request from '@/utils/jsonrequest'
    import File from '@/components/File'

    export default {
        name: 'List',
        components: {
            File
        },
        data() {
            return {
                form_data: new FormData(),
                dialogVisible: false,
                show_file_dialog: false,
                table: {
                    list: []
                },
                query_from: {
                    phone: '',
                    username: '',
                    time_range: [],
                },
                params: {
                    position: {},
                },
                data_from: {
                    id: '',
                    is_enabled: '1',
                    position: '',
                    image_id: 0,
                    full_path: '',
                    link: '',
                    sort: 100,
                    time_range: [],
                },
                origin_data_from: {
                    id: '',
                    is_enabled: '1',
                    position: '',
                    image_id: 0,
                    full_path: '',
                    link: '',
                    sort: 100,
                    time_range: [],
                },
            }
        },
        created() {
            this.initParam()
            this.listQuery()
        },
        methods: {
            selectFile: function () {
                const _this = this
                _this.$refs["file_upload"].openDialog('getFileList')
            },
            getFileList(rows) {
                const _this = this
                const row = rows[0]
                _this.data_from.full_path = row.full_url
                _this.data_from.image_id = row.id
            },
            switchEnabled: function (row) {
                const _this = this
                request({
                    url: '/admin/adv/enable',
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
            deleteAdv: function (row) {
                let _this = this
                this.$confirm('此操作将永久删除, 是否继续?', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning'
                }).then(() => {
                    request({
                        url: '/admin/adv/delete',
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
            saveAdv(row, submit) {
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
                    url: '/admin/adv/adv',
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

            initParam() {
                const _this = this

                request({
                    url: '/admin/adv/param',
                    method: 'post',
                    data: _this.query_from
                }).then(function (res) {
                    _this.params = res.data
                })

            },
            listQuery() {
                const _this = this
                request({
                    url: '/admin/adv/getlist',
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
