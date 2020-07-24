<template>
    <div class="app-container">
        <!--数据-->
        <el-tabs v-model="activeName" @tab-click="handleClick">
            <el-tab-pane name="aliyun" label="阿里云">
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
                    <el-form-item label="是否默认使用">
                        <el-radio v-model="uploadForm.default" label="aliyun">默认</el-radio>
                    </el-form-item>
                </el-form>
            </el-tab-pane>
            <el-tab-pane label="七牛云" name="qiniuyun">
                <el-form ref="form" :model="uploadForm.qiniuyun" label-width="200px">
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
                    <el-form-item label="是否默认使用">
                        <el-radio v-model="uploadForm.default" label="qiniuyun">默认</el-radio>
                    </el-form-item>
                </el-form>
            </el-tab-pane>
            <el-tab-pane label="腾讯云" name="txyun">
                <el-form ref="form" :model="uploadForm.txyun" label-width="200px">
                    <el-form-item label="腾讯云（SecretId ）">
                        <el-input v-model="uploadForm.txyun.accessKeyId"></el-input>
                    </el-form-item>
                    <el-form-item label="腾讯云（SecretKey ）">
                        <el-input v-model="uploadForm.txyun.accessKeySecret"></el-input>
                    </el-form-item>
                    <el-form-item label="腾讯云（Endpoint ）">
                        <el-input v-model="uploadForm.txyun.endpoint"></el-input>
                    </el-form-item>
                    <el-form-item label="腾讯云（Region ）">
                        <el-input v-model="uploadForm.txyun.region"></el-input>
                    </el-form-item>
                    <el-form-item label="腾讯云（Token ）">
                        <el-input v-model="uploadForm.txyun.token"></el-input>
                    </el-form-item>
                    <el-form-item label="是否默认使用">
                        <el-radio v-model="uploadForm.default" label="txyun">默认</el-radio>
                    </el-form-item>
                </el-form>
            </el-tab-pane>
            <el-tab-pane label="Minio" name="minio">
                <el-form ref="form" :model="uploadForm.minio" label-width="200px">
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
                        <el-input v-model="uploadForm.qiniuyun.bucket"></el-input>
                    </el-form-item>
                    <el-form-item label="是否默认使用">
                        <el-radio v-model="uploadForm.default" label="minio">默认</el-radio>
                    </el-form-item>
                </el-form>
            </el-tab-pane>
        </el-tabs>
        <el-button type="primary" @click="onSubmit">保存</el-button>
    </div>

</template>

<script>
    import request from '@/utils/jsonrequest'

    export default {
        name: 'upload_setting',
        data() {
            return {
                activeName: 'aliyun',
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
                    default:'aliyun'
                },
            }
        },
        created() {

        },
        methods: {
            onSubmit(){

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
