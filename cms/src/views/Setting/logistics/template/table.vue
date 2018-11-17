<template>
    <div class="logistics-main">
        <div style="padding: 10px 0 15px;">
            <el-checkbox @change="allChange" v-model="allCheck">全选</el-checkbox>
            <el-button size="mini" @click="delAll" type="danger"  >批量删除</el-button>
            <router-link to="/cms/setting/logistics/add"><el-button size="mini" type="primary" >新增运费模板</el-button></router-link>
        </div>
        <el-card class="box-card" v-for="template in list">
        <div slot="header" class="clearfix">
            <div class="fl">
                 <el-checkbox :key="template.templateId" v-model="template.isChecked">{{template.name}}</el-checkbox>
                <span style="display:inline-block;margin-left:10px;font-size:12px;color:#409EFF">{{template.freeShip==1?'全国包邮':''}}</span>
            </div>
            <div class="fr">
                <router-link :to="{ name: '修改模板', params: { id: template.templateId },query:{id:template.templateId}}"><el-button size="mini"  type="primary"  >修改</el-button></router-link>
                <el-button size="mini" @click="confirmDelete(template)"  type="danger" >删除</el-button>
            </div>
        </div>
        <template>
            <el-table border :data="template.specifyAreaGroups" style="width: 100%">
            <el-table-column align="center" prop="modeTitl" label="运送方式" width="100"></el-table-column>
            <el-table-column align="center" prop="areaTitle" label="可运送至" width="400"></el-table-column>
            <el-table-column align="center" prop="firstStep" :label="`首(${template.munitTitle})`" ></el-table-column>
            <el-table-column align="center" prop="firstPrice" label="运费">
                <template scope="props">
                    {{props.row.firstPrice}}元
                </template>
            </el-table-column>
            <el-table-column align="center" prop="stepLength" :label="`每增加(${template.munitTitle})`"></el-table-column>
            <el-table-column align="center" prop="everyUnitPrice" label="增加运费">
                <template scope="props">
                    {{props.row.everyUnitPrice}}元
                </template>
            </el-table-column>
            </el-table>
        </template>
        </el-card>
    </div>
</template>

<script>
import http from "assets/js/http.js";
export default {
  data() {
    return {
        checked:[{isChecked:false},{isChecked:true},{isChecked:false}],
      list: [],
      allCheck:false,
      area:[],
      province:[]
    };
  },
  created() {
    this.getList(this.limit, this.page);
    this.formatArea();
  },
  watch:{
        list:{
            deep:true,
            handler: function(nval,oval) {
                let total = 0;
                this.list.map(ex=>{
                    if(ex.isChecked){
                        total+=1;
                    }
                })
                if(total==this.list.length){
                    this.allCheck=true; 
                }else{
                    this.allCheck=false;
                }
                
            }
        }
  },
  methods: {
    allChange(v){
        if(v){
            this.list.map(ex=>{
                ex.isChecked=true
            })
        }else{
            this.list.map(ex=>{
                ex.isChecked=false
            })
        }
    },
    //批量删除
    delAll(){
        let paramsData=[];
        this.list.map((tmp)=>{
            if(tmp.isChecked){
                paramsData.push(tmp.templateId)
            }
        
        })
        if(paramsData.length<=0){
            _g.toastMsg('warning', '至少选择一条模板');
            return;
        }
        this.$confirm("确认删除?", "提示", {
            confirmButtonText: "确定",
            cancelButtonText: "取消",
            type: "warning"
        })
        .then(() => {
            
            this.apiPost('/admin/ExpressTemplate/deletes', {ids:paramsData}).then(res => {
            this.handelResponse(
                res,
                data => {
                _g.toastMsg('success', '解除成功');
                this.getList()
                },
                () => {
                this.isLoading = !this.isLoading
                }
            )
            })
        }).catch(() => {
        });
        
    },
    async getList(limit, page) {
      _g.openGlobalLoading();
      var province = await this.getProvince();
      var city = await this.getCity();
      const url = "admin/ExpressTemplate";
      this.apiGet(url, { params: {  } }).then(res => {
        this.handelResponse(res, data => {
          this.totalCount = data.dataCount;
          this.list = data.list.map(tmp =>{
            var modeTitl = '',areaTitle = '',munitTitle = '';
            
            switch(tmp.munit){
                case 1:
                munitTitle = '件'
                break;
                case 2:
                munitTitle = 'kg'
                break;
                case 3:
                munitTitle = '立方'
                break;
                default:
                break;
            }
            if(tmp.freeShip==1){
                return Object.assign(tmp,{
                    munitTitle,
                    isChecked:false,
                    specifyAreaGroups:tmp.specifyAreaGroups=[{
                            modeTitl:'快递',
                            areaTitle:'全国',
                            everyUnitPrice:0,
                            firstPrice:0,
                            firstStep:1,
                            stepLength:1
                    }]
                })
            }else{
                return Object.assign(tmp,{
                    munitTitle,
                    isChecked:false,
                    specifyAreaGroups:tmp.specifyAreaGroups.map(i=>{
                        i.areaTitle = ''
                        switch(i.modeId){
                            case 1:
                            modeTitl = '快递'
                            break;
                            case 2:
                            modeTitl = 'EMS'
                            break;
                            case 3:
                            modeTitl = '顺丰'
                            break;
                            case 4:
                            modeTitl = '平邮'
                            break;
                            default:
                            break;
                        }   
                        if(i.areaIds){
                            var areaIdArr = i.areaIds.split('，');
                            province.map(pro=>{
                                areaIdArr.map(area=>{
                                    if(pro.areaId==area){
                                        i.areaTitle+=pro.areaName+'，';
                                    }
                                })
                            })
                            city.map(city=>{
                                areaIdArr.map(area=>{
                                    if(city.areaId==area){
                                        i.areaTitle+=city.areaName+'，'
                                    }
                                })
                            })
                        }
                        return Object.assign(i,{
                            modeTitl,
                            areaTitle:i.areaIds?i.areaTitle.substr(0,i.areaTitle.length-1):'全国',
                        })
                    })
                })
            }
            
          })
        });
        console.log(this.list)
      });
    },
    async formatArea(){
        var province = await this.getProvince();
        for(let i=0;i<province.length;i++){
            province[i].isChecked = false;
            province[i].showCity = false;
            province[i].checkedCities = [];
            if(province[i].child){
                for(let m=0;m<province[i].child.length;m++){
                    province[i].child[m].isChecked=false;
                }
            }else{
                province[i].child=[]
            }
            
        }
        this.area = province;
        
    },
    confirmDelete(item) {
      this.$confirm("确认删除?", "提示", {
        confirmButtonText: "确定",
        cancelButtonText: "取消",
        type: "warning"
      })
        .then(() => {
          this.loading_min = true;
          this.apiDelete( "/admin/ExpressTemplate/", item.templateId).then(res => {
            this.loading_min = false;
            const that = this;
            this.handelResponse(res, data => {
              this.loading_min = false;
              this.getList(this.limit, this.page);
              _g.toastMsg("success", "删除成功");
            });
          });
        })
        .catch(() => {
          // catch error
        });
    },
    getProvince(){
        return this.apiGet('/base/address', { params: {limit:-1,level:1} }).then(res => {
            if(res.code==200){
                return res.data.list
            }
        })
    },
    getCity(){
        return this.apiGet('/base/address', { params: {limit:-1,level:2} }).then(res => {
            if(res.code==200){
                return res.data.list
            }
        })
    },
  },
  mixins: [http]
};
</script>

<style lang="scss">
.logistics-main{
    .el-card{
        margin-bottom: 20px;
    }
    .el-card__header{
        padding: 10px 20px;
        label{
            margin-bottom:0;
        }
    }
    .el-card__body{
        padding:0;
    }
    .el-button{
        padding: 5px 20px ;
        margin-left: 10px;
    }
}
</style>
