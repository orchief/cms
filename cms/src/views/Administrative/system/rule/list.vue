<template>
	<div>
		<div class="m-b-20">
  		<router-link class="btn-link-large add-btn" to="add">
  		  <i class="el-icon-plus"></i>&nbsp;&nbsp;添加节点
  		</router-link>
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
			label="节点结构"
			width="150">
			</el-table-column>
			<el-table-column
			prop="title"
			label="显示名">
			</el-table-column>
  		<el-table-column
  		prop="name"
  		label="名称"
  		width="200">
  		</el-table-column>
      	<el-table-column
				fixed="right"
				label="状态"
				width="100">
					<template slot-scope="row">
						<div>
					      {{ row.row.status | status}}
				    </div>
					</template>
				</el-table-column>
      	<el-table-column
				fixed="right"
				label="日志"
				width="100">
					<template slot-scope="row">
						<div>
					      {{ row.row.isLog | status}}
				    </div>
					</template>
				</el-table-column>
			<el-table-column
			label="操作"
			width="200"
      fixed="right">
        <template slot-scope="row">
			<div>
  					<span class="icon_button">
  						<router-link :to="{ name: '编辑权限', params: { id: row.row.id }}">
  						<i class="el-icon-edit" title="编辑"></i>
  						</router-link>
  					</span>
				<span class="icon_button">
						<a href="javascript:;" @click="confirmDelete(row.row)">
							<i class="el-icon-delete" title="删除"></i>
						</a>
  					</span>
			</div>
        </template>
			</el-table-column>
		</el-table>
		<div class="pos-rel p-t-20">
			<btnGroup :selectedData="multipleSelection" :baseApi="'admin/rules'"></btnGroup>
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
            name: '权限规则'
          }
        ]
      },
      tableData: [],
      multipleSelection: []
    }
  },
  methods: {
    selectItem(val) {
      this.multipleSelection = val
    },
    confirmDelete(item) {
      this.$confirm('确认删除该权限?', '提示', {
        confirmButtonText: '确定',
        cancelButtonText: '取消',
        type: 'warning'
      })
        .then(() => {
          _g.openGlobalLoading()
          this.apiDelete('admin/rules/', item.id).then(res => {
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
          // handle error
        })
    }
  },
  created() {
    this.apiGet('admin/rules').then(res => {
      this.handelResponse(res, res => {
        console.log(res)
        this.tableData = res
      })
    })
  },
  computed: {
    addShow() {
      return _g.getHasRule('rules-save')
    },
    editShow() {
      return _g.getHasRule('rules-update')
    },
    deleteShow() {
      return _g.getHasRule('rules-delete')
    }
  },
  components: {
    btnGroup
  },
  mixins: [http]
}
</script>