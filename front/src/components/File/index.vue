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
                        <el-menu @select="handleSelect"  default-active="0">
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
                            <div class="block" >
                                <el-upload
                                        drag
                                        class="upload-demo"
                                        action=""
                                        :show-file-list="false"
                                        :http-request="uploadImage">
                                    <i class="el-icon-upload" ></i>
                                    <div class="el-upload__text">将文件拖到此处，或<em>点击上传</em></div>
                            </el-upload>
                            </div>
                            <div class="block" v-for="(v,k) in file_list" :key="v.id">
                                <el-image
                                        style="width: 100px; height: 100px"
                                        :src="v.full_url"
                                        :fit="v.full_url">

                                </el-image>
                                <span class="demonstration">{{ v.file_name }}[{{v.file_size}}]</span>
                            </div>
                        </div>
                    </el-main>
                </el-container>
            </el-container>
            <span slot="footer" class="dialog-footer">
            <el-button @click="fileDialogVisible = false">取 消</el-button>
            <el-button type="primary" @click="fileDialogVisible = false">确 定</el-button>
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
            }
        },
        watch: {},
        created() {
        },
        methods: {
            handleSelect(key, keyPath) {
                this.current_index = parseInt(key)
                const _this = this
                const group = _this.group_list[_this.current_index]
                console.log(group);
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
                formData.append('group_id', file.file)
                const _this = this
                const group = _this.group_list[_this.current_index]
                Object.entries(_this.group_list[_this.current_index]).f
                console.log(group);
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

<style lang="scss" scoped>
    .app-breadcrumb.el-breadcrumb {
        display: inline-block;
        font-size: 14px;
        line-height: 50px;
        margin-left: 8px;

        .no-redirect {
            color: #97a8be;
            cursor: text;
        }
    }
</style>
