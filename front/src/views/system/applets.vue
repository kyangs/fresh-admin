<template>
    <div class="app-container">
        <!--数据-->
        <el-container>
            <el-tabs v-model="activeName">
                <el-tab-pane name="base" label="小程序设置">
                    <el-form ref="form" :model="form.base" label-width="200px">
                        <el-form-item label="AppID 小程序ID">
                            <el-input v-model="form.base.appID"></el-input>
                        </el-form-item>
                        <el-form-item label="AppSecret 小程序密钥">
                            <el-input v-model="form.base.appSecret"></el-input>
                        </el-form-item>
                    </el-form>
                </el-tab-pane>
                <el-tab-pane name="pay" label="微信支付设置">
                    <el-form ref="form" :model="form.pay" label-width="200px">
                        <el-form-item label="微信支付商户号 MCHID">
                            <el-input v-model="form.pay.mchID"></el-input>
                        </el-form-item>
                        <el-form-item label="微信支付密钥 APIKEY">
                            <el-input v-model="form.pay.apiKey"></el-input>
                        </el-form-item>
                    </el-form>
                </el-tab-pane>
            </el-tabs>
            <el-footer>
                <el-row>
                    <el-button type="primary" round @click="onSubmit">保存</el-button>
                </el-row>
            </el-footer>
        </el-container>
    </div>

</template>

<script>
    import request from '@/utils/jsonrequest'

    export default {
        name: 'applets',
        data() {
            return {
                activeName: 'base',
                newForm: {},
                form: {
                    base: {
                        appID: '',
                        appSecret: '',
                    },
                    pay: {
                        mchID: '',
                        apiKey: '',
                    },
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
                    url: '/admin/system/setting/applets',
                    method: 'get',
                    data: {}
                }).then(function (res) {
                    if (res.code === 10000) {
                        console.log(res.data)
                        if (Object.keys(res.data).length === 0) return
                        _this.form = res.data
                    }
                })
            },
            onSubmit() {
                const _this = this
                let param = {
                    form: _this.form,
                    intro: '小程序信号设置'
                }
                request({
                    url: '/admin/system/setting/applets',
                    method: 'post',
                    data: param
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

    .el-footer {
        text-align: right;
    }
</style>
