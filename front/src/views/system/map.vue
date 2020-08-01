<template>
    <div class="app-container">
        <!--数据-->
        <el-container>
            <el-tabs v-model="activeName">
                <el-tab-pane name="base" label="高德地图API设置">
                    <el-form ref="form"  :model="form"
                            :inline="true" size="mini">
                        <el-form-item label="应用Key名称">
                            <el-input size="mini" placeholder="" v-model="form.keyName"></el-input>
                        </el-form-item>
                        <el-form-item label="应用Key">
                            <el-input size="mini" style="width: 100%" placeholder="一串加密的东西"  v-model="form.key"></el-input>
                        </el-form-item>
                        <el-form-item label="API请求地址">
                            <el-input size="mini" style="width: 100%" placeholder="https://restapi.amap.com/v3/geocode/geo"
                                      v-model="form.url"></el-input>
                        </el-form-item>
<!--                        <el-form-item label="">-->
<!--                            <el-link class="el-icon-delete" size="mini" type="danger" @click="deleteSetting(index)" round v-if="index>0"></el-link>-->
<!--                        </el-form-item>-->
                    </el-form>
                </el-tab-pane>
            </el-tabs>
            <el-footer>
                <el-row>
<!--                    <el-button size="mini" round @click="addSetting">新增</el-button>-->
                    <el-button size="mini" type="primary" round @click="onSubmit">保存</el-button>
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
                form:
                    {
                        keyName: '',
                        key: '',
                        url: '',
                    },
            }
        },
        created() {
            this.getSetting()
        },
        methods: {

            addSetting(){
                this.formList.push({
                    keyName: '',
                    key: '',
                    url: '',
                })
            },

            // deleteSetting(index){
            //     this.formList.splice(index,1)
            // },
            getSetting() {
                const _this = this
                request({
                    url: '/admin/system/setting/map',
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
                    intro: '地图API设置'
                }
                request({
                    url: '/admin/system/setting/map',
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

</style>
