<template>
    <div class="app-container">

        <el-dialog
                title="图片管理"
                :visible.sync="fileDialogVisible"
                width="50%" :close-on-click-modal="false">
            <el-form :inline="true" :model="file_data" class="demo-form-inline">
                <el-form-item label="组名">
                    <el-input v-model="file_data.group_name" placeholder="组名"></el-input>
                </el-form-item>
                <el-form-item label="排序">
                    <el-input v-model="file_data.sort" placeholder="排序"></el-input>
                </el-form-item>
                <el-form-item>
                    <el-button type="primary" @click="addFileGroup">新增分组</el-button>
                </el-form-item>
            </el-form>
            <el-container style="height: 500px; border: 1px solid #eee">
                <el-aside width="200px" style="background-color: rgb(238, 241, 246)">
                    <el-main>
                        <el-menu @select="handleSelect" default-active="0">
                            <el-menu-item v-for="(v,k) in group_list" :index="k.toString()" :key="v.id">
                                <i class="el-icon-document"></i>
                                <span slot="title">{{ v.group_name }}</span>
                            </el-menu-item>
                        </el-menu>
                    </el-main>
                </el-aside>

                <el-container>
                    <el-main>
                        <div class="demo-image">
                            <el-row :gutter="20">
                                <el-col :span="6">
                                    <div class="grid-content bg-purple">
                                        <el-upload
                                                class="avatar-uploader"
                                                action=""
                                                :show-file-list="false"
                                                :http-request="uploadImage">
                                            <i class="el-icon-plus avatar-uploader-icon"></i>
                                        </el-upload>
                                    </div>
                                </el-col>
                                <el-checkbox-group v-model="check_list">
                                    <el-col :span="6" v-for="(v,k) in file_list" :key="v.id">
                                        <div class="image-row">
                                            <el-image
                                                    class="image-view"
                                                    :alt="v.file_size"
                                                    :src="v.full_url"
                                                    fit="fill">
                                            </el-image>
                                            <p class="demonstration">
                                                <el-checkbox :label="v">{{v.file_name}}</el-checkbox>
                                            </p>
                                        </div>
                                    </el-col>
                                </el-checkbox-group>
                            </el-row>
                        </div>
                    </el-main>
                </el-container>
            </el-container>
            <span slot="footer" class="dialog-footer">
            <el-button @click="fileDialogVisible = false">取 消</el-button>
            <el-button type="primary" @click="handleSelectImage">确 定</el-button>
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
                fileSelection: [],
                file_data: {
                    group_name: '',
                    sort: '',
                },
                group_list: [],
                file_list: [],
                current_index: 0,
                check_list: [],
            }
        },
        watch: {},
        created() {
        },
        methods: {
            handleSelectImage() {
                const _this = this
                if (_this.check_list.length === 0) {
                    _this.$message.error('请选择文件')
                    return
                }
                _this.$emit('getFileList', _this.check_list);
                _this.fileDialogVisible = false
            },
            handleSelect(key, keyPath) {
                this.current_index = parseInt(key)
                const _this = this
                _this.check_list = []
                const group = _this.group_list[_this.current_index]
                request({
                    url: '/admin/file/list',
                    method: 'post',
                    data: group
                }).then(function (res) {
                    if (res.code === 10000) {
                        _this.file_list = res.data.file_list
                        return
                    }
                    _this.$message.error('获取失败')
                })
            },
            addFileGroup() {
                const _this = this
                request({
                    url: '/admin/file/group',
                    method: 'post',
                    data: _this.file_data
                }).then(function (res) {
                    if (res.code === 10000) {
                        _this.$message.error('新增成功')
                        return
                    }
                    _this.$message.error('获取失败')
                })
            },
            openDialog(val) {
                const _this = this
                request({
                    url: '/admin/file/group-list',
                    method: 'post',
                    data: {}
                }).then(function (res) {
                    if (res.code === 10000) {
                        _this.group_list = res.data.group_list
                        _this.handleSelect(0)
                        _this.fileDialogVisible = val
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

    .avatar-uploader .el-upload:hover {
        border-color: #409EFF;
    }

    .avatar-uploader-icon {
        font-size: 28px;
        color: #8c939d;
        width: 160px;
        height: 200px;
        line-height: 200px;
        text-align: center;
    }

    .image-row {
        width: 180px;
        height: 200px;
        float: contour;
        text-align: center;
        border: 1px dashed #d9d9d9;
        margin-bottom: 10px;
    }

    .image-view {
        padding: 10px;;
        width: 160px;
        height: 140px;
        cursor: pointer;
    }

    .demonstration {
        word-break: break-all;
        padding: 10px;
    }

    .image-check {
        word-break: break-all;
    }
</style>
