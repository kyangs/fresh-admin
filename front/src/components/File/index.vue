<template>
    <div class="app-container">

        <el-dialog
                title="图片管理"
                :visible.sync="fileDialogVisible"
                width="55%" :close-on-click-modal="false">
            <el-form :inline="true" :model="group_data" class="demo-form-inline">
                <el-form-item label="组名">
                    <el-input v-model="group_data.group_name" placeholder="组名"></el-input>
                </el-form-item>
                <el-form-item label="排序">
                    <el-input v-model="group_data.sort" placeholder="排序"></el-input>
                </el-form-item>
                <el-form-item>
                    <el-button type="primary" @click="addFileGroup(group_data,true)">保存组</el-button>

                    <el-popconfirm
                            v-if="group_data.id"
                            @onConfirm="deleteFileGroup(group_data)"
                            title="当前组被删除后，此组里的图片会被同时删除，您确定吗？">
                        <el-button slot="reference" type="danger">删除组</el-button>
                    </el-popconfirm>

                </el-form-item>
            </el-form>
            <el-container style="height: 500px; border: 1px solid #eee">
                <el-aside width="200px" style="background-color: rgb(238, 241, 246)">
                    <el-main>
                        <el-menu @select="handleSelect" :default-active="default_active">
                            <el-menu-item v-for="(v,k) in group_list"
                                          @click="addFileGroup(v,false)"
                                          :index="k.toString()" :key="v.id">
                                <i class="el-icon-document"></i>
                                <span slot="title">{{ v.group_name }}</span>
                            </el-menu-item>
                        </el-menu>
                    </el-main>
                </el-aside>

                <el-container>
                    <el-header style="text-align: right; font-size: 12px;height: 42px">
                        <el-form :inline="true" class="demo-form-inline">
                            <el-form-item>
                                <el-upload
                                        style="padding: 2px"
                                        multiple
                                        action=""
                                        :show-file-list="false"
                                        :http-request="uploadImage">
                                    <el-button type="success">点击开始上传</el-button>
                                </el-upload>
                            </el-form-item>
                            <el-form-item>
                                <el-checkbox :indeterminate="is_indeterminate" v-model="check_all"
                                             @change="handleCheckAllChange">全选
                                </el-checkbox>
                            </el-form-item>
                        </el-form>
                    </el-header>
                    <el-main>
                        <div class="demo-image">
                            <el-row :gutter="20">
                                <el-checkbox-group v-model="check_list">
                                    <el-col :span="6" v-for="(v,k) in file_page.data" :key="v.id">
                                        <div class="image-row">
                                            <el-image
                                                    @click="handleClickImage(k)"
                                                    class="image-view"
                                                    :title="v.file_name"
                                                    :src="v.full_url"
                                                    :preview-src-list="[v.full_url]"
                                                    fit="fill">
                                            </el-image>
                                            <p class="demonstration">
                                                <el-checkbox
                                                        :label="k">
                                                    <el-row style="width: 100px;overflow: hidden;white-space: nowrap;text-overflow: ellipsis;">
                                                        {{v.file_name}}
                                                    </el-row>
                                                </el-checkbox>
                                            </p>
                                        </div>
                                    </el-col>
                                </el-checkbox-group>
                            </el-row>
                        </div>
                    </el-main>
                    <el-footer style="height: 32px">
                        <el-pagination
                                @size-change="handleSizeChange"
                                @current-change="handleCurrentChange"
                                :current-page="file_page.current_page"
                                :page-sizes="[100, 200, 300, 400]"
                                :page-size="file_page.per_page"
                                layout="sizes, prev, pager, next"
                                :total="file_page.total">
                        </el-pagination>
                    </el-footer>
                </el-container>
            </el-container>
            <span slot="footer" class="dialog-footer">
            <el-link @click="deleteSelectImage" v-if="check_list.length > 0" type="danger">删除</el-link>
            <el-button @click="fileDialogVisible = false">取消</el-button>
            <el-button type="primary" @click="handleSelectImage">确定</el-button>
            </span>
        </el-dialog>


    </div>
</template>

<script>
    import request from '@/utils/jsonrequest'

    export default {
        name: 'File',
        props: {
            show_file_dialog: Boolean
        },
        data() {
            return {
                fileDialogVisible: this.show_file_dialog,
                levelList: null,
                check_all: false,
                is_indeterminate: false,
                fileSelection: [],
                file_list: [],
                group_data: {
                    id: '',
                    group_name: '',
                    sort: '',
                },
                group_list: [],
                file_page: {
                    current_page: 1,
                    total: 0,
                    per_page: 100,
                    data: [],
                },
                current_index: 0,
                check_list: [],
                callback: '',
                default_active: '0',
            }
        },
        watch: {},
        created() {
        },
        methods: {
            handleCheckAllChange(val) {
                const _this = this
                _this.check_list = [];
                if (val) {
                    _this.file_page.data.forEach((v, k) => {
                        this.check_list.push(k)
                    });
                }
            },
            handleCurrentChange(val) {
                this.file_page.current_page = val
                this.queryFileList()
            },
            handleSizeChange(val) {
                this.file_page.per_page = val
                this.file_page.current_page = 1
                this.queryFileList()
            },
            handleClickImage: function (index) {
                console.log(index)
            },
            handleSelectImage() {
                const _this = this
                if (_this.check_list.length === 0) {
                    _this.$message.error('请选择文件')
                    return
                }
                const rows = []
                _this.check_list.forEach(v => {
                    rows.push(_this.file_page.data[v])
                })
                _this.$emit(_this.callback, rows);
                _this.fileDialogVisible = false
            },
            deleteSelectImage() {
                const _this = this
                const param = {
                    id_list: [],
                    group: Object.assign({
                        pageSize: _this.file_page.per_page,
                        page: _this.file_page.current_page
                    }, _this.group_data),
                }
                _this.check_list.forEach(v => {
                    param.id_list.push(_this.file_page.data[v].id)
                })
                request({
                    url: '/admin/file/delete',
                    method: 'post',
                    data: param
                }).then(function (res) {
                    if (res.code === 10000) {
                        _this.file_page = res.data
                        _this.check_list = []
                        return
                    }
                    _this.$message.error('获取失败')
                })
            },
            queryFileList() {
                const _this = this
                const params = {
                    pageSize: _this.file_page.per_page,
                    page: _this.file_page.current_page
                }
                Object.assign(params, _this.group_list[this.current_index])
                request({
                    url: '/admin/file/list',
                    method: 'post',
                    data: params
                }).then(function (res) {
                    if (res.code === 10000) {
                        _this.file_page = res.data
                        _this.check_list = [];
                        return
                    }
                    _this.$message.error('获取失败')
                })
            },
            handleSelect(key, keyPath) {
                this.current_index = parseInt(key)
                const _this = this
                _this.check_all = false
                _this.default_active = key.toString()
                this.file_page.current_page = 1
                _this.queryFileList()
                _this.check_list = []
            },
            deleteFileGroup(row) {
                const _this = this
                request({
                    url: '/admin/file/group-delete',
                    method: 'post',
                    data: row
                }).then(function (res) {
                    if (res.code === 10000) {
                        _this.$message.success('删除成功')
                        _this.group_list = res.data.group_list
                        _this.handleSelect('0')
                        return
                    }
                    _this.$message.error('删除失败')
                })
            },
            addFileGroup(row, submit) {
                const _this = this
                if (submit === false) {
                    this.group_data = Object.assign({}, row)
                    return
                }
                request({
                    url: '/admin/file/group',
                    method: 'post',
                    data: row
                }).then(function (res) {
                    if (res.code === 10000) {
                        _this.$message.success('操作成功')
                        _this.group_data.group_name = ''
                        _this.group_data.sort = ''
                        _this.group_list = res.data.group_list
                        _this.handleSelect('0')
                        return
                    }
                    _this.$message.error('操作失败')
                })
            },
            initData() {
                this.group_data.group_name = ''
                this.group_data.sort = ''
                this.group_data.id = ''
                this.check_list = []
            },
            openDialog(callback) {
                const _this = this
                request({
                    url: '/admin/file/group-list',
                    method: 'post',
                    data: {}
                }).then(function (res) {
                    if (res.code === 10000) {
                        _this.group_list = res.data.group_list
                        _this.handleSelect(0)
                        _this.fileDialogVisible = true
                        _this.callback = callback
                        _this.initData()
                        return
                    }
                    _this.$message.error('获取图片失败')
                })
            },
            handleSelectionChange(val) {
                this.fileSelection = val;
            },

            uploadImage: function (file) {
                const formData = new FormData(); // 生成文件对象
                formData.append('file', file.file)
                const _this = this
                const group = _this.group_list[_this.current_index]

                for (let k in group) formData.append(k, group[k])

                request({
                    headers: {
                        'enctype': 'multipart/form-data'
                    },
                    url: '/admin/upload/upload',
                    method: 'post',
                    data: formData
                }).then(function (res) {
                    _this.handleSelect(_this.current_index)
                })
            },
        }
    }
</script>

<style lang="scss">
    .el-upload {
        border: 1px dashed #d9d9d9;
        border-radius: 6px;
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }

    .image-row {
        width: 140px;
        height: 160px;
        float: contour;
        text-align: center;
        border: 1px dashed #d9d9d9;
        margin-bottom: 10px;
    }

    .image-view {
        padding: 10px;;
        width: 100px;
        height: 120px;
        cursor: pointer;
    }

    .demonstration {
        word-break: break-all;
        padding: 10px;
    }

    .image-check {
        word-break: break-all;
    }

    .el-header {
        background-color: #B3C0D1;
        color: #333;
        line-height: 42px;
    }

    .el-aside {
        color: #333;
    }

    .el-footer {
        color: #333;
        text-align: center;
        line-height: 16px;
    }
</style>
