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
                <el-button type="primary" @click="saveRequest({},false)">新增</el-button>
            </el-form-item>
        </el-form>
        <!--数据-->
        <el-table
                :data="table.list"
                height="550"
                border
                style="width: 100%">
            <el-table-column label="用户名" width="100" prop="nickname"></el-table-column>
            <el-table-column label="真实姓名" width="100" prop="real_name"></el-table-column>
            <el-table-column label="性别" width="100" prop="gender"></el-table-column>
            <el-table-column label="头像" width="120">
                <template slot-scope="scope">
                    <el-image :src="scope.row.full_avatar"
                              style="width: 100px;height: 40px"
                              :preview-src-list="[scope.row.full_avatar]"
                              class="avatar">
                    </el-image>
                </template>
            </el-table-column>
            <el-table-column label="手机号" width="100" prop="phone"></el-table-column>
            <el-table-column label="地址" width="200" prop="link"></el-table-column>
            <el-table-column label="地址" width="160">
                <template slot-scope="scope">
                    {{scope.row.country}} {{scope.row.province}} {{scope.row.city}}
                </template>
            </el-table-column>
            <el-table-column label="最新登录时间" prop="login_time"></el-table-column>
            <el-table-column
                    prop="create_time"
                    label="创建时间"
                    width="160">
            </el-table-column>
            <el-table-column label="操作" width="120">
                <template slot-scope="scope">
                    <el-link type="success" @click="saveRequest(scope.row,false)">编辑</el-link>
                    <el-link type="warning" @click="deleteRequest(scope.row,false)">删除</el-link>
                </template>
            </el-table-column>
        </el-table>

        <el-pagination
                @size-change="handleSizeChange"
                @current-change="handleCurrentChange"
                :current-page="query_from.current_page"
                :page-sizes="[100, 200, 300, 400]"
                :page-size="query_from.per_page"
                layout="sizes, prev, pager, next"
                :total="table.total">
        </el-pagination>

        <el-dialog
                title="新增/编辑 用户"
                :visible.sync="dialogVisible"
                width="40%" :close-on-click-modal="false">
            <el-form :model="data_from"
                     label-position="right"
                     label-width="120px">
                <el-form-item label="用户名">
                    <el-input v-model="data_from.username" style="width: 360px;" clearable placeholder="用户名"></el-input>
                </el-form-item>
                <el-form-item label="真实姓名">
                    <el-input v-model="data_from.real_name" style="width: 360px;" clearable placeholder="真实姓名"></el-input>
                </el-form-item>
                <el-form-item label="登录密码">
                    <el-input v-model="data_from.password" style="width: 360px;" clearable placeholder="登录密码"></el-input>
                </el-form-item>
                <el-form-item label="手机号">
                    <el-input v-model="data_from.phone" style="width: 360px;" clearable placeholder="手机号"></el-input>
                </el-form-item>
                <el-form-item label="性别">
                    <el-select v-model="data_from.gender">
                        <el-option value="男"></el-option>
                        <el-option value="女"></el-option>
                        <el-option value="保密"></el-option>
                    </el-select>
                </el-form-item>

                <el-form-item label="头像">
                    <el-upload
                            class="avatar-uploader"
                            action=""
                            :show-file-list="false"
                            :http-request="uploadImage">
                        <img v-if="data_from.full_path" :src="data_from.full_path" class="avatar">
                        <i v-else class="el-icon-plus avatar-uploader-icon"></i>
                    </el-upload>
                </el-form-item>

                <el-form-item label="状态">
                    <el-switch v-model="data_from.is_enabled"
                    active-text="启用"
                    :active-value="1"
                    :inactive-value="0"
                    inactive-text="禁用">
                    </el-switch>
                </el-form-item>
            </el-form>
            <span slot="footer" class="dialog-footer">
            <el-button @click="dialogVisible = false">取 消</el-button>
            <el-button type="primary" @click="saveRequest(data_from,true)">确 定</el-button>
            </span>
        </el-dialog>
    </div>

</template>

<script>
    import request from '@/utils/jsonrequest'

    export default {
        name: 'List',
        components: {
        },
        data() {
            return {
                form_data: new FormData(),
                dialogVisible: false,
                show_file_dialog: false,
                table: {
                    list: [],
                    total:0,
                },
                query_from: {
                    phone: '',
                    current_page: 1,
                    per_page: 20,
                    username: '',
                    time_range: [],
                },
                params: {
                    position: {},
                },
                data_from: {
                    id: '',
                    is_enabled: 1,
                    username: '',
                    real_name: '',
                    password: '',
                    phone: '',
                    gender: '保密',
                    image_key: '',
                    full_avatar: '',
                    avatar: '',
                },
                origin_data_from: {
                    id: '',
                    is_enabled: 1,
                    username: '',
                    real_name: '',
                    password: '',
                    phone: '',
                    gender: '保密',
                    image_key: '',
                    full_avatar: '',
                    avatar: '',
                },
            }
        },
        created() {
            this.initParam()
            this.listQuery()
        },
        methods: {
            handleCurrentChange(val) {
                this.query_from.current_page = val
                this.listQuery()
            },
            handleSizeChange(val) {
                this.query_from.per_page = val
                this.query_from.current_page = 1
                this.listQuery()
            },
            uploadImage: function (file) {
                const formData = new FormData(); // 生成文件对象
                formData.append('file', file.file)
                const _this = this
                request({
                    headers: {
                        'enctype': 'multipart/form-data'
                    },
                    url: '/admin/upload/avatar',
                    method: 'post',
                    data: formData
                }).then(function (res) {
                    console.log(res.data)
                    _this.data_from.avatar = res.data.path
                    _this.data_from.full_avatar = res.data.full_url
                    _this.data_from.image_key = res.data.config_key
                })
            },
            switchEnabled: function (row) {
                const _this = this
                request({
                    url: '/admin/user/enable',
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
            deleteRequest: function (row) {
                let _this = this
                this.$confirm('此操作将永久删除, 是否继续?', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning'
                }).then(() => {
                    request({
                        url: '/admin/user/delete',
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
            saveRequest(row, submit) {
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
                    url: '/admin/user/save',
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
            },
            listQuery() {
                const _this = this
                request({
                    url: '/admin/user/list',
                    method: 'post',
                    data: _this.query_from
                }).then(function (res) {
                    console.log(res.data)
                    _this.table.list = res.data.data
                    _this.table.total = res.data.total
                })
            }
        }
    }
</script>
<style>
    .avatar-uploader .el-upload {
        border: 1px dashed #d9d9d9;
        border-radius: 6px;
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }
    .avatar-uploader .el-upload:hover {
        border-color: #409EFF;
    }
    .avatar-uploader-icon {
        font-size: 28px;
        color: #8c939d;
        width: 178px;
        height: 178px;
        line-height: 178px;
        text-align: center;
    }
    .avatar {
        width: 178px;
        height: 178px;
        display: block;
    }
</style>
