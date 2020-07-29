<template>
  <div class="app-container">
    <el-form ref="dataForm" :model="temp" label-position="left" label-width="70px" style="width: 50%; ">
      <el-form-item label="角色" prop="group_id">
        <el-input size="mini" v-model="group" :disabled="true" />
      </el-form-item>
      <el-form-item label="账号" prop="username">
        <el-input size="mini" v-model="name" :disabled="true" />
      </el-form-item>
      <el-form-item label="密码" prop="password">
        <el-input size="mini" v-model="temp.password" clearable placeholder="不修改，则留空" />
      </el-form-item>
      <el-form-item label="头像" prop="img">
        <el-upload
                class="avatar-uploader"
                action=""
                :show-file-list="false"
                :http-request="uploadImage">
          <img v-if="temp.full_url" :src="temp.full_url" class="avatar">
          <i v-else class="el-icon-plus avatar-uploader-icon"></i>
        </el-upload>
      </el-form-item>
      <el-form-item label="姓名" prop="realname">
        <el-input size="mini" v-model="temp.realname" clearable />
      </el-form-item>
      <el-form-item label="手机" prop="phone">
        <el-input size="mini" v-model="temp.phone" clearable />
      </el-form-item>
      <el-form-item label="邮箱" prop="email">
        <el-input size="mini" v-model="temp.email" clearable />
      </el-form-item>
    </el-form>
    <el-button  size="mini" :loading="btnLoading" type="primary" @click="saveData()">保存</el-button>
  </div>
</template>

<script>
import { modify } from '@/api/user'
import { mapGetters } from 'vuex'
import store from '@/store'

import request from '@/utils/jsonrequest'

export default {
  name: 'MyInfo',
  data() {
    return {
      btnLoading: false,
      temp: {
        password: '',
        realname: store.getters.realname,
        phone: store.getters.phone,
        email: store.getters.email,
        img: store.getters.avatar,
        full_url: store.getters.full_avatar,
        image_key: '',
      },
      config: {
        fileName: 'img',
        limit: 1,
        multiple: true,
        accept: 'image/*',
        action: ''
      },
    }
  },
  computed: {
    ...mapGetters([
      'name',
      'group'
    ])
  },
  watch: {
    temp: {
      handler(newVal, oldVal) {},
      immediate: true,
      deep: true
    }
  },
  created() {

  },
  destroyed() {

  },
  methods: {
    uploadImage: function (file) {
      const formData = new FormData(); // 生成文件对象
      formData.append('file', file.file)
      const _this = this
      request({
        headers: {
          'enctype': 'multipart/form-data'
        },
        url: '/admin/upload/avatar',
        method: 'post',
        data: formData
      }).then(function (res) {
        _this.temp.img = res.data.path
        _this.temp.full_url = res.data.full_url
        _this.temp.image_key = res.data.config_key
      })
    },
    saveData() {
      this.btnLoading = true
      this.$refs['dataForm'].validate((valid) => {
        if (valid) {
          const _this = this
          modify(this.temp).then(response => {
            if (response.status === 1) {
              store.commit('SET_AVATAR', _this.temp.img)
              store.commit('SET_FULL_AVATAR', _this.temp.full_avatar)
              store.commit('SET_REALNAME', _this.temp.realname)
              store.commit('SET_PHONE', _this.temp.phone)
              store.commit('SET_EMAIL', _this.temp.email)
              _this.$message.success(response.msg)
            } else {
              _this.$message.error(response.msg)
            }
            _this.btnLoading = false
          // eslint-disable-next-line handle-callback-err
          }).catch((error) => {
            this.btnLoading = false
          })
        } else {
          this.btnLoading = false
        }
      })
    }
  }
}
</script>
<style>
  .avatar-uploader .el-upload {
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
    width: 178px;
    height: 178px;
    line-height: 178px;
    text-align: center;
  }
  .avatar {
    width: 178px;
    height: 178px;
    display: block;
  }
</style>
