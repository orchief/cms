<template>
    <div class="logistics-add">
        <el-form ref="form" :model="form" :rules="rules" label-width="100px">
            <el-form-item :label="'模板名称：'" :prop="'name'" >
                <el-input placeholder="模板名称不能重复" v-model.trim="form.name" class="h-40 w-200" :maxlength="255" ></el-input>
            </el-form-item>
            <el-form-item :label="'计价方式：'" :prop="'munit'" >
                <el-radio-group v-model="form.munit">
                    <el-radio :label="1">按件数</el-radio>
                    <el-radio :label="2">按重量</el-radio>
                    <el-radio :label="3">按体积</el-radio>
                </el-radio-group>
            </el-form-item>
            <el-form-item :label="'是否包邮：'" :prop="'freeShip'" >
                <el-radio-group v-model="form.freeShip">
                    <el-radio :label="0">自定义运费</el-radio>
                    <el-radio :label="1">卖家承担运费</el-radio>
                </el-radio-group>
            </el-form-item>
            <el-form-item v-if="form.freeShip==0" :label="'运送方式：'" :prop="'modeId'" >
                    <div>
                        除指定地区外，其余地区的运费采用“默认运费”
                    </div>
                    <div v-for="(express,exIndex) in ExpressMode">
                        <el-checkbox :key="express.id" v-model="express.isChecked" :label="express.name"></el-checkbox>
                        <div class="tmp" v-if="express.isChecked">
                            <el-form class="defaultTMP" :inline="true" >
                                默认运费<el-input  v-model.trim="express.defaultEx.firstStep"></el-input>{{label1}}内，
                                <el-input v-model.trim="express.defaultEx.firstPrice"></el-input>元；
                                每增加<el-input v-model.trim="express.defaultEx.stepLength"></el-input>{{label1}}，
                                增加运费<el-input v-model.trim="express.defaultEx.everyUnitPrice"></el-input>元
                            </el-form>
                            <el-table v-if="express.EXlist.length>0" :data="express.EXlist"   border >
                                <el-table-column width="360" label="运送到">
                                    <template scope="props">
                                        <div>
                                            <span class="fl">{{props.row.area?props.row.area:'未添加地区'}}</span>
                                            <span @click="openArea(express.id,props.$index)" class="fr edit">编辑</span>
                                        </div>
                                    </template>
                                </el-table-column>
                                <el-table-column prop="stepLength"  :label="label2+'('+label1+')'">
                                    <template scope="props">
                                        <el-input v-model.trim="props.row.firstStep"  :maxlength="255" ></el-input>
                                    </template>
                                </el-table-column>
                                <el-table-column prop="stepLength" label="首费(元)" >
                                    <template scope="props">
                                        <el-input v-model.trim="props.row.firstPrice"  :maxlength="255" ></el-input>
                                    </template>
                                </el-table-column>
                                <el-table-column prop="stepLength" :label="label3+'('+label1+')'" >
                                    <template scope="props">
                                        <el-input v-model.trim="props.row.stepLength"  :maxlength="255" ></el-input>
                                    </template>
                                </el-table-column>
                                <el-table-column prop="stepLength" label="续费(元)" >
                                    <template scope="props">
                                        <el-input v-model.trim="props.row.everyUnitPrice"  :maxlength="255" ></el-input>
                                    </template>
                                </el-table-column>
                                <el-table-column align="center" prop="stepLength" label="操作" width="80" >
                                    <template scope="props">
                                        <span @click="delTMP(express.id,props.$index)" style="cursor:pointer;text-align:center;"><i  class="el-icon-delete"></i></span>
                                    </template>
                                </el-table-column>
                            </el-table>
                            <div class="opt">
                                <span @click="addCityTem(express.id)">为指定地区城市设置运费</span>
                                <!-- <span>批量操作</span> -->
                            </div>
                        </div>
                    </div>
            </el-form-item>
            <el-form-item>
                <el-button type="primary" @click="commitAdd">确 定</el-button>
            </el-form-item>
        </el-form>
        <el-dialog title="选择区域" :visible.sync="dialogAreaVisible">
            <div class="province" style="float:left;width:20%;" v-for="(province,index) in area">
                    <el-checkbox :true-label="true+'-'+province.areaCode" :false-label="false+'-'+province.areaCode" @change="provinceChange" v-model="province.isChecked" >{{province.areaName}}</el-checkbox>
                    <el-popover placement="top-start"  width="400" trigger="click" :ref="'popover'+province.areaCode" v-model="province.showCity">
                        <div >
                            <div class="header clearable">
                                <span style="cursor:pointer;" class="fr" @click="province.showCity=!province.showCity">&times;</span>
                            </div>
                            <div class="area" >
                                <el-checkbox-group v-model="province.checkedCities" @change="handleCheckedCitiesChange">
                                    <el-checkbox v-model="cit.isChecked" :label="cit.areaCode" v-for="(cit,ci) in province.child" :key="ci">{{cit.areaName}}</el-checkbox>
                                </el-checkbox-group>
                            </div> 
                        </div>
                        <span v-popover:popover+province.areaCode slot="reference"><i class="el-icon-arrow-down"></i></span>
                    </el-popover>
                </div>
            <span slot="footer" class="dialog-footer">
                <el-button @click="dialogAreaVisible = false">取 消</el-button>
                <el-button type="primary" @click="selectArea">确 定</el-button>
            </span>
        </el-dialog>
    </div>
</template>

<script>
import http from "assets/js/http.js";
export default {
  data() {
    return {
        form: {
            name: "", // 运费模板名称
            munit: 1, //运费模板类型 1 按件 2 按重量 3 按体积
            freeShip: 0, // 是否免运费 0 不免 1 免运费
            modeId:[],
            specifyAreaGroups:[],
        },
        rules: {
            name: [
                { required: true, message: "请输入模板名称", trigger: "blur" }
            ],
            munit: [
                { required: true, message: "请选择计价方式", trigger: "blur" }
            ],
            freeShip: [
                { required: true, message: "请选择是否免邮", trigger: "blur" }
            ],
            modeId: [
                { required: true, message: "请勾选所属物流类别", trigger: "blur" }
            ],
        },
        province:[],
        city:[],
        area:[],
        dialogAreaVisible:false,
        current:{
            cla:'',
            index:''
        },
        label1:'件',
        label2:'首件',
        label3:'续件',
        ExpressMode:[]
    };
  },
  created() {
      _g.closeGlobalLoading();
      this.formatArea();
      this.handleExpressMode();
      this.getTemplate()
      this.$watch("ExpressMode", {
        deep: true,
        handler: function(nval,oval) {
          this.form.modeId = []
          nval.map(ex=>{
              if(ex.isChecked){
                  this.form.modeId.push(ex.id)
              }
          })
        }
      });
      
      this.$watch("form.munit", {
        deep: true,
        handler: function(nval,oval) {
            if(nval==1){
                this.label1='件';
                this.label2='首件';
                this.label3='续件';
            }else if(nval==2){
                this.label1='kg';
                this.label2='首重';
                this.label3='续重';
            }else if(nval==3){
                this.label1='m3';
                this.label2='首体积';
                this.label3='续体积';
            }
            this.ExpressMode.map(item=>{
                return Object.assign(item,{
                    isChecked :false,
                    defaultEx:{
                        modeId:item.id,
                        default:1,
                        stepLength: "",		// 步长
                        everyUnitPrice: "",	// 每步长增加的运费
                        firstStep: "",			// 基础运费重量 / 基础运费件数 /  基础运费体积
                        firstPrice:"",
                        areaIds:""
                    },
                    EXlist:[

                    ]
                })
            });
        }
      });
      this.$watch("form.freeShip", {
        deep: true,
        handler: function(nval,oval) {
            this.ExpressMode.map(item=>{
                return Object.assign(item,{
                    isChecked :false,
                    defaultEx:{
                        modeId:item.id,
                        default:1,
                        stepLength: "",		// 步长
                        everyUnitPrice: "",	// 每步长增加的运费
                        firstStep: "",			// 基础运费重量 / 基础运费件数 /  基础运费体积
                        firstPrice:"",
                        areaIds:""
                    },
                    EXlist:[

                    ]
                })
            });
        }
      });
  },
    methods: {
        getTemplate(){
            var that = this;
            return this.apiGet('/admin/ExpressTemplate/'+this.$route.query.id, {}).then(res => {
                _g.closeGlobalLoading()
                if(res.code==200){
                    return res.data
                }
            })
        },
        //供用户选择的物流类别列表
        async handleExpressMode(){
            var that = this;
            //获得省市数据
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
            //获得省市数据
            var currentTMP = await this.getTemplate();
            this.form.freeShip=currentTMP.freeShip;
            this.form.munit = currentTMP.munit;
            this.form.name=currentTMP.name;
            this.apiGet('/admin/ExpressMode', {}).then(res => {
                this.handelResponse(res, data => {
                this.ExpressMode = data.list.map(item=>{
                    item.EXlist = [];
                    item.isChecked = false;
                    currentTMP.specifyAreaGroups.map(tm=>{
                        if(tm.modeId==item.id){
                            tm.area='';
                            if(tm.default==1){
                                item.defaultEx = {
                                    modeId:item.id,
                                    default:tm.default,
                                    stepLength: tm.stepLength,		// 步长
                                    everyUnitPrice: tm.everyUnitPrice,	// 每步长增加的运费
                                    firstStep: tm.firstStep,			// 基础运费重量 / 基础运费件数 /  基础运费体积
                                    firstPrice:tm.firstPrice,
                                    areaIds:tm.areaIds
                                };
                            }else{
                                item.EXlist.push(tm);
                                var areaIdArr = tm.areaIds.split('，');
                                province.map(pro=>{
                                    pro.checkedCities = [];
                                    pro.isChecked = false;
                                    areaIdArr.map(area=>{
                                        if(pro.areaId==area){
                                            tm.area+=pro.areaName+'，';
                                            pro.isChecked = true;
                                            pro.child.map(city=>{
                                                if(pro.areaId==city.parentId){
                                                    pro.checkedCities.push(city.areaCode)
                                                }
                                            })
                                        }
                                    })
                                    pro.child.map(city=>{
                                        areaIdArr.map(area=>{
                                            if(city.areaId==area){
                                                tm.area+=city.areaName+'，';
                                                city.isChecked=true;
                                                pro.checkedCities.push(city.areaCode);
                                            }
                                        })
                                    })
                                })
                            }
                            tm.area=tm.area.substr(0,tm.area.length-1);
                            item.isChecked = true;
                            return item;
                        }else{
                        }
                         
                        tm.province = province;
                    })
                    return item;
                    
                });
                console.log(this.ExpressMode)
                _g.closeGlobalLoading()
                })
            })
        },
        handleCheckedCitiesChange(value) {
            this.area.map(province=>{
                if(value==province.checkedCities){
                    if(province.child.length==province.checkedCities.length){
                        province.isChecked=true;
                    }else{
                        province.isChecked=false;
                    }
                }
            })
            console.log(value)
        },
        //删除运费模板
        delTMP(type,n){
            this.ExpressMode.map(express=>{
                if(express.id==type){
                    express.EXlist.splice(n,1);
                }
            })
        },
        provinceChange(v){
            var isChecked = v.split('-')[0]=='true'?true:false;
            var id = v.split('-')[1];
            if(isChecked){
                this.area.map(province=>{
                    if(id==province.areaCode){
                        province.child.map(c=>{
                            c.isChecked=true;
                            province.checkedCities.push(c.areaCode)
                        })
                    }
                })
            }else{
                this.area.map(province=>{
                    if(id==province.areaCode){
                        province.checkedCities = []
                        province.child.map(c=>{
                        c.isChecked=false
                    })
                    }
                })
            }
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
        //新增运费模板
        addCityTem(type){
            let province = this.area.map(item=>{
                    return Object.assign({},item,{
                        isChecked:false,
                        checkedCities:[],
                        child:item.child.map(itemc=>{
                            return Object.assign({},itemc,{
                                isChecked:false
                            })
                        })
                    })
                })
            this.ExpressMode.map(express=>{
                if(express.id==type){
                    express.EXlist.push({
                        area:'未添加地区',
                        stepLength: "",		// 步长
                        everyUnitPrice: "",	// 每步长增加的运费
                        default: 0,			// 是否为默认
                        firstStep: "",	
                        firstPrice:"",
                        province:province,
                        modeId:express.id,
                        areaIds:""
                    })
                }
            })
        },
        selectArea(){
            var areaIds = '',area = '';
            this.ExpressMode.map(ex=>{
                if(ex.id==this.current.cla){
                    ex.EXlist[this.current.index].province.map(province=>{
                        if(province.isChecked){
                            areaIds+=province.areaId+'，';
                            area+=province.areaName+'，';
                        }else{
                            province.checkedCities.map(ck=>{
                                
                                for(var i=0;i<province.child.length;i++){
                                    if(province.child[i].areaCode==ck){
                                        area+=province.child[i].areaName+'，';
                                        areaIds+=province.child[i].areaId+'，';
                                    }
                                }
                            })
                        }
                    })
                }
            })
            areaIds=areaIds.substr(0,areaIds.length-1);
            area=area.substr(0,area.length-1);
            this.ExpressMode.map(ex=>{
                if(ex.id==this.current.cla){
                    ex.EXlist[this.current.index].area=area;
                    ex.EXlist[this.current.index].areaIds=areaIds
                }
            })
            this.dialogAreaVisible = false;
            
        },
        //打开城市选择框
        openArea(cla,index){
            this.current.cla = cla;
            this.current.index = index;
            this.ExpressMode.map(ex=>{
                if(ex.id==cla){
                    this.area = ex.EXlist[index].province;
                }
            })
            this.dialogAreaVisible = true;
        },
        commitAdd() {
            this.$refs.form.validate(pass => {
                if (pass) {
                    for(let i=0;i<this.ExpressMode.length;i++){
                        if(this.ExpressMode[i].isChecked){
                            for(let j in this.ExpressMode[i].defaultEx){
                                if(!this.ExpressMode[i].defaultEx[j]&&j!='areaIds'){
                                    _g.toastMsg('warning', '请填写默认运费模板');
                                    return;
                                }
                            }
                            for(var m=0;m<this.ExpressMode[i].EXlist.length;m++){
                                for(let n in this.ExpressMode[i].EXlist[m]){
                                    if(!this.ExpressMode[i].EXlist[m][n]&&n!='default'){
                                        _g.toastMsg('warning', '请填写新增运费模板');
                                        return;
                                    }
                                }
                            }
                        }
                    }
                    
                    this.form.specifyAreaGroups = []
                    this.ExpressMode.map(ex=>{
                        if(ex.isChecked){
                            this.form.specifyAreaGroups.push(ex.defaultEx)
                            ex.EXlist.map(tm=>{
                                this.form.specifyAreaGroups.push({
                                    modeId:tm.modeId,
                                    default:tm.default,
                                    stepLength:tm.stepLength,
                                    everyUnitPrice:tm.everyUnitPrice,
                                    firstStep:tm.firstStep,
                                    firstPrice:tm.firstPrice,
                                    areaIds:tm.areaIds,
                                })
                            })
                        }
                    })
                    console.log(this.form);
                    var params = {
                        name: this.form.name,			// 运费模板名称
                        munit: this.form.munit,						// 运费模板类型 1 按件 2 按重量 3 按体积
                        freeShip: this.form.freeShip,					// 是否免运费 0 不免 1 免运费
                        specifyAreaGroups: this.form.specifyAreaGroups 
                    }
                    this.apiPost('/admin/ExpressTemplate', params).then(res => {
                        this.handelResponse(
                        res,
                        data => {
                            _g.toastMsg('success', res.data.msg)
                            this.$router.go(-1)
                        },
                        () => {
                            this.isLoading = !this.isLoading
                        }
                        )
                    })
                }
            })
        },
        getProvince(){
            return this.apiGet('/base/address', { params: {limit:-1,tree:1} }).then(res => {
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
.clearable{
        &:after{
            content:'';
            display:block;
            clear: both;
        }
    }
.logistics-main {
    
  .el-card {
    margin-bottom: 20px;
  }
  .el-card__header {
    padding: 10px 20px;
    label {
      margin-bottom: 0;
    }
  }
  .el-card__body {
    padding: 0;
  }
  .el-button {
    padding: 5px 20px;
    margin-left: 10px;
  }
  
}
.tmp{
    border: 1px solid #ddd;
    padding: 10px;
    margin-bottom: 5px;
    .defaultTMP.el-form{
      .el-input{
          width: 130px!important;
      }
      .el-input__inner{
          line-height: 35px!important;
          height: 35px!important;
      }
    
    }
    .el-input__inner{
          line-height: 35px!important;
          height: 35px!important;
      }
    .el-table{
        margin-top: 10px;
        span.edit.fr{
            color:#0091ea;
            cursor:pointer;
        }
        span.close.fr{
            cursor:pointer;
        }
    }
    .el-table th{
          padding: 8px 0!important;
          line-height: 30px;
          font-weight: 400;
          color: #3f3b3b;
      }
      .el-table td{
          padding: 8px 0!important;
      }
      .el-form-item__content{
          line-height: 30px!important;
      }
      .el-table th.is-leaf{
          background: rgb(242, 248, 252)!important;
      }
      .opt{
          span{
              cursor: pointer;
          }
      }
      .el-dialog__body{
          overflow: hidden;
      }
      
}
        .area{
          .el-checkbox{
              width: 50%;
              margin-left:0;
          }
      }
</style>
