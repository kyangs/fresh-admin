<template>
    <div class="app-container">
        <!-- 搜索 -->
        <el-form :inline="true" :model="query_from" class="demo-form-inline">
            <el-form-item>
                <el-button  size="mini" type="primary" @click="saveCategory({},false)">新增</el-button>
            </el-form-item>
        </el-form>
        <!--数据-->
        <el-table
                :data="table.list"
                height="550"
                border
                size="mini"
                row-key="id"
                :tree-props="{children: 'children'}">
            style="width: 100%">
            <el-table-column label="名称" prop="name" width="120"></el-table-column>
            <el-table-column label="图片" width="120">
                <template slot-scope="scope">
                    <el-image :src="scope.row.full_url"
                              style="width: 100px;height: 40px"
                              :preview-src-list="[scope.row.full_url]"
                              class="avatar">
                    </el-image>
                </template>
            </el-table-column>
            <el-table-column label="是否首页显示" width="200">
                <template slot-scope="scope">
                    <el-switch
                            v-model="scope.row.show_home"
                            active-text="是"
                            :active-value="1"
                            :inactive-value="0"
                            @change="switchEnabled(scope.row,'show_home')"
                            inactive-text="否">
                    </el-switch>
                </template>
            </el-table-column>
            <el-table-column
                    prop="sort"
                    label="排序"
                    width="80">
            </el-table-column>
            <el-table-column label="状态" width="160">
                <template slot-scope="scope">
                    <el-switch
                            v-model="scope.row.is_enabled"
                            active-text="启用"
                            :active-value="1"
                            :inactive-value="0"
                            @change="switchEnabled(scope.row,'is_enabled')"
                            inactive-text="禁用">
                    </el-switch>
                </template>
            </el-table-column>
            <el-table-column
                    prop="creator"
                    label="创建者"
                    width="80">
            </el-table-column>

            <el-table-column
                    prop="create_time"
                    label="创建日期">
            </el-table-column>
            <el-table-column label="操作" width="120">
                <template slot-scope="scope">
                    <el-link type="success" @click="saveCategory(scope.row,false)">编辑</el-link>
                    <el-link type="warning" @click="deleteCategory(scope.row,false)">删除</el-link>
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
                <el-form-item label="名称">
                    <el-input size="mini" v-model="data_from.name" style="width: 360px;" clearable placeholder="名称"></el-input>
                </el-form-item>
                <el-form-item label="类型">
                    <el-select size="mini" v-model="data_from.parent_id" style="width: 360px;" clearable placeholder="类型">
                        <el-option label="一级分类" :key="0" :value="0"></el-option>
                        <el-option v-for="(v,k) in params.parent_category"
                                   :label="v.name" :key="v.id" :value="v.id"></el-option>
                    </el-select>
                </el-form-item>
                <el-form-item label="图片">
                    <el-image v-if="data_from.full_url" :src="data_from.full_url"
                              style="width: 80px;height: 80px">
                    </el-image>
                    <el-button  size="mini" type="primary" @click="selectFile">
                        选择图片<i class="el-icon-upload el-icon--right"></i>
                    </el-button>
                </el-form-item>
                <el-form-item label="排序">
                    <el-input size="mini" v-model="data_from.sort" style="width: 360px;" clearable placeholder="排序"></el-input>
                </el-form-item>
                <el-form-item label="是否首页显示">
                    <el-switch
                            v-model="data_from.show_home"
                            active-text="是"
                            :active-value="1"
                            :inactive-value="0"
                            inactive-text="否">
                    </el-switch>
                </el-form-item>
                <el-form-item label="状态">
                    <el-switch
                            v-model="data_from.is_enabled"
                            active-text="启用"
                            :active-value="1"
                            :inactive-value="0"
                            inactive-text="禁用">
                    </el-switch>
                </el-form-item>
            </el-form>
            <span slot="footer" class="dialog-footer">
            <el-button  size="mini" @click="dialogVisible = false">取消</el-button>
            <el-button  size="mini" type="primary" @click="saveCategory(data_from,true)">提交</el-button>
            </span>
        </el-dialog>

        <File ref="file_upload" @getFileList="getFileList"></File>
    </div>

</template>

<script>
    import waves from '@/directive/waves'
    import request from '@/utils/jsonrequest'
    import File from '@/components/File'

    export default {
        name: 'List',
        components: {
            File
        },
        directives: {
            waves,
        },
        data() {
            return {
                dialogVisible: false,
                table: {
                    list: []
                },
                query_from: {
                    position: '',
                    username: '',
                    time_range: [],
                },
                params: {
                    parent_category: {},
                },
                data_from: {
                    id: '',
                    parent_id: 0,
                    is_enabled: 1,
                    name: '',
                    image_id: '',
                    full_url: '',
                    show_home: 0,
                    sort: 100,
                },
                origin_data_from: {
                    id: '',
                    parent_id: 0,
                    is_enabled: 1,
                    name: '',
                    image_id: '',
                    full_url: '',
                    show_home: 0,
                    sort: 100,
                },
            }
        },
        created() {
            this.initParams()
            this.listQuery()
        },
        methods: {
            initParams() {
                const _this = this
                request({
                    url: '/admin/category/parent',
                    method: 'post',
                    data: {}
                }).then(function (res) {
                    if (res.code === 10000) {
                        _this.params = res.data
                        return
                    }
                    _this.$message.error('父类失败')
                })
            },
            selectFile: function () {
                const _this = this
                _this.$refs["file_upload"].openDialog('getFileList')
            },
            getFileList(rows) {
                const _this = this
                const row = rows[0]
                _this.data_from.full_url = row.full_url
                _this.data_from.image_id = row.id
            },
            switchEnabled: function (row, key) {
                const _this = this
                request({
                    url: '/admin/category/enable',
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
            },
            deleteCategory: function (row) {
                let _this = this
                this.$confirm('此操作将永久删除, 是否继续?', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning'
                }).then(() => {
                    request({
                        url: '/admin/category/delete',
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
            saveCategory(row, submit) {
                const _this = this
                if (submit === false) {
                    _this.dialogVisible = true
                    Object.assign(_this.data_from, _this.origin_data_from)
                    if (Object.keys(row).length > 0) {
                        Object.assign(_this.data_from, row)
                    }
                    return
                }
                request({
                    url: '/admin/category/category',
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
            uploadImage: function (file) {
                const formData = new FormData(); // 生成文件对象
                formData.append('file', file.file)
                const _this = this
                request({
                    headers: {
                        'enctype': 'multipart/form-data'
                    },
                    url: '/admin/upload/upload',
                    method: 'post',
                    data: formData
                }).then(function (res) {
                    _this.data_from.full_path = res.data.full_path
                    _this.data_from.image = res.data.path
                })
            },
            listQuery() {
                const _this = this
                request({
                    url: '/admin/category/list',
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
