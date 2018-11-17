<template>
    <div>
        <div class="m-b-20">
            <el-button class="btn-link-large add-btn" v-on:click="addBackup()">
                新增备份
            </el-button>
        </div>
        <el-table
                :data="tableData"
                type="index"
                style="width: 100%"
                @selection-change="selectItem">
            <el-table-column
                    prop="name"
                    label="文件名">
            </el-table-column>
            <el-table-column
                    prop="time"
                    label="时间">
            </el-table-column>
            <el-table-column
                    prop="size"
                    label="大小">
            </el-table-column>

            <!-- 操作 -->
            <el-table-column label="操作"  width="300" fixed="right">
                <template slot-scope="row">
						<span class="icon_button">
						    <a href="javascript:;" class="opration" @click="downloadsql(row)" title="下载"><icon class="download-icon" name="download" ></icon></a>
					    </span>
                    <span class="icon_button">
						    <a href="javascript:;" class="opration" @click="confirmRecovery(row)" title="恢复"><icon class="recover-icon" name="recover" ></icon></i></a>
					    </span>
                    <span class="icon_button">
                            <a href="javascript:;" class="opration" @click="confirmDelete(row)"><i class="el-icon-delete" title="删除"></i></a>
					    </span>
                </template>
            </el-table-column>

        </el-table>
        <div class="pos-rel p-t-20">
            <div class="block-pages block pages">
                <el-pagination
                        @current-change="handleCurrentChange"
                        layout="total, prev, pager, next, jumper"
                        :page-size="limit"
                        :current-page="currentPage"
                        :total="dataCount">
                </el-pagination>
            </div>
        </div>
    </div>
</template>

<script>
import btnGroup from 'components/Common/btn-group.vue'
import http from 'assets/js/http'
export default {
  data() {
    return {
      tableData: [],
      multipleSelection: [],
      fileList: [],
      IsShow: false,
      limit: 10,
      currentPage: null,
      dataCount: null,
      SqlURI: null
    }
  },
  methods: {
    downloadsql(data) {
      // 请求后台数据 并生成xml文件
      this.apiGet('admin/database', {
            params: { name: data.row.name, tp: 'dowonload' }
          }).then(res => {
        _g.closeGlobalLoading()
        this.handelResponse(res, data => {
          this.downloadFile('backup.sql', data);
        })
      })
    },
    downloadFile(fileName, content){
      var eleLink = document.createElement('a');
      eleLink.download = fileName;
      eleLink.style.display = 'none';
      // 字符内容转变成blob地址
      var blob = new Blob([content]);
      eleLink.href = URL.createObjectURL(blob);
      // 触发点击
      document.body.appendChild(eleLink);
      eleLink.click();
      // 然后移除
      document.body.removeChild(eleLink);
    },
    selectItem(val) {
      this.multipleSelection = val
    },
    handleCurrentChange(page) {
      router.push({
        path: this.$route.path,
        query: { keywords: this.keywords, page: page }
      })
    },
    confirmRecovery(data) {
      this.$confirm('确认恢复该备份?', '提示', {
        confirmButtonText: '确定',
        cancelButtonText: '取消',
        type: 'warning'
      })
        .then(() => {
          this.apiGet('admin/database', {
            params: { name: data.row.name, tp: 'restore' }
          }).then(res => {
            _g.closeGlobalLoading()
            this.handelResponse(res, data => {
              _g.toastMsg('success', '恢复成功!')
            })
          })
        })
        .catch(() => {
          // handel error
        })
    },
    addBackup(item) {
      this.$confirm('确认新增备份?', '提示', {
        confirmButtonText: '确定',
        cancelButtonText: '取消',
        type: 'warning'
      })
        .then(() => {
          this.apiGet('admin/database', {
            params: { tp: 'backup' }
          }).then(res => {
            _g.closeGlobalLoading()
            this.handelResponse(res, data => {
              _g.toastMsg('success', '备份成功!')
              setTimeout(() => {
                _g.shallowRefresh(this.$route.name)
              }, 1500)
            })
          })
        })
        .catch(() => {
          // handel error
        })
    },
    confirmDelete(item) {
      this.$confirm('确认删除该备份?', '提示', {
        confirmButtonText: '确定',
        cancelButtonText: '取消',
        type: 'warning'
      })
        .then(() => {
          this.apiGet('admin/database', {
            params: { name: item.row.name, tp: 'del' }
          }).then(res => {
            _g.closeGlobalLoading()
            this.handelResponse(res, data => {
              _g.toastMsg('success', '删除成功')
              setTimeout(() => {
                _g.shallowRefresh(this.$route.name)
              }, 1500)
            })
          })
        })
        .catch(() => {
          // handel error
        })
    },
    handleRemove(file, fileList) {
      console.log(file, fileList)
    },
    handlePreview(file) {
      _g.shallowRefresh(this.$route.name)
      this.fileList = []
      console.log(file)
    },
    getCurrentPage() {
      const data = this.$route.query
      if (data) {
        if (data.page) {
          this.currentPage = parseInt(data.page)
        } else {
          this.currentPage = 1
        }
      }
    },
    getPageList() {
      this.apiGet('admin/database', {
        params: { page: this.currentPage, limit: this.limit }
      }).then(res => {
        this.handelResponse(res, data => {
          this.tableData = data.list
          this.dataCount = data.dataCount
        })
      })
    },
    init() {
      this.getCurrentPage()
      this.getPageList()
    }
  },
  created() {
    this.init()
  },
  computed: {
    addShow() {
      return _g.getHasRule('menus-save')
    },
    editShow() {
      return _g.getHasRule('menus-update')
    },
    deleteShow() {
      return _g.getHasRule('menus-delete')
    }
  },
  watch: {
    $route(to, from) {
      this.init()
    }
  },
  components: {
    btnGroup,
  },
  mixins: [http]
}
</script>

<style>
.block-pages {
  margin-bottom: 20px !important;
}
</style>
