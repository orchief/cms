<template>
	<div>
		<div class="m-b-20">
			<router-link class="btn-link-large add-btn" to="add">
				<i class="el-icon-plus"></i>&nbsp;&nbsp;添加岗位
			</router-link>
		</div>
		<el-table
		:data="tableData"
		style="width: 100%"
		@selection-change="selectChangeItem">
			<el-table-column
			type="selection"
			width="50">
			</el-table-column>
			<el-table-column
			label="岗位名称"
			prop="name">
			</el-table-column>
			<el-table-column
			label="备注"
			prop="remark">
			</el-table-column>
			<el-table-column
			label="状态"
      prop="status"
			width="100">
        <template scope="scope">
          <div>
            {{ scope.row.status | status }}
          </div>
        </template>
			</el-table-column>
			<el-table-column
			label="操作"
			width="200">
        <template scope="scope">
			<div>
				<span class="icon_button">
  						<router-link :to="{ name: '编辑岗位', params: { id: scope.row.id }}">
  						<i class="el-icon-edit" title="编辑"></i>
  						</router-link>
				</span>
				<span class="icon_button">
					<a href="javascript:;" @click="confirmDelete(scope.row)">
						<i class="el-icon-delete" title="删除"></i>
					</a>
				</span>
			</div>
        </template>
			</el-table-column>
		</el-table>
		<div class="pos-rel p-t-20">
			<btnGroup :selectedData="multipleSelection" :baseApi="'admin/posts'"></btnGroup>
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
            name: '组织构架'
          },
          {
            to: '',
            name: '岗位管理'
          }
        ]
      },
      tableData: [],
      multipleSelection: []
    }
  },
  methods: {
    selectChangeItem(val) {
      this.multipleSelection = val
    },
    confirmDelete(item) {
      this.$confirm('确认删除该岗位?', '提示', {
        confirmButtonText: '确定',
        cancelButtonText: '取消',
        type: 'warning'
      })
        .then(() => {
          _g.openGlobalLoading()
          this.apiDelete('admin/posts/', item.id).then(res => {
            _g.closeGlobalLoading()
            this.handelResponse(res, data => {
              _g.toastMsg('success', '删除成功')
              setTimeout(() => {
                _g.shallowRefresh(this.$route.name)
              }, 1500)
            })
          })
        })
        .catch(() => {})
    },
    getPositions() {
      this.apiGet('admin/posts').then(res => {
        this.handelResponse(res, data => {
          this.tableData = data
        })
      })
    }
  },
  created() {
    this.getPositions()
  },
  computed: {
    addShow() {
      return _g.getHasRule('posts-save')
    },
    editShow() {
      return _g.getHasRule('posts-update')
    },
    deleteShow() {
      return _g.getHasRule('posts-delete')
    }
  },
  components: {
    btnGroup
  },
  mixins: [http]
}
</script>