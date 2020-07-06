<template>
    <div class="app-container">

        <el-dialog
                title="图片管理"
                :visible.sync="fileDialogVisible"
                width="50%" :close-on-click-modal="false">
            <span slot="title" class="dialog-title">
                    <el-form :inline="true" :model="file_data" class="demo-form-inline">
                      <el-form-item label="组名">
                        <el-input v-model="file_data.group_name" placeholder="组名"></el-input>
                      </el-form-item>
                      <el-form-item label="排序">
                        <el-input v-model="file_data.sort" placeholder="排序"></el-input>
                      </el-form-item>
                      <el-form-item>
                        <el-button type="primary" @click="addFileGroup">新增分组</el-button>
                          <el-button type="primary">
                        上传图片<i class="el-icon-upload el-icon--right"></i>
                        </el-button>
                      </el-form-item>
                    </el-form>
            </span>
            <el-container style="height: 500px; border: 1px solid #eee">
                <el-aside width="200px" style="background-color: rgb(238, 241, 246)">
                    <el-main>
                        <el-menu default-active="0">
                            <el-menu-item index="0">
                                <i class="el-icon-document"></i>
                                <span slot="title">导航一</span>
                            </el-menu-item>
                            <el-menu-item index="3">
                                <i class="el-icon-document"></i>
                                <span slot="title">导航二</span>
                            </el-menu-item>
                            <el-menu-item index="4">
                                <i class="el-icon-document"></i>
                                <span slot="title">导航三</span>
                            </el-menu-item>
                        </el-menu>
                    </el-main>
                </el-aside>

                <el-container>
                    <el-main>
                        <el-table :data="tableData" @selection-change="handleSelectionChange">
                            <el-table-column
                                    type="selection"
                                    width="55">
                            </el-table-column>
                            <el-table-column prop="date" label="图片">
                                <template slot-scope="scope">
                                    <el-image :src="scope.row.file_full_url"
                                              style="width: 100px;height: 40px"
                                              :preview-src-list="[scope.row.full_url]"
                                              class="avatar">
                                    </el-image>
                                </template>
                            </el-table-column>
                            <el-table-column prop="file_name" label="名称" width="120">
                            </el-table-column>
                            <el-table-column prop="file_size" label="大小">
                            </el-table-column>
                        </el-table>
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
                tableData: [],
                fileSelection: [],
                file_data: {
                    group_name: '',
                    sort: '',
                },
                group_list: [],
            }
        },
        watch: {},
        created() {
            this.getFileList()
        },
        methods: {
            getFileList() {
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
                        _this.tableData = res.data.table_data
                        _this.fileDialogVisible = val
                        return
                    }
                    _this.$message.error('获取图片失败')
                })
            },
            handleSelectionChange(val) {
                this.fileSelection = val;
            },
            handleOpen(key, keyPath) {
                console.log(key, keyPath);
            },
            handleClose(key, keyPath) {
                console.log(key, keyPath);
            }
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
