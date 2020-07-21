<template>
    <div class="app-container">
        <el-collapse v-model="activeNames">
            <el-form ref="form" :model="form" label-width="180px" style="border-radius: 4px">
                <el-collapse-item title="商品详情" name="1">
                    <template slot="title">
                        <span class="form-header">基本信息</span>
                    </template>
                    <el-form-item label="商品名称">
                        <el-input v-model="form.goods_name"></el-input>
                    </el-form-item>
                    <el-form-item label="商品分类">
                        <el-select v-model="form.cate_id"
                                   clearable
                                   filterable
                                   @change="selectCate">
                            <el-option v-for="v in init.cate_list"
                                       :key="v.id" :label="v.name"
                                       :value="v.id"></el-option>
                        </el-select>
                        <el-select v-if="init.children_list.length > 0"
                                   clearable
                                   filterable
                                   v-model="form.child_cate_id">
                            <el-option v-for="v in init.children_list"
                                       :key="v.id" :label="v.name"
                                       :value="v.id"></el-option>
                        </el-select>
                    </el-form-item>
                    <el-form-item label="主图">
                        <el-row :gutter="20">
                            <el-col :span="3">
                                <img v-if="form.main_image" :src="form.main_image" @click="selectMainFile"
                                     class="avatar">
                                <i v-else class="el-icon-plus avatar-uploader-icon" @click="selectMainFile"></i>
                            </el-col>
                        </el-row>
                    </el-form-item>
                    <el-form-item label="轮播图">
                        <el-row :gutter="20">
                            <el-col :span="3">
                                <i class="el-icon-plus avatar-uploader-icon" @click="selectFile"></i>
                            </el-col>
                            <el-col v-for="(v) in form.image_list" :span="3">
                                <img :src="v.full_url" class="avatar"></el-col>
                        </el-row>
                    </el-form-item>
                </el-collapse-item>
                <el-collapse-item title="商品详情" name="2">
                    <template slot="title">
                        <span class="form-header">价格/库存</span>
                    </template>
                    <el-form-item label="商品价格">
                        <el-input-number v-model="form.price"
                                         :min="0.01"
                                         :step="1.00"
                                         :precision="2"
                                         controls-position="right" :max="10000000">

                        </el-input-number>
                    </el-form-item>
                    <el-form-item label="商品划线价">
                        <el-input-number v-model="form.origin_price"
                                         :min="0.00"
                                         :step="1.00"
                                         :precision="2"
                                         controls-position="right" :max="10000000">

                        </el-input-number>
                    </el-form-item>
                    <el-form-item label="当前库存数量">
                        <el-input-number v-model="form.stock"
                                         :min="1"
                                         :step="1"
                                         controls-position="right" :max="10000000">

                        </el-input-number>
                    </el-form-item>
                    <el-form-item label="商品排序">
                        <el-input-number v-model="form.sort"
                                         :min="1"
                                         :step="1"
                                         controls-position="right" :max="10000000">

                        </el-input-number>
                    </el-form-item>
                    <el-form-item label="商品状态">
                        <el-switch
                                v-model="form.is_enabled"
                                active-text="上架"
                                :active-value="1"
                                :inactive-value="0"
                                inactive-text="下架">
                        </el-switch>
                    </el-form-item>
                </el-collapse-item>
                <el-collapse-item title="商品详情" name="3">
                    <template slot="title">
                        <span class="form-header">商品详情</span>
                    </template>

                    <el-form-item label="商品详情图片">
                        <el-row :gutter="20">
                            <el-col :span="3">
                                <i class="el-icon-plus avatar-uploader-icon" @click="selectDetailFile"></i>
                            </el-col>
                            <el-col v-for="(v) in form.detail_images" :span="3">
                                <img :src="v.full_url" class="avatar"></el-col>
                        </el-row>
                    </el-form-item>
                    <el-form-item label="商品属性">
                        <el-row  :gutter="20">
                            <el-col :span="6">
                                <el-link type="primary" @click="addAttr">新增</el-link>
                            </el-col>
                        </el-row>
                        <el-row :gutter="20" style="padding: 5px" v-for="(attr,index) in form.attr_list">
                            <el-col :span="6">
                                <el-input v-model="attr.attr_name">
                                    <template slot="prepend">属性名</template>
                                </el-input>
                            </el-col>
                            <el-col :span="6">
                                <el-input v-model="attr.attr_value">
                                    <template slot="prepend">属性值</template>
                                </el-input>
                            </el-col>
                            <el-col :span="6">
                                <el-link type="danger" @click="delAttr(index)">删除</el-link>
                            </el-col>
                            <p></p>
                        </el-row>

                    </el-form-item>
                    <el-form-item label="商品详情">
                        <el-input
                                type="textarea"
                                placeholder="请输入商品详情"
                                v-model="form.detail"
                                :rows="10"
                                :autosize="{ minRows: 10, maxRows: 20}"
                                show-word-limit>
                        </el-input>
                    </el-form-item>
                </el-collapse-item>
            </el-form>
        </el-collapse>
        <p style="float: right">
            <el-button type="success" @click="createGoods">提 交</el-button>
        </p>
        <File ref="file_upload_1" @getMainFileList="getMainFileList"></File>
        <File ref="file_upload_2" @getFileList="getFileList"></File>
        <File ref="file_upload_3" @getDetailFiles="getDetailFiles"></File>
    </div>
</template>

<script>
    import File from '@/components/File'

    import request from '@/utils/jsonrequest'

    export default {
        name: 'Create',
        components: {File},
        data() {
            return {
                activeNames: ['1', '2', '3'],
                form: {
                    id: 0,
                    price: 1.00,
                    origin_price: 0,
                    stock: 1,
                    sort: 100,
                    is_enabled: 1,
                    goods_name: '',
                    status: '-1',
                    title: '',
                    cate_id: '',
                    child_cate_id: '',
                    column_id: '',
                    main_image: '',
                    main_image_id: 0,
                    end_time: '',
                    tag: '',
                    detail: '',
                    main_image_url: '',
                    tag_list: [],
                    image_list: [],
                    detail_images: [],
                    attr_list: [],
                    detail_images_id: [],
                    image_id_list: [],
                    carousel_image: [],
                    detail_image: [],
                    store_id: '',
                },
                init: {
                    cate_list: [],
                    children_list: [],
                },
                reset_form: {}
            }
        },
        created() {
            let query = this.$route.query

            const _this = this

            Object.assign(_this.reset_form, _this.form)
            request({
                url: "/admin/category/list",
                method: 'post',
                data: {is_enabled: 1}
            }).then(res => {
                _this.init.cate_list = res.data
            })
            if (query.id) {
                request({
                    url: "/admin/goods/info",
                    method: 'POST',
                    data: {id: query.id}
                }).then(res => {
                    Object.assign(_this.form, res.data)
                    if (parseInt(_this.form.child_cate_id) > 0) {
                        _this.selectCate(_this.form.cate_id)
                    }
                })
            }
        },
        methods: {
            addAttr() {
                const _this = this
                _this.form.attr_list.push({
                    attr_name: '',
                    attr_value: ''
                })
            },
            delAttr(index) {
                const _this = this
                _this.form.attr_list.splice(index, 1)
            },
            createGoods() {
                const _this = this
                request({
                    url: "/admin/goods/save",
                    method: 'post',
                    data: _this.form
                }).then(res => {
                    if (res.code === 10000) {
                        this.$confirm('保存成功', '提示', {
                            confirmButtonText: '返回商品列表页',
                            cancelButtonText: '继续添加',
                            type: 'success'
                        }).then(() => {
                            _this.$router.push('/goods/list')
                        }).catch(() => {
                            Object.assign(_this.form, _this.reset_form)
                        });
                    }
                })
            },
            selectCate(v) {
                const _this = this
                _this.init.children_list = []
                _this.init.cate_list.forEach(row => {
                    if (row.id === v) {
                        _this.init.children_list = row.children
                    }
                })
            },
            getFileList(rows) {
                this.form.image_list = rows
                const _this = this
                _this.form.image_list.forEach(row => {
                    _this.form.image_id_list.push(row.id)
                })
            },
            getDetailFiles(rows) {
                this.form.detail_images = rows
                const _this = this
                _this.form.detail_images.forEach(row => {
                    _this.form.detail_images_id.push(row.id)
                })
            },
            addGoodsTag() {
                if (this.form.tag === '') return
                if (this.form.tag_list.length >= 2) return
                for (let i = 0; i < this.form.tag_list.length; i++) {
                    if (this.form.tag_list[i] === this.form.tag) {
                        return
                    }
                }
                this.form.tag_list.push(this.form.tag)
            },
            getMainFileList(rows) {
                const _this = this
                const row = rows[0]
                _this.form.main_image = row.full_url
                _this.form.main_image_id = row.id
            },
            selectFile: function () {
                const _this = this
                _this.$refs["file_upload_2"].openDialog('getFileList')
            },
            selectDetailFile: function () {
                const _this = this
                _this.$refs["file_upload_3"].openDialog('getDetailFiles')
            },
            selectMainFile: function () {
                const _this = this
                _this.$refs["file_upload_1"].openDialog('getMainFileList')
            },
        }
    }
</script>
<style>
    .avatar-uploader-icon {
        font-size: 16px;
        cursor: pointer;
        border: 1px solid darkgray;
        color: #8c939d;
        width: 108px;
        height: 108px;
        line-height: 108px;
        text-align: center;
    }

    .avatar {
        cursor: pointer;
        width: 108px;
        height: 108px;
        display: block;
    }

    .form-header {
        font-weight: bold;
        font-size: 16px;
    }
</style>
