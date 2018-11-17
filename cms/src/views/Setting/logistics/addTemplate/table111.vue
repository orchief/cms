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
                    <div>
                        <el-checkbox v-model="specifyKD" label="快递"></el-checkbox>
                        <div class="tmp" v-if="specifyKD">
                            <el-form class="defaultTMP" :inline="true" >
                                默认运费<el-input  v-model.trim="form.KD.firstStep"></el-input>{{label1}}内，
                                <el-input v-model.trim="form.KD.firstPrice"></el-input>元；
                                每增加<el-input v-model.trim="form.KD.stepLength"></el-input>{{label1}}，
                                增加运费<el-input v-model.trim="form.KD.everyUnitPrice"></el-input>元
                            </el-form>
                            <el-table v-if="KD.length>0" :data="KD"   border >
                                <el-table-column label="运送到">
                                    <template scope="props">
                                        <div>
                                            <span class="fl">{{props.row.area?props.row.area:'未添加地区'}}</span>
                                            <span @click="openArea('KD',props.$index)" class="fr edit">编辑</span>
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
                                <el-table-column prop="stepLength" label="操作" width="80" >
                                    <template scope="props">
                                        <span @click="delTMP('KD',props.$index)" style="cursor:pointer;text-align:center;"><i  class="el-icon-delete"></i></span>
                                    </template>
                                </el-table-column>
                            </el-table>
                            <div class="opt">
                                <span @click="addCityTem('KD')">为指定地区城市设置运费</span>
                                <!-- <span>批量操作</span> -->
                            </div>
                        </div>
                    </div>
                    <div>
                        <el-checkbox v-model="specifyEMS" label="EMS"></el-checkbox>
                        <div v-if="specifyEMS" class="tmp">
                            <el-form class="defaultTMP" :inline="true" >
                                默认运费<el-input v-model.trim="form.EMS.firstStep" ></el-input>{{label1}}内，
                                <el-input v-model.trim="form.EMS.firstPrice" ></el-input>元；
                                每增加<el-input v-model.trim="form.EMS.stepLength"></el-input>{{label1}}，
                                增加运费<el-input v-model.trim="form.EMS.everyUnitPrice"></el-input>元
                            </el-form>
                            <el-table v-if="EMS.length>0" :data="EMS"   border >
                                <el-table-column label="运送到">
                                    <template scope="props">
                                        <div>
                                            <span class="fl">{{props.row.area?props.row.area:'未添加地区'}}</span>
                                            <span @click="openArea('EMS',props.$index)" class="fr edit">编辑</span>
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
                                <el-table-column prop="stepLength" :label="label3+'('+label1+')'">
                                    <template scope="props">
                                        <el-input v-model.trim="props.row.stepLength"  :maxlength="255" ></el-input>
                                    </template>
                                </el-table-column>
                                <el-table-column prop="stepLength" :label="label3+'('+label1+')'" >
                                    <template scope="props">
                                        <el-input v-model.trim="props.row.everyUnitPrice"  :maxlength="255" ></el-input>
                                    </template>
                                </el-table-column>
                                <el-table-column prop="stepLength" label="操作" width="80" >
                                    <template scope="props">
                                        <span @click="delTMP('EMS',props.$index)" style="cursor:pointer;text-align:center;"><i  class="el-icon-delete"></i></span>
                                    </template>
                                </el-table-column>
                            </el-table>
                            <div class="opt">
                                <span @click="addCityTem('EMS')">为指定地区城市设置运费</span>
                                <!-- <span>批量操作</span> -->
                            </div>
                        </div>
                    </div>
                    <div>
                        <el-checkbox v-model="specifySF" label="顺丰"></el-checkbox>
                        <div v-if="specifySF" class="tmp">
                            <el-form class="defaultTMP" :inline="true" >
                                默认运费<el-input  v-model.trim="form.SF.firstStep"></el-input>{{label1}}内，
                                <el-input v-model.trim="form.SF.firstPrice"></el-input>元；
                                每增加<el-input v-model.trim="form.SF.stepLength"></el-input>{{label1}}，
                                增加运费<el-input v-model.trim="form.SF.everyUnitPrice"></el-input>元
                            </el-form>
                            <el-table v-if="SF.length>0" :data="SF"   border >
                                <el-table-column label="运送到">
                                    <template scope="props">
                                        <div>
                                            <span class="fl">{{props.row.area?props.row.area:'未添加地区'}}</span>
                                            <span @click="openArea('SF',props.$index)" class="fr edit">编辑</span>
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
                                <el-table-column prop="stepLength" label="操作" width="80" >
                                    <template scope="props">
                                        <span @click="delTMP('SF',props.$index)" style="cursor:pointer;text-align:center;"><i  class="el-icon-delete"></i></span>
                                    </template>
                                </el-table-column>
                            </el-table>
                            <div class="opt">
                                <span @click="addCityTem('SF')">为指定地区城市设置运费</span>
                                <!-- <span>批量操作</span> -->
                            </div>
                        </div>
                    </div>
                   <div>
                        <el-checkbox v-model="specifyPY" label="平邮"></el-checkbox>
                        <div v-if="specifyPY" class="tmp">
                            <el-form class="defaultTMP" :inline="true" >
                                默认运费<el-input  v-model.trim="form.PY.firstStep"></el-input>{{label1}}内，
                                <el-input v-model.trim="form.PY.firstPrice"></el-input>元；
                                每增加<el-input v-model.trim="form.PY.stepLength"></el-input>{{label1}}，
                                增加运费<el-input v-model.trim="form.PY.everyUnitPrice"></el-input>元
                            </el-form>
                            <el-table v-if="PY.length>0"  :data="PY"   border >
                               <el-table-column label="运送到">
                                    <template scope="props">
                                        <div>
                                            <span class="fl">{{props.row.area?props.row.area:'未添加地区'}}</span>
                                            <span @click="openArea('PY',props.$index)" class="fr edit">编辑</span>
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
                                <el-table-column prop="stepLength" label="操作" width="80" >
                                    <template scope="props">
                                        <span @click="delTMP('PY',props.$index)" style="cursor:pointer;text-align:center;"><i  class="el-icon-delete"></i></span>
                                    </template>
                                </el-table-column>
                            </el-table>
                            <div class="opt">
                                <span @click="addCityTem('PY')">为指定地区城市设置运费</span>
                                <!-- <span>批量操作</span> -->
                            </div>
                        </div>
                   </div>
            </el-form-item>
            <el-form-item>
                <el-button type="primary" @click="addTMP">确 定</el-button>
            </el-form-item>
        </el-form>
        <el-dialog title="选择区域" :visible.sync="dialogAreaVisible">
            <div class="province" style="float:left;width:20%;" v-for="(province,index) in area">
                    <el-checkbox :true-label="true+'-'+province.id" :false-label="false+'-'+province.id" @change="provinceChange" v-model="province.isChecked" >{{province.name}}</el-checkbox>
                    <el-popover placement="top-start"  width="400" trigger="click" :ref="'popover'+province.id" v-model="province.showCity">
                        <div >
                            <div class="header clearable">
                                <span style="cursor:pointer;" class="fr" @click="province.showCity=!province.showCity">&times;</span>
                            </div>
                            <div class="area">
                                <el-checkbox-group v-model="province.checkedCities" @change="handleCheckedCitiesChange">
                                    <el-checkbox v-model="cit.isChecked" :label="cit.id" v-for="(cit,ci) in province.city" :key="ci">{{cit.name}}</el-checkbox>
                                </el-checkbox-group>
                            </div> 
                        </div>
                        <span v-popover:popover+province.id slot="reference"><i class="el-icon-arrow-down"></i></span>
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
import province from "assets/js/province.json";
import city from "assets/js/city.json";
export default {
  data() {
    return {
        form: {
            name: "", // 运费模板名称
            munit: 1, //运费模板类型 1 按件 2 按重量 3 按体积
            freeShip: 0, // 是否免运费 0 不免 1 免运费
            modeId:[],
            specifyAreaGroups:[],
            KD:{
                modeId:1,
                default:1,
                stepLength: "",		// 步长
                everyUnitPrice: "",	// 每步长增加的运费
                firstStep: "",			// 基础运费重量 / 基础运费件数 /  基础运费体积
                firstPrice:"",
                areaIds:1
            },
            EMS:{
                modeId:2,
                default:1,
                stepLength: "",		// 步长
                everyUnitPrice: "",	// 每步长增加的运费
                firstStep: "",			// 基础运费重量 / 基础运费件数 /  基础运费体积
                firstPrice:"",
                areaIds:1
            },
            SF:{
                modeId:3,
                default:1,
                stepLength: "",		// 步长
                everyUnitPrice: "",	// 每步长增加的运费
                firstStep: "",			// 基础运费重量 / 基础运费件数 /  基础运费体积
                firstPrice:"",
                areaIds:1
            },
            PY:{
                modeId:4,
                default:1,
                stepLength: "",		// 步长
                everyUnitPrice: "",	// 每步长增加的运费
                firstStep: "",			// 基础运费重量 / 基础运费件数 /  基础运费体积
                firstPrice:"",
                areaIds:1
            },
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
        specifyKD:false,
        specifyEMS:false,
        specifySF:false,
        specifyPY:false,
        KD:[],
        EMS:[],
        SF:[],
        PY:[],
        area:[],
        province:[],
        dialogAreaVisible:false,
        current:{
            cla:'',
            index:''
        },
        label1:'件',
        label2:'首件',
        label3:'续件'
    };
  },
  created() {
      _g.closeGlobalLoading();
      this.formatArea();
      this.ExpressMode();
      this.$watch("specifyKD", {
        deep: true,
        handler: function(nval,oval) {
          if(nval){
              this.form.modeId.push(1);
          }else{
              this.form.modeId.splice(this.form.modeId.indexOf(1),1)
          }
        }
      });
      this.$watch("specifyEMS", {
        deep: true,
        handler: function(nval,oval) {
          if(nval){
              this.form.modeId.push(2);
          }else{
              this.form.modeId.splice(this.form.modeId.indexOf(2),1)
          }
        }
      });
      this.$watch("specifySF", {
        deep: true,
        handler: function(nval,oval) {
          if(nval){
              this.form.modeId.push(3);
          }else{
              this.form.modeId.splice(this.form.modeId.indexOf(3),1)
          }
        }
      });
      this.$watch("specifyPY", {
        deep: true,
        handler: function(nval,oval) {
          if(nval){
              this.form.modeId.push(4);
          }else{
              this.form.modeId.splice(this.form.modeId.indexOf(4),1)
          }
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
            this.specifyKD=false;
            this.specifyEMS=false;
            this.specifySF=false;
            this.specifyPY=false;
            this.form.KD = {
                modeId:1,
                default:1,
                stepLength: "",		// 步长
                everyUnitPrice: "",	// 每步长增加的运费
                firstStep: "",			// 基础运费重量 / 基础运费件数 /  基础运费体积
                firstPrice:"",
                areaIds:"1"
            }
            this.form.EMS = {
                modeId:2,
                default:1,
                stepLength: "",		// 步长
                everyUnitPrice: "",	// 每步长增加的运费
                firstStep: "",			// 基础运费重量 / 基础运费件数 /  基础运费体积
                firstPrice:"",
                areaIds:"1"
            }
            this.form.SF = {
                modeId:3,
                default:1,
                stepLength: "",		// 步长
                everyUnitPrice: "",	// 每步长增加的运费
                firstStep: "",			// 基础运费重量 / 基础运费件数 /  基础运费体积
                firstPrice:"",
                areaIds:"1"
            }
            this.form.PY = {
                modeId:4,
                default:1,
                stepLength: "",		// 步长
                everyUnitPrice: "",	// 每步长增加的运费
                firstStep: "",			// 基础运费重量 / 基础运费件数 /  基础运费体积
                firstPrice:"",
                areaIds:"1"
            }
            this.KD=[];
            this.EMS=[];
            this.SF=[];
            this.PY=[];
        }
      });
      this.$watch("form.freeShip", {
        deep: true,
        handler: function(nval,oval) {
            this.specifyKD=false;
            this.specifyEMS=false;
            this.specifySF=false;
            this.specifyPY=false;
            this.form.KD = {
                modeId:1,
                default:1,
                stepLength: "",		// 步长
                everyUnitPrice: "",	// 每步长增加的运费
                firstStep: "",			// 基础运费重量 / 基础运费件数 /  基础运费体积
                firstPrice:"",
                areaIds:"1",
            }
            this.form.EMS = {
                modeId:2,
                default:1,
                stepLength: "",		// 步长
                everyUnitPrice: "",	// 每步长增加的运费
                firstStep: "",			// 基础运费重量 / 基础运费件数 /  基础运费体积
                firstPrice:"",
                areaIds:"1",

            }
            this.form.SF = {
                modeId:3,
                default:1,
                stepLength: "",		// 步长
                everyUnitPrice: "",	// 每步长增加的运费
                firstStep: "",			// 基础运费重量 / 基础运费件数 /  基础运费体积
                firstPrice:"",
                areaIds:"1"
            }
            this.form.PY = {
                modeId:4,
                default:1,
                stepLength: "",		// 步长
                everyUnitPrice: "",	// 每步长增加的运费
                firstStep: "",			// 基础运费重量 / 基础运费件数 /  基础运费体积
                firstPrice:"",
                areaIds:"1"
            }
            this.KD=[];
            this.EMS=[];
            this.SF=[];
            this.PY=[];
        }
      });
  },
    methods: {
        //供用户选择的物流类别列表
        ExpressMode(){
            var that = this;
            this.apiGet('/admin/ExpressMode', {}).then(res => {
                this.handelResponse(res, data => {
                
                console.log(data)
                _g.closeGlobalLoading()
                })
            })
        },
        handleCheckedCitiesChange(value) {
            this.area.map(province=>{
                if(province.city.length==province.checkedCities.length){
                    province.isChecked=true
                }else{
                    province.isChecked=false
                }
            })
        },
    delTMP(type,n){
      switch(type){
            case 'KD':
            this.KD.splice(n,1);
            break;
            case 'EMS':
            this.EMS.splice(n,1);
            break;
            case 'SF':
            this.SF.splice(n,1);
            break;
            case 'PY':
            this.PY.splice(n,1);
            break;
            default:
            break;
      }
    },
    provinceChange(v){
        
        var isChecked = v.split('-')[0]=='true'?true:false;
        var id = v.split('-')[1];
        if(isChecked){
            this.area.map(province=>{
                if(id==province.id){
                    province.city.map(c=>{
                        c.isChecked=true;
                        province.checkedCities.push(c.id)
                    })
                }
            })
        }else{
            this.area.map(province=>{
                if(id==province.id){
                    province.checkedCities = []
                    province.city.map(c=>{
                    c.isChecked=false
                })
                }
            })
        }
    },
    formatArea(){
        for(let i=0;i<province.length;i++){
            province[i].isChecked = false;
            province[i].showCity = false;
            for(let j in city){
                if(province[i].id==j){
                    province[i].city = city[j];
                    province[i].checkedCities = []
                }
            }
            for(let m=0;m<province[i].city.length;m++){
                province[i].city[m].isChecked=false;
            }
        }
        this.area = province;
        this.province = province;
    },
    addCityTem(type){
        let province = this.province.map(item=>{
                return Object.assign({},item,{
                    isChecked:false,
                    checkedCities:[],
                    city:item.city.map(itemc=>{
                        return Object.assign({},itemc,{
                            isChecked:false
                        })
                    })
                })
            })
        switch(type){
            case 'KD':
            this.KD.push({
            area:'未添加地区',
            stepLength: "",		// 步长
            everyUnitPrice: "",	// 每步长增加的运费
            default: 0,			// 是否为默认
            firstStep: "",	
            firstPrice:"",
            province:province,
            modeId:1,
            areaIds:1
            })
            break;
            case 'EMS':
            this.EMS.push({
            area:'未添加地区',
            stepLength: "",		// 步长
            everyUnitPrice: "",	// 每步长增加的运费
            default: 0,			// 是否为默认
            firstStep: "",	
            firstPrice:"",
            province:province,
            modeId:2,
            areaIds:1
            })
            break;
            case 'SF':
            this.SF.push({
            area:'未添加地区',
            stepLength: "",		// 步长
            everyUnitPrice: "",	// 每步长增加的运费
            default: 0,			// 是否为默认
            firstStep: "",	
            firstPrice:"",
            province:province,
            modeId:3,
            areaIds:1
            })
            break;
            case 'PY':
            this.PY.push({
                area:'未添加地区',
            stepLength: "",		// 步长
            everyUnitPrice: "",	// 每步长增加的运费
            default: 0,			// 是否为默认
            firstStep: "",	
            firstPrice:"",
            province:province,
            modeId:4,
            areaIds:1
            })
            break;
            default:
            break;
        }
    },
    selectArea(){
        var areaIds = '',area = ''
        this[this.current.cla][this.current.index].province.map(province=>{
            if(province.isChecked){
                areaIds+=province.id+',';
                area+=province.name+',';
            }else{
                province.checkedCities.map(ck=>{
                        province.city.map(c=>{
                        if(c.id==ck){
                            area+=c.name+',';
                            areaIds+=c.id+',';
                        }
                    })
                })
            }
        })
        areaIds=areaIds.substr(0,areaIds.length-1);
        area=area.substr(0,area.length-1);
        this[this.current.cla][this.current.index].areaIds = areaIds;
        this[this.current.cla][this.current.index].area = area;
        this.dialogAreaVisible = false;
        
    },
    openArea(cla,index){
        this.current.cla = cla;
        this.current.index = index;
        this.dialogAreaVisible = true;
        this.area = this[this.current.cla][this.current.index].province
    },
    addTMP(){
        this.commitAdd()
    },
    commitAdd() {
        this.$refs.form.validate(pass => {
            if (pass) {
                if(this.specifyKD){
                    for(let i in this.form.KD){
                        if(!this.form.KD[i]){
                            _g.toastMsg('warning', '请填写默认运费模板');
                            return;
                        }
                    }
                }
                if(this.specifyEMS){
                    for(let i in this.form.EMS){
                        if(!this.form.EMS[i]){
                            _g.toastMsg('warning', '请填写默认运费模板');
                            return;
                        }
                    }
                }
                if(this.specifySF){
                    for(let i in this.form.SF){
                        if(!this.form.SF[i]){
                            _g.toastMsg('warning', '请填写默认运费模板');
                            return;
                        }
                    }
                }
                if(this.specifyPY){
                    for(let i in this.form.PY){
                        if(!this.form.PY[i]){
                            _g.toastMsg('warning', '请填写默认运费模板');
                            return;
                        }
                    }
                }
                this.form.specifyAreaGroups = []
                if(this.specifyKD){
                    this.form.specifyAreaGroups.push(this.form.KD);
                    this.KD.map(kd=>{
                        this.form.specifyAreaGroups.push({
                            everyUnitPrice:kd.everyUnitPrice,
                            firstPrice:kd.firstPrice,
                            firstStep:kd.firstStep,
                            stepLength:kd.stepLength,
                            areaIds:kd.areaIds?kd.areaIds:'',
                            default:0,
                            modeId:kd.modeId

                        })
                    })
                }
                if(this.specifyEMS){
                    this.form.specifyAreaGroups.push(this.form.EMS);
                    this.EMS.map(ems=>{
                        this.form.specifyAreaGroups.push({
                            everyUnitPrice:ems.everyUnitPrice,
                            firstPrice:ems.firstPrice,
                            firstStep:ems.firstStep,
                            stepLength:ems.stepLength,
                            areaIds:ems.areaIds?ems.areaIds:'',
                            default:0,
                             modeId:ems.modeId
                        })
                    })
                }
                if(this.specifySF){
                    this.form.specifyAreaGroups.push(this.form.SF);
                    this.SF.map(sf=>{
                        this.form.specifyAreaGroups.push({
                            everyUnitPrice:sf.everyUnitPrice,
                            firstPrice:sf.firstPrice,
                            firstStep:sf.firstStep,
                            stepLength:sf.stepLength,
                            areaIds:sf.areaIds?sf.areaIds:'',
                            default:0,
                            modeId:sf.modeId
                        })
                    })
                }
                if(this.specifyPY){
                    this.form.specifyAreaGroups.push(this.form.PY);
                    this.PY.map(py=>{
                        this.form.specifyAreaGroups.push({
                            everyUnitPrice:py.everyUnitPrice,
                            firstPrice:py.firstPrice,
                            firstStep:py.firstStep,
                            stepLength:py.stepLength,
                            areaIds:py.areaIds?py.areaIds:'',
                            default:0,
                            modeId:py.modeId
                        })
                    })
                }
                console.log(this.form)
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
