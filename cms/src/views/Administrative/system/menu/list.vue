<template>
	<div>
		<div class="m-b-20">
  			<router-link class="btn-link-large add-btn" to="add">
  		  		<i class="el-icon-plus"></i>&nbsp;&nbsp;添加菜单
  			</router-link>
			<el-button @click="downloadXml()"><i class="el-icon-plus"></i>下载菜单xml</el-button>
		</div>
		<el-table
		:data="tableData"
		style="width: 100%"
		@selection-change="selectItem">
			<el-table-column
			type="selection"
			:context="_self"
			width="50">
			</el-table-column>
			<el-table-column
			prop="p_title"
			label="上级菜单"
			width="150">
			</el-table-column>
			<el-table-column
			prop="title"
			label="标题">
			</el-table-column>
			<el-table-column
			label="状态"
			width="100">
					<template slot-scope="row">
						{{ row.row.status | status}}
					</template>
			</el-table-column>
			<el-table-column
			label="操作"
			width="200"
			fixed="right"
			>
				<template slot-scope="row">
					<div>
					<span class="icon_button">
						<router-link :to="{ name: '编辑菜单', params: { id: row.row.id }}">
							<i class="el-icon-edit" title="编辑"></i>
						</router-link>
					</span>
						<span class="icon_button">
						<a href="javascript:;" @click="confirmDelete(row.row)"><i class="el-icon-delete" title="删除"></i></a>
					</span>
					</div>
				</template>
			</el-table-column>
		</el-table>
		<div class="pos-rel p-t-20">
			<btnGroup :selectedData="multipleSelection" :baseApi="'admin/menus'"></btnGroup>

		</div>
	</div>
</template>

<script>
import btnGroup from 'components/Common/btn-group.vue'
import http from 'assets/js/http'

export default {
  data() {
    return {
      config: {
        crumb: [
          {
            to: '',
            name: '系统'
          },
          {
            to: '',
            name: '系统配置'
          },
          {
            to: '',
            name: '菜单管理'
          }
        ]
      },
      tableData: [],
      multipleSelection: [],
      fileList: [],
      IsShow: false
    }
  },
  methods: {
    downloadXml() {
      // 请求后台数据 并生成xml文件
      this.apiGet('admin/menus/xml').then(res => {
        _g.closeGlobalLoading()
        this.handelResponse(res, data => {
          this.downloadFile('菜单.xml', data);
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
    confirmDelete(item) {
      this.$confirm('确认删除该菜单?', '提示', {
        confirmButtonText: '确定',
        cancelButtonText: '取消',
        type: 'warning'
      })
        .then(() => {
          this.apiDelete('admin/menus/', item.id).then(res => {
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
    uploadSuccess(data) {
      _g.shallowRefresh(this.$route.name)
      _g.toastMsg('success', '配置成功!')
    }
  },
  created() {
    this.apiGet('admin/menus').then(res => {
      // this.tableData = res
      this.handelResponse(res, res => {
        this.tableData = res
      })
    })
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
  components: {
    btnGroup
  },
  mixins: [http]
}
</script>