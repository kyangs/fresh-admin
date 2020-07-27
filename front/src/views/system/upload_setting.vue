<template>
    <div class="app-container">
        <!--数据-->
        <el-tabs v-model="activeName">
            <el-tab-pane name="aliyun">
                <span slot="label"><i class="el-icon-document"/>
                    阿里云
                    <span v-if="uploadForm.default==='aliyun'">(默认)</span>
                </span>
                <el-form ref="form" :model="uploadForm.aliyun" label-width="300px">
                    <el-form-item label="阿里云（accessKeyId ）">
                        <el-input v-model="uploadForm.aliyun.accessKeyId"></el-input>
                    </el-form-item>
                    <el-form-item label="阿里云（accessKeySecret ）">
                        <el-input v-model="uploadForm.aliyun.accessKeySecret"></el-input>
                    </el-form-item>
                    <el-form-item label="阿里云（Endpoint ）">
                        <el-input v-model="uploadForm.aliyun.endpoint"></el-input>
                    </el-form-item>
                    <el-form-item label="阿里云（BucketName ）">
                        <el-input v-model="uploadForm.aliyun.bucket"></el-input>
                    </el-form-item>
                    <el-form-item label="阿里云（Http路径 ）">
                        <el-input v-model="uploadForm.aliyun.http"></el-input>
                    </el-form-item>
                    <el-form-item label="是否默认使用">
                        <el-radio v-model="uploadForm.default" label="aliyun">默认</el-radio>
                    </el-form-item>
                </el-form>
            </el-tab-pane>
            <el-tab-pane name="qiniuyun">
                <span slot="label"><i class="el-icon-document"></i>
                    七牛云
                    <span v-if="uploadForm.default==='qiniuyun'">(默认)</span>
                    </span>
                <el-form ref="form" :model="uploadForm.qiniuyun" label-width="300px">
                    <el-form-item label="七牛云（Access_Key ）">
                        <el-input v-model="uploadForm.qiniuyun.accessKeyId"></el-input>
                    </el-form-item>
                    <el-form-item label="七牛云（Secret_Key ）">
                        <el-input v-model="uploadForm.qiniuyun.accessKeySecret"></el-input>
                    </el-form-item>
                    <el-form-item label="七牛云（Endpoint ）">
                        <el-input v-model="uploadForm.qiniuyun.endpoint"></el-input>
                    </el-form-item>
                    <el-form-item label="七牛云（BucketName ）">
                        <el-input v-model="uploadForm.qiniuyun.bucket"></el-input>
                    </el-form-item>
                    <el-form-item label="七牛云（Http路径 ）">
                        <el-input v-model="uploadForm.qiniuyun.http"></el-input>
                    </el-form-item>
                    <el-form-item label="是否默认使用">
                        <el-radio v-model="uploadForm.default" label="qiniuyun">默认</el-radio>
                    </el-form-item>
                </el-form>
            </el-tab-pane>
<!--            <el-tab-pane name="txyun">-->
<!--                <span slot="label"><i class="el-icon-document"></i>-->
<!--                    腾讯云-->
<!--                <span v-if="uploadForm.default==='txyun'">(默认)</span>-->
<!--                </span>-->
<!--                <el-form ref="form" :model="uploadForm.txyun" label-width="300px">-->
<!--                    <el-form-item label="腾讯云（SecretId ）">-->
<!--                        <el-input v-model="uploadForm.txyun.accessKeyId"></el-input>-->
<!--                    </el-form-item>-->
<!--                    <el-form-item label="腾讯云（SecretKey ）">-->
<!--                        <el-input v-model="uploadForm.txyun.accessKeySecret"></el-input>-->
<!--                    </el-form-item>-->
<!--                    <el-form-item label="腾讯云（Endpoint ）">-->
<!--                        <el-input v-model="uploadForm.txyun.endpoint"></el-input>-->
<!--                    </el-form-item>-->
<!--                    <el-form-item label="腾讯云（Region ）">-->
<!--                        <el-input v-model="uploadForm.txyun.region"></el-input>-->
<!--                    </el-form-item>-->
<!--                    <el-form-item label="腾讯云（Token ）">-->
<!--                        <el-input v-model="uploadForm.txyun.token"></el-input>-->
<!--                    </el-form-item>-->
<!--                    <el-form-item label="腾讯云（Http路径 ）">-->
<!--                        <el-input v-model="uploadForm.txyun.http"></el-input>-->
<!--                    </el-form-item>-->
<!--                    <el-form-item label="是否默认使用">-->
<!--                        <el-radio v-model="uploadForm.default" label="txyun">默认</el-radio>-->
<!--                    </el-form-item>-->
<!--                </el-form>-->
<!--            </el-tab-pane>-->
            <el-tab-pane name="minio">
                <span slot="label"><i class="el-icon-document"></i>
                Minio<span v-if="uploadForm.default==='minio'">(默认)</span>
                </span>
                <el-form ref="form" :model="uploadForm.minio" label-width="300px">
                    <el-form-item label="Minio（用户名 ）">
                        <el-input v-model="uploadForm.minio.userName"></el-input>
                    </el-form-item>
                    <el-form-item label="Minio（密码 ）">
                        <el-input v-model="uploadForm.minio.password"></el-input>
                    </el-form-item>
                    <el-form-item label="Minio（上传地址 ）">
                        <el-input v-model="uploadForm.minio.endpoint"></el-input>
                    </el-form-item>
                    <el-form-item label="Minio（BucketName ）">
                        <el-input v-model="uploadForm.minio.bucket"></el-input>
                    </el-form-item>
                    <el-form-item label="Minio（Http路径 ）">
                        <el-input v-model="uploadForm.minio.http"></el-input>
                    </el-form-item>
                    <el-form-item label="是否默认使用">
                        <el-radio v-model="uploadForm.default" label="minio">默认</el-radio>
                    </el-form-item>
                </el-form>
            </el-tab-pane>
        </el-tabs>
        <el-row>
            <el-button type="primary" @click="onSubmit">保存</el-button>
        </el-row>
    </div>

</template>

<script>
    import request from '@/utils/jsonrequest'

    export default {
        name: 'upload_setting',
        data() {
            return {
                activeName: 'aliyun',
                newForm: {},
                uploadForm: {
                    aliyun: {
                        accessKeyId: '',
                        accessKeySecret: '',
                        endpoint: '',
                        bucket: '',
                    },
                    qiniuyun: {
                        accessKeyId: '',
                        accessKeySecret: '',
                        endpoint: '',
                        bucket: '',
                    },
                    txyun: {
                        accessKeyId: '',
                        accessKeySecret: '',
                        endpoint: '',
                        region: '',
                        token: '',
                    },
                    minio: {
                        userName: '',
                        password: '',
                        endpoint: '',
                        bucket: '',
                    },
                    default: 'aliyun'
                },
            }
        },
        created() {
            this.getSetting()
        },
        methods: {
            getSetting() {
                const _this = this
                request({
                    url: '/admin/system/setting',
                    method: 'post',
                    data: {key: "upload"}
                }).then(function (res) {
                    if (res.code === 10000) {
                        console.log(res.data)
                        if (Object.keys(res.data).length===0) return
                        _this.uploadForm = res.data
                        _this.activeName = _this.uploadForm.default
                    }
                })
            },
            onSubmit() {
                const _this = this
                request({
                    url: '/admin/system/upload/setting',
                    method: 'post',
                    data: _this.uploadForm
                }).then(function (res) {
                    if (res.code === 10000) {
                        _this.$message.success('保存成功')
                        return
                    }
                    _this.$message.error('保存失败')
                })
            },
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
