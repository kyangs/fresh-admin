<template>
    <div>
        <el-drawer
                ref="drawer"
                :with-header="false"
                size="50%"
                :wrapperClosable="false"
                :visible.sync="dialogFormVisible"
                direction="rtl"
                custom-class="demo-drawer"
        >
            <div class="demo-drawer__content">
                <el-form ref="dataForm" :rules="rules" :model="temp" label-position="left" label-width="70px"
                         style="width: 100%; padding:10px; height: 100vh;overflow-y: scroll;">

                    <el-tabs tab-position="top" style="height: 200px;">
                        <el-tab-pane label="基本信息">

                            <el-form-item label="栏目" prop="column_id">
                                <el-cascader v-model="temp.column_id" :options="getColumnList" :props="props_pid"
                                             placeholder="请选择" change-on-select @change="handleChange"/>
                            </el-form-item>
                            <el-form-item label="分类" prop="cate_id">
                                <el-select size="mini" v-model="temp.cate_id" class="filter-item" placeholder="请选择">
                                    <el-option v-for="item in cates" :key="item.id" :label="item.name"
                                               :value="item.id"/>
                                </el-select>
                            </el-form-item>
                            <el-form-item label="标题" prop="title">
                                <el-input size="mini" v-model="temp.title" clearable/>
                            </el-form-item>
                            <el-form-item label="封面" prop="img">
                                <img v-if="temp.full_path" :src="temp.full_path"  @click="selectFile"
                                     style="width: 178px;height: 178px;cursor: pointer"/>
                                <i v-else class="el-icon-plus avatar-uploader-icon" @click="selectFile"></i>
                            </el-form-item>
                            <el-form-item label="排序" prop="sorts">
                                <el-input size="mini" v-model="temp.sorts" clearable/>
                            </el-form-item>
                            <el-form-item label="状态">
                                <el-radio-group v-model="temp.status">
                                    <el-radio :label="1">正常</el-radio>
                                    <el-radio :label="0">禁用</el-radio>
                                </el-radio-group>
                            </el-form-item>

                        </el-tab-pane>
                        <el-tab-pane label="文章详情">
                            <el-form-item label="详情" prop="content">
                                <el-input size="mini" v-model="temp.content" rows="20" type="textarea" clearable/>
                            </el-form-item>
                        </el-tab-pane>
                    </el-tabs>

                </el-form>
                <div class="demo-drawer__footer" style="position:fixed;top:15px;right:30px;">
                    <el-button  size="mini"  @click="$refs.drawer.closeDrawer()">取 消</el-button>
                    <el-button  size="mini"  :loading="btnLoading" type="primary" @click="saveData()">保存</el-button>
                </div>
            </div>
        </el-drawer>
        <File ref="file_upload" @getFileList="getFileList"></File>
    </div>
</template>

<script>
    import File from '@/components/File'
    import {getListAll} from '@/api/column'
    import {getListAll as getListAllCate} from '@/api/categery'
    import {getinfo, save} from '@/api/blog'
    import tree from '@/utils/tree'

    export default {
        name: 'BlogForm',
        components: {File},
        data() {
            return {
                btnLoading: false,
                columns: null,
                column_id: [],
                props_pid: {'label': 'name', 'value': 'id'},
                cates: null,
                temp: {
                    id: 0,
                    column_id: '',
                    cate_id: '',
                    title: '',
                    content: '',
                    status: 1,
                    sorts: 100,
                    img: '',
                    full_path: '',
                    image_key:''
                },
                config: {
                    fileName: 'img',
                    limit: 1,
                    multiple: true,
                    accept: 'image/*',
                    action: ''
                },
                dialogFormVisible: false,
                rules: {
                    column_id: [{required: true, message: '栏目必选', trigger: 'change'}],
                    cate_id: [{required: true, message: '分类必选', trigger: 'change'}],
                    title: [{required: true, message: '标题必填', trigger: 'blur'}],
                    content: [{required: true, message: '详情必填', trigger: 'blur'}]
                }

            }
        },
        computed: {
            getColumnList() {
                if (this.columns) {
                    return tree.listToTreeMulti(this.columns)
                } else {
                    return null
                }
            }
        },
        watch: {
            dialogFormVisible: function () {
                this.resetTemp()
            },
            temp: {
                handler(newVal, oldVal) {
                },
                immediate: true,
                deep: true
            }
        },
        created() {
            this.getColumns()
            this.getCates()
        },
        destroyed() {

        },
        methods: {
            input(v) {
                console.log(v)
            },
            selectFile: function () {
                const _this = this
                _this.$refs["file_upload"].openDialog('getFileList')
            },
            getFileList(rows) {
                const _this = this
                const row = rows[0]
                console.log(row)
                _this.temp.full_path = row.full_url
                _this.temp.img = row.file_url
                _this.temp.image_key = row.config_key
            },
            handleClose(done) {
                if (this.btnLoading) {
                    return
                }
                this.$confirm('更改将不会被保存，确定要取消吗？')
                    .then(_ => {
                        this.dialogFormVisible = false
                    })
                    .catch(_ => {
                    })
            },
            getColumns() {
                getListAll().then(response => {
                    this.columns = response.data.data
                })
            },
            getCates() {
                getListAllCate().then(response => {
                    this.cates = response.data.data
                })
            },
            resetTemp() {
                this.temp = {
                    id: 0,
                    column_id: '',
                    cate_id: '',
                    title: '',
                    content: '',
                    status: 1,
                    sorts: 100,
                    img: '',
                    full_path: '',
                    image_key: '',
                }
            },
            handleCreate() {
                this.dialogFormVisible = true
                this.btnLoading = false
                this.currentIndex = -1
                this.$nextTick(() => {
                    this.$refs['dataForm'].clearValidate()
                })
            },
            handleUpdate(id) {
                this.dialogFormVisible = true
                this.btnLoading = false
                const _this = this
                getinfo(id).then(response => {
                    if (response.status === 1) {
                        _this.temp.id = response.data.id
                        _this.temp.column_id = response.data.column_id
                        _this.temp.cate_id = response.data.cate_id
                        _this.temp.title = response.data.title
                        _this.temp.content = response.data.content
                        _this.temp.status = response.data.status
                        _this.temp.sorts = response.data.sorts
                        _this.temp.img = response.data.img
                        _this.temp.image_key = response.data.image_key
                        _this.temp.full_path = response.data.full_path
                        _this.column_id = tree.getParentsId(this.columns, response.data.column_id)
                        _this.column_id.push(response.data.column_id)
                    }
                })
                this.$nextTick(() => {
                    this.$refs['dataForm'].clearValidate()
                })
            },
            saveData() {
                this.btnLoading = true
                this.$refs['dataForm'].validate((valid) => {
                    if (valid) {
                        const _this = this
                        save(this.temp).then(response => {
                            if (response.status === 1) {
                                if (!_this.temp.id) {
                                    _this.temp.id = response.data.id
                                }
                                this.$emit('updateRow', _this.temp)
                                _this.dialogFormVisible = false
                                _this.$message.success(response.msg)
                            } else {
                                _this.$message.error(response.msg)
                            }
                            _this.btnLoading = false
                        }).catch((error) => {
                            _this.$message.error(error)
                            this.btnLoading = false
                        })
                    } else {
                        this.btnLoading = false
                    }
                })
            },
            handleChange(value) {
                if (value.length) {
                    this.temp.column_id = value[value.length - 1]
                }
            }
        }
    }
</script>
