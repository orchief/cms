<template>
	<div>
		<div class="fl">
			<el-button type="primary" icon="document" @click="Add.dialogFormVisible = true">新增</el-button>
			<!-- 新增 -->
			<el-dialog title="新增区域覆盖" :visible.sync="Add.dialogFormVisible" @close='Add.dialogFormVisible = false'>
				<el-form ref="form" :model="Add.data.form" label-width="130px">

					<el-cascader :options="options" :props="props" change-on-select @change="handleItemChange" v-model="newAreaId"></el-cascader>

				</el-form>
				<div slot="footer" class="dialog-footer">
					<el-button @click="Add.dialogFormVisible = false">取 消</el-button>
					<el-button type="primary" @click="commit">确 定</el-button>
				</div>
			</el-dialog>
			<!-- 新增 -->
		</div>
		<div id="maindiv" style="">
			<div class="form-group" v-for="item in form">
				<label class="form-inline">{{item.name}}</label>
				<div class="col-xs-4">
					<input name="" type="text" v-model="item.value" id="" class="form-control" content="">
					<!-- <p class="helper">{{item.remark}}</p> -->
				</div>
        <div class="form-group">
            <div class="col-xs-offset-2 col-xs-10 marginl">
                <input type="submit" name="" value="更新" @click="save" id="" class="btn btn-success inputw100">
            </div>
        </div>
			</div>
		</div>
	</div>
</template>

<style lang="scss">
@import "./index.scss";
</style>

<script>
import http from "assets/js/http";
export default {
  data() {
    return {
      options: [],
      props: {
        label: "areaName",
        value: "areaId",
        children: "child"
      },
      newAreaId: null,
      id: null,
      form: null,
      config: {
        ResourceBaseUrl: window.ResourceBaseUrl,
        domain: window.axios.defaults.baseURL,
        baseApi: "admin/banners"
      },
      data: {
        received: {
          table: null
        }
      },
      Add: {
        config: {
          uploadUrl: window.axios.defaults.baseURL + "admin/upload"
        },
        dialogFormVisible: false,
        data: {
          form: {
            uri: null,
            path: null
          }
        }
      },
      Edit: {
        config: {
          uploadUrl: window.axios.defaults.baseURL + "admin/upload"
        },
        dialogFormVisible: false,
        data: {
          form: {
            uri: null,
            path: null
          }
        }
      }
    };
  },
  created() {
    this.getData();
    const data = {
      params: {
        name: "SHIPPING"
      }
    };
    _g.openGlobalLoading();
    this.apiGet("admin/setting", data).then(res => {
      this.handelResponse(res, data => {
        this.form = data.list[0].value;
        this.id = data.list[0].id;
        console.log(this.id);
      });
    });
  },
  methods: {
    getData() {
      //
      this.apiGet("base/address?tree=1&limit=-1&level=1,2").then(res => {
        this.handelResponse(res, data => {
          this.options = data.list;
          console.log("this.options", this.options);
        });
      });
    },
    handleItemChange(val) {},
    save() {
      const data = {
        value: this.form
      };
      console.log(this.id);
      _g.openGlobalLoading();
      this.apiPut("admin/setting/", this.id, data).then(res => {
        this.handelResponse(res, data => {
          _g.toastMsg("success", res.data.msg);
        });
      });
    },
    commit() {
      console.log("form", this.form);
      // 在每个空格字符处进行分解。
      let areaIds = this.form[0].value.split(",");
			console.log(areaIds);
			if(this.newAreaId.length == 1){
				if(!this.in_array(this.newAreaId[0], areaIds)){
					areaIds[areaIds.length] = this.newAreaId[0]
				}
			}else if(this.newAreaId.length == 2){
				if(!this.in_array(this.newAreaId[1], areaIds)){
					areaIds[areaIds.length] = this.newAreaId[0]
				}
			}
			
			this.form[0].value = areaIds.join(',')

      const data = {
        value: this.form
      };
      console.log(this.id);
      _g.openGlobalLoading();
      this.apiPut("admin/setting/", this.id, data).then(res => {
        this.handelResponse(res, data => {
					_g.toastMsg("success", res.data.msg);
					this.Add.dialogFormVisible = false
        });
      });
    },
    in_array(e, arr) {
      for (let i = 0; i < arr.length; i++) {
        if (arr[i] == e) return true;
      }
      return false;
    },
    add() {
      // TODO 检查 this.newAreaId 长度 只有一项那就传输这一项
      if (this.newAreaId.length == 1) {
        // 在form里边的value项里边加上这个id

        const data = {
          value: this.form
        };
        console.log(this.id);
        _g.openGlobalLoading();
        this.apiPut("admin/setting/", this.id, data).then(res => {
          this.handelResponse(res, data => {
            _g.toastMsg("success", res.data.msg);
          });
        });
      }

      console.log("areaId", this.newAreaId);
    }
  },
  mixins: [http]
};
</script>

