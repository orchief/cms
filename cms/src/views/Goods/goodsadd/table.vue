<template>
<div class="goodadd">
  
    <el-form ref="form" :model="form" :rules="rules" :label-position="'right'"  :label-width="'140px'">
        <el-card class="box-card">
            <div slot="header" class="clearfix">
                <span>基本信息</span>
            </div>
            <el-form-item :label="'所属分类'" :prop="'categoryId'">
                <el-cascader :options="options" v-model="categoryList" @change="categoryChange"></el-cascader>
            </el-form-item>
            <el-form-item :label="'商品品牌'" :prop="'brandId'" >
                <el-select  v-model="form.brandId" :placeholder="'选择商品品牌'" class="w-200">
                    <el-option v-for="option in brandslist" :label="option.brandName" :value="option.id"></el-option>
                </el-select>
            </el-form-item>
            <el-form-item :label="'商品类型'"  >
                <el-select filterable v-model="form.groupId" @change="attrgroupChange" :placeholder="'选择商品类型'" class="w-200">
                    <el-option v-for="option in goodsAttributeGroupData" :label="option.name" :value="option.id"></el-option>
                </el-select>
            </el-form-item>
            <el-form-item :label="'商品属性'"  v-if="attributesList.length">
                <div v-for="(attr,ind) in attributesList" style="display:flex;flex-wrap:wrap;">
                    <span>{{attr.attributeName}}：</span>
                    <el-radio-group v-model="attr.isChecked" @change="skuSinglChange">
                      <el-radio :disabled="val.isVChecked" v-for="(val,index) in attr.attributes"  :label="attr.id+'-'+val.id+'-'+ind">{{val.valueStr}}</el-radio>
                    </el-radio-group>
                    <el-input style="margin-left:10px;width:120px;" v-if="attr.showInput"  v-model="attr.input" placeholder="新增属性值"></el-input>
                    <el-button v-if="!attr.showInput" @click="attr.showInput=true" class="attr-add" type="success">增加</el-button>
                    <el-button v-if="attr.showInput" @click="addAttr(attr)" class="attr-add" type="primary">确定</el-button>
                    <el-button v-if="attr.showInput" @click="attr.showInput=false" class="attr-add" type="plain">取消</el-button>
                    <el-button @click="clearAttr(ind)" class="attr-clear" type="danger">清空</el-button>
                </div>
            </el-form-item>
             <el-form-item :label="'商品名称'" :prop="'productName'" >
                <el-input v-model.trim="form.productName" class="h-40 w-200" :maxlength="255" ></el-input>
            </el-form-item>
            <el-form-item :label="'简短描述'" :prop="'shortDescription'" >
                <el-input type="textarea" v-model.trim="form.shortDescription" class="h-40 w-200" :maxlength="255" ></el-input>
            </el-form-item>
             <el-form-item :label="'商品图片'" :prop="'imgPath'">
                <el-upload
                class="avatar-uploader"
                :action = "Add.config.uploadUrl"
                :show-file-list="false"
                :on-success="handleAvatarSuccess"
                :before-upload="beforeAvatarUpload">
                <img v-if="form.imgPath" :src="Add.config.domain + form.imgPath" class="avatar">
                <i v-else class="el-icon-plus avatar-uploader-icon"></i>
                </el-upload>
            </el-form-item>
            <el-form-item :label="'商品图片列表'" >
                <el-upload class="avatar-uploader"  :action = "Add.config.uploadUrl"
                list-type="picture-card"
                :on-success="handleAvatarListSuccess"
                :before-upload="beforeAvatarUpload">
                <i class="el-icon-plus"></i>
                </el-upload>
            </el-form-item>
        </el-card>
        <el-card class="box-card">
            <div slot="header" class="clearfix">
                <span>库存规格</span>
                <div class="fr " v-if="form.groupId">
                    <el-button v-if="!mutlAttrs" @click="mutlAttrs=!mutlAttrs"  type="primary" size="small" >开启多商品规格</el-button>
                    <el-button v-else class="fr " @click="mutlAttrs=!mutlAttrs" type="primary" size="small" >关闭多商品规格</el-button>
                </div>
            </div>
            <el-form-item :label="'商品属性'"  v-if="attributesList.length&&mutlAttrs">
                <div v-for="(attr,index) in attributesList" style="display:flex;flex-wrap:wrap;">
                    <span>{{attr.attributeName}}：</span>
                    <el-checkbox-group  v-model="attr.isSKUChecked" @change="skuMultChange">
                      <el-checkbox :disabled="i.isChecked"  v-for="(i,n) in attr.attributes" :label="attr.id+'-'+attr.attributeName+'-'+i.id+'-'+i.valueStr" >{{i.valueStr}}</el-checkbox>
                    </el-checkbox-group>
                    <el-input style="margin-left:10px;width:120px;" v-if="attr.showInput"  v-model="attr.input" placeholder="新增属性值"></el-input>
                    <el-button v-if="!attr.showInput" @click="attr.showInput=true" class="attr-add" type="success">增加</el-button>
                    <el-button v-if="attr.showInput" @click="addAttr(attr)" class="attr-add" type="primary">确定</el-button>
                    <el-button v-if="attr.showInput" @click="attr.showInput=false" class="attr-add" type="plain">取消</el-button>
                    <el-button @click="clearSku(index)" class="attr-clear" type="danger">清空</el-button>
                </div>
            </el-form-item>
            <el-table stripe v-if="attributesList.length&&mutlAttrs" :data="skuSeleResult"   border style="width: 100%">
                <el-table-column prop="skulabel" label="属性" width="200">
                </el-table-column>
                <el-table-column label="库存" >
                    <template scope="props">
                        <el-input v-model.trim="props.row.stock"  :maxlength="255" ></el-input>
                    </template>
                </el-table-column>
                <el-table-column   label="市场价">
                    <template scope="props">
                        <el-input v-model.trim="props.row.marketPrice"  :maxlength="255" ></el-input>
                    </template>
                </el-table-column>
                <el-table-column   label="现价">
                    <template scope="props">
                        <el-input v-model.trim="props.row.salePrice"  :maxlength="255" ></el-input>
                    </template>
                </el-table-column>
                <el-table-column  label="成本价">
                    <template scope="props">
                        <el-input v-model.trim="props.row.costPrice"  :maxlength="255" ></el-input>
                    </template>
                </el-table-column>
                <el-table-column   label="体积">
                    <template scope="props">
                        <el-input v-model.trim="props.row.volume"  :maxlength="255" ></el-input>
                    </template>
                </el-table-column>
                <el-table-column   label="重量">
                    <template scope="props">
                        <el-input v-model.trim="props.row.weight"  :maxlength="255" ></el-input>
                    </template>
                </el-table-column>
                <el-table-column prop="amount2"  label="图片">
                    <template scope="props">
                       <el-upload  class="avatar-uploader"  :action = "Add.config.uploadUrl"
                      :on-success="handleAvatarSuccess1(props)" :show-file-list="false"
                      :before-upload="beforeAvatarUpload">
                      <img v-if="props.row.skuImg" :src="Add.config.domain + props.row.skuImg" class="avatar">
                        <i v-else class="el-icon-plus avatar-uploader-icon"></i>
                      </el-upload>
                    </template>
                </el-table-column>
                <el-table-column  label="操作" width="60">
                    <template scope="props">
                      <span></span>
                        <span @click="delAttr(props.$index)" style="cursor:pointer;"><i  class="el-icon-delete"></i></span>
                    </template>
                </el-table-column>
                
            </el-table>
             <el-form-item :label="'原价'" :prop="'marketPrice'" >
                <el-input v-model.trim="form.marketPrice" class="h-40 w-200" :maxlength="255" ></el-input>
            </el-form-item>
            <el-form-item :label="'现价'" :prop="'salePrice'" >
                <el-input v-model.trim="form.salePrice" class="h-40 w-200" :maxlength="255" ></el-input>
            </el-form-item>
             <el-form-item :label="'商品货号'" :prop="'productCode'" >
                <el-input v-model.trim="form.productCode" class="h-40 w-200" :maxlength="255" ></el-input>
            </el-form-item>
            <el-form-item v-if="!mutlAttrs" :label="'商品库存'" :prop="'stock'" >
                <el-input v-model.trim="form.stock" class="h-40 w-200" :maxlength="255" ></el-input>
            </el-form-item>
            <el-form-item v-if="!mutlAttrs" :label="'商品体积'" :prop="'volume'" >
                <el-input v-model.trim="form.volume" class="h-40 w-200" :maxlength="255" ></el-input>
            </el-form-item>
            <el-form-item v-if="!mutlAttrs" :label="'商品重量'" :prop="'weight'" >
                <el-input v-model.trim="form.weight" class="h-40 w-200" :maxlength="255" ></el-input>
            </el-form-item>
            <el-form-item :label="'计量单位'" :prop="'unit'" >
                <el-input v-model.trim="form.unit" class="h-40 w-200" :maxlength="255" ></el-input>
            </el-form-item>
            <el-form-item :label="'基础销量'" :prop="'showSaleCounts'" >
                <el-input v-model.trim="form.showSaleCounts" class="h-40 w-200" :maxlength="255" ></el-input>
            </el-form-item>
        </el-card>
        
        <el-card class="box-card">
            <div slot="header" class="clearfix">
                <span>分销佣金设置</span>
            </div>
             <el-form-item :label="'上一级分销返利比例'" :prop="'upOneLevel'" >
                <el-input v-model.trim="form.upOneLevel" class="h-40 w-200" :maxlength="255" ></el-input>
            </el-form-item>
            <el-form-item :label="'上二级分销返利比例'" :prop="'upTwoLevel'" >
                <el-input v-model.trim="form.upTwoLevel" class="h-40 w-200" :maxlength="255" ></el-input>
            </el-form-item>
             <el-form-item :label="'上三级分销返利比例'" :prop="'upThreeLevel'" >
                <el-input v-model.trim="form.upThreeLevel" class="h-40 w-200" :maxlength="255" ></el-input>
            </el-form-item>
           
        </el-card>
        <el-card class="box-card">
            <div slot="header" class="clearfix">
                <span>物流及其他</span>
            </div>
            <el-form-item :label="'运费设置'" :prop="'freeShipping'" >
              <div>
                <el-radio  v-model="form.freeShipping" :label="1">包邮</el-radio>
              </div>
              <div>
                <el-radio  v-model="form.freeShipping" :label="0">运费模板</el-radio>
              </div>
              <div>
                <el-select v-if="form.freeShipping==0"  v-model="form.shipTemplateId" :placeholder="'选择运费模板'" class="w-200">
                  <el-option v-for="Template in TemplateList" :label="Template.name" :value="Template.templateId"></el-option>
                </el-select>
              </div>
                
            </el-form-item>
            <el-form-item :label="'是否上架'" :prop="'onSale'" >
              <div>
                <el-radio  v-model="form.onSale" :label="1">立即上架</el-radio>
              </div>
              <div>
                <el-radio  v-model="form.onSale" :label="0">放入仓库</el-radio>
              </div>
            </el-form-item>
            <el-form-item :label="'商品详情标题'" :prop="'title'" >
                <el-input v-model.trim="form.title" class="h-40 w-200" :maxlength="255" ></el-input>
            </el-form-item>
            <el-form-item :label="'商品详情'" :prop="'description'" >
                <quill-editor v-model="form.description" ref="myQuillEditor" :options="editorOption" ></quill-editor>
            </el-form-item>
            <el-form-item :label="'商品详情(APP)'" :prop="'mobbileDescription'" >
                <quill-editor v-model="form.mobbileDescription" ref="myQuillEditor" :options="editorOption" ></quill-editor>
            </el-form-item>
           
        </el-card>
        <el-form-item >
               <el-button type="primary" @click="onSubmit">立即创建</el-button>
        </el-form-item>
	</el-form>
</div>
</template>


<script>
import http from "assets/js/http.js";
import E from "wangeditor";
import base from "./base.js";
import { editorOptions } from 'assets/js/ueditorConfig.js'
export default {
  name: "editor",
  data() {
    return Object.assign(base, {
      editorOption: editorOptions,
      categoryList: [],
      goodsAttributeGroupData: [], //类型数据
      options: [],
      attributesList: [],
      brandslist: [], //品牌列表
      mutlAttrs:false,   //是否开启多商品规格
      form: {
          categoryId: "",
          brandId: "",
          productName: "",
          productCode: "",
          unit: "",
          showSaleCounts: "",
          marketPrice: "",
          salePrice: "",
          onSale: "",
          shipTemplateId: "",
          imgPath: "",
          description:'',
          mobbileDescription: '',
          title: '',
          shortDescription:'',
          groupId:'',              //分类id
          hasAttr:0,
          hasSKU:0,
          banners: [
            // 商品轮播图
          ],
          skus: [],
          attr: {
            list:[],
            dataCount:0
          }
      },
      rules: {
        productName: [
          { required: true, message: "请输入商品名称", trigger: "blur" }
        ],
        unit:[
          { required: true, message: "请输入计量单位", trigger: "blur" }
        ],
        productCode:[
           { required: true, message: "请输入商品货号", trigger: "blur" }
        ],
        shortDescription:[
          { required: true, message: "请输入商品简短描述", trigger: "blur" }
        ],
        imgPath:[
           { required: true, message: "请上传商品图片", trigger: "blur" }
        ],
        marketPrice: [
          { required: true, message: "请输入商品市场价格", trigger: "blur" }
        ],
        salePrice: [
          { required: true, message: "请输入商品现价", trigger: "blur" }
        ],
        showSaleCounts: [
          { required: true, message: "请输入商品基础销量", trigger: "blur" }
        ],
        onSale: [
          { required: true, message: "请选择是否上架", trigger: "blur" }
        ],
        shipTemplateId: [
          { required: true, message: "请选择运费模板", trigger: "blur" }
        ],
        title:[
          { required: true, message: "请填写商品详情标题", trigger: "blur" }
        ],
        description:[
          { required: true, message: "请填写商品详情", trigger: "blur" }
        ],
        freeShipping:[
          { required: true, message: "请选择是否包邮", trigger: "blur" }
        ],
        stock:[
          { required: true, message: "请填写商品库存", trigger: "blur" }
        ],
        volume:[
          { required: true, message: "请填写商品体积", trigger: "blur" }
        ],
        weight:[
          { required: true, message: "请填写商品重量", trigger: "blur" }
        ],
      },
      attrcheckList: [],
      attrArr: [],
      skuSeleResult: [
      ],
      TemplateList:[],
      fileList:[]
    });
  },
  methods: {
    //运费模板
    getTemplateList(){
      this.apiGet("admin/ExpressTemplate", { params: {}}).then(res => {
        this.handelResponse(res, data => {
          this.TemplateList = data.list;
        })
      })
    },
     //增加属性值
    addAttr(attr){
      // this.attributesList[n].attributes.push({})
      console.log(attr);
      //新增规格值
      this.apiPost('admin/GoodsAttributeValues', {
        valueStr:attr.input
      }).then(res => {
        if(res.code==200){
            let valueID =res.data.id;
            this.apiPost('admin/GoodsAttributeToValues',{
               "attributeId":attr.id,
               "valueId": valueID
            }).then(res=>{
              console.log(res)
              if(res.code==200){
                attr.attributes.push({
                  id: valueID,
                  isChecked: attr.attributes[0].isChecked,
                  isImg: 0,
                  isVChecked: attr.attributes[0].isVChecked,
                  pivot: {
                    attributeId: attr.id,
                    valueId: valueID
                  },
                  valueStr: attr.input,
                })
                attr.input = '';
              }else{
                 _g.toastMsg("error", res.data.msg);
              }
            })
        }else{
           _g.toastMsg("error", res.data.msg);
        }
      })
      // n.showInput = true;
    },
    //清空所选属性
    clearAttr(n){
      this.attributesList[n].isChecked= false;
      this.attributesList[n].attributes.map(ms=>{
        ms.isChecked = false;
      })
      this.form.attr = [];
      this.attributesList.map((attr,index) => {
        if(attr.isChecked){
          attr.attributes.map(val => {
          if (val.id==attr.isChecked.split('-')[1]) {
            this.form.attr.push({
              attributeId: attr.id,
              valueId: val.id
            });
          }
        });
        }
      });
      console.log(this.form.attr)
    },
    //清空所选规格
    clearSku(n){
      // this.attributesList[n].isChecked= false;
      this.attributesList[n].isSKUChecked = [];
      this.attrArr[n].specItems = [];
      this.attributesList[n].attributes.map(attr=>{
        attr.isVChecked= false;
      })
      this.skuSeleResult = [];
      this.combine(0, {}, this.attrArr);
      for(let m=0;m<this.skuSeleResult.length;m++){
        //如果有空对象就删除
        var item = this.skuSeleResult[m];
        if(JSON.stringify(this.skuSeleResult[m]) == "{}"){
          this.skuSeleResult.splice(m,1);
          return;
        }
        let skulabel = "",skuID = "", attributeId = "",attributeName = "";
        for (let i in item) {
          skulabel += item[i].valueStr + "-";
          skuID += item[i].valueId + "-";
          attributeId += item[i].attributeId + "-";
          attributeName += item[i].attributeName + "-";
        }
        this.skuSeleResult[m] ={
          skulabel: skulabel.substr(0, skulabel.length - 1),
          skuID: skuID.substr(0, skuID.length - 1),
          attributeId: attributeId.substr(0, attributeId.length - 1),
          attributeName: attributeName.substr(0, attributeName.length - 1),
          skuImg:''
        };
      };
    },
 
    //所属分类变化时
    categoryChange(v) {
      this.form.categoryId = v[v.length - 1];
    },
    skuSinglChange(v) {
      console.log(v);
      console.log(this.attributesList);
      var groupid = v.split("-")[0];
      var attrid = v.split("-")[1];
      var curGroup = v.split("-")[2];
       //标签属性互斥
      this.attributesList[curGroup].attributes.map(ms=>{
        ms.isChecked = true;
      })
      
      this.form.attr = [];
      this.attributesList.map(attr => {
        attr.attributes.map(val => {
          if (val.id==attr.isChecked.split('-')[1]) {
            this.form.attr.push({
              attributeId: attr.id,
              valueId: val.id
            });
          }
        });
      });
      console.log(this.form.attr)
      if(this.form.attr.length>0){
        this.form.hasAttr = 1
      }else{
        this.form.hasAttr = 0
      }
    },
    skuMultChange(v){
      // console.log(v)
      this.attributesList.map((attr,index)=>{
        if(attr.isSKUChecked.length>0){
          //属性规格互斥
          attr.attributes.map(val=>{
            val.isVChecked = true;
          })
          //属性规格互斥
        }else{
          //属性规格互斥
          attr.attributes.map(val=>{
            val.isVChecked = false;
          })
          //属性规格互斥
        }
        this.attrArr[index].specItems = [];
          attr.isSKUChecked.map(checSku=>{
            this.attrArr[index].specItems.push({
              attributeId:checSku.split("-")[0], 
              attributeName:checSku.split("-")[1], 
              valueId:checSku.split("-")[2], 
              valueStr:checSku.split("-")[3],
              // skuImg:''
            });
          })
      });
      this.skuSeleResult = [];
      this.combine(0, {}, this.attrArr);
      for(let m=0;m<this.skuSeleResult.length;m++){
        //如果有空对象就删除
        var item = this.skuSeleResult[m];
        if(JSON.stringify(this.skuSeleResult[m]) == "{}"){
          this.skuSeleResult.splice(m,1);
          return;
        }
        let skulabel = "",skuID = "", attributeId = "",attributeName = "";
        for (let i in item) {
          skulabel += item[i].valueStr + "-";
          skuID += item[i].valueId + "-";
          attributeId += item[i].attributeId + "-";
          attributeName += item[i].attributeName + "-";
        }
        this.skuSeleResult[m] ={
          skulabel: skulabel.substr(0, skulabel.length - 1),
          skuID: skuID.substr(0, skuID.length - 1),
          attributeId: attributeId.substr(0, attributeId.length - 1),
          attributeName: attributeName.substr(0, attributeName.length - 1),
          // skuImg:''
        };
        console.log(this.skuSeleResult)
      };
    },
    combine(index, current,selectSpec) {
        if (index < selectSpec.length - 1) {
          var specItem = selectSpec[index];
          var keya = specItem.specName;
          var items = specItem.specItems;
          if (items.length == 0) {
            this.combine(index + 1, current,selectSpec);
          }
          for (var i = 0; i < items.length; i++) {
            if (!items[i]) continue;
            var newMap = {};
            newMap = $.extend(newMap, current);
            newMap[keya] = items[i];
            this.combine(index + 1, newMap,selectSpec);
          }
        } else if (index == selectSpec.length - 1) {
          var specItem = selectSpec[index];
          var keya = specItem.specName;
          var items = specItem.specItems;
          if (items.length == 0) {
            this.skuSeleResult.push(current);
          }
          for (var i = 0; i < items.length; i++) {
            if (!items[i]) continue;
            var newMap = {};
            newMap = $.extend(newMap, current);
            newMap[keya] = items[i];
            this.skuSeleResult.push(newMap);
          }
        }
      },
    //商品类型发生变化
    attrgroupChange(v) {
      this.apiGet("/admin/GoodsAttributeGroup/" + v, {}).then(res => {
        this.attributesList = [];
        this.handelResponse(res, data => {
          data.attributes.map((i, n) => {
            this.attrcheckList[n] = [];
            this.apiGet("/admin/GoodsAttribute/" + i.id, {}).then(res => {
              this.handelResponse(res, data => {
                data.isChecked = "";
                data.isSKUChecked = [];
                data.showInput = false;    //初始化规格新增属性值输入框隐藏
                data.input = ''; 
                data.attributes.map(val=>{
                  val.isChecked = false;
                  val.isVChecked = false;
                  return val;
                })
                this.attributesList.push(data);
                this.attrArr.push({
                    specName:data.attributeName,
                    specItems:[]
                });
                // console.log(this.attributesList);
                // console.log(this.attrArr);
              });
            });
          });
        });
      });
    },
    //请求分类数据

    adminData() {
      const url = "admin/GoodsCategories";
      this.apiGet(url).then(res => {
        this.handelResponse(res, data => {
          var fib = function(data) {
            return data.map(item => {
              return {
                value: item.id,
                label: item.categoryName,
                children: item.child ? fib(item.child) : null
              };
            });
          };
          this.options = fib(data.list);
          _g.closeGlobalLoading();
        });
      });
    },

    //请求品牌数据

    goodsBrand() {
      const url = "admin/GoodsBrand";
      this.apiGet(url).then(res => {
        this.handelResponse(res, data => {
          this.brandslist = data.list;
          _g.closeGlobalLoading();
        });
      });
    },

    //请求类型数据

    goodsAttributeGroup() {
      const url = "admin/GoodsAttributeGroup";
      this.apiGet(url).then(res => {
        this.handelResponse(res, data => {
          this.goodsAttributeGroupData = data.list;
          _g.closeGlobalLoading();
        });
      });
    },
    //
    onSubmit() {
      console.log(this.skuSeleResult)
        
        let list = this.skuSeleResult.map(sku=>{
          return {
            stock:sku.stock,
            costPrice:sku.costPrice,
            salePrice:sku.salePrice,
            marketPrice:sku.marketPrice,
            skuImg:sku.skuImg,
            weight:sku.weight,
            volume:sku.volume,
            items:[
              {
                  attributeId: sku.attributeId.split('-')[0],
                  attributeName: sku.attributeName.split('-')[0],
                  valueId: sku.skuID.split('-')[0],
                  valueStr: sku.skulabel.split('-')[0]
              },{
                  attributeId: sku.attributeId.split('-')[1],
                  attributeName: sku.attributeName.split('-')[1],
                  valueId: sku.skuID.split('-')[1],
                  valueStr: sku.skulabel.split('-')[1]
              }
            ]
          } 
        })
        this.form.skus = list;
        if(this.form.skus.length>0){
          this.form.hasSKU = 1
        }else{
          this.form.hasSKU = 0
        }
      
      console.log(this.form); 
      // return ;
      this.$refs.form.validate(valid => {
        if (valid) {
          this.apiPost("/admin/GoodsProducts", this.form).then(res => {
            this.handelResponse(
              res,
              data => {
                _g.toastMsg("success", res.data.msg);
                this.$router.push('/cms/goods/products');
              },
              () => {
                this.isLoading = !this.isLoading;
              }
            );
          });
        }
      });
    },
    //从表格里删除已经选中的规格
    delAttr(n){
      console.log(n)
      this.skuSeleResult.splice(n,1);
    },
    //当类型改变时
    changeGoodsAttr() {
      this.isgAt = false;
      this.gatData = this.goodsAttributeGroupData.list.find(
        item => item.id === this.gAtid
      ).attributes;
    },
    handleAvatarSuccess(res, file,fileList) {
      this.form.imgPath = res.data;
      console.log(this.skuSeleResult);
    },
    handleAvatarSuccess1(props) {
        return (function (response, file,fileList) {
            this.$set(this.skuSeleResult,props.$index,Object.assign(props.row,{skuImg:response.data}))
        }).bind(this)
     },
    uploadSectionFile(param) {
        //创建临时的路径来展示图片
        var windowURL = window.URL || window.webkitURL;
        let imgUrl = windowURL.createObjectURL(param.file);
        console.log(imgUrl,param)
        let name = param.file.name;
        let data = {
            file: file,
            fileType: name.split(".")[name.split('.').length - 1],
            fileId: this.$store.getters.uid,
            fileName: name,
        }
        console.log(data)
        return;
        let rs = ah.fileUpLoad(this, data);//封装的axio post请求
        console.log(rs);
    },
    handleAvatarTaSuccess(res, file) {
      console.log(res, file)
      this.form.imgPath = res.data;
    },
    handleAvatarListSuccess(res, file,filelist) {
      this.form.banners = []
      filelist.map((file,index)=>{
        this.form.banners.push({
				      "title": file.name,
              "path": file.response.data,
              "sort": index+1
            })
      })
    },
    AvatarUploadprogress(event, file, fileList){
      console.log(event, file, fileList)
    }
  },

  created() {
    this.adminData();
    this.goodsBrand();
    this.goodsAttributeGroup();
    this.getTemplateList();
  },

  mixins: [http]
};
</script>



<style lang="scss">
.goodadd {
  .el-card.is-always-shadow {
    margin-bottom: 10px;
  }
  .el-card__header{
      padding: 10px 20px;
  }
  .el-radio-group{
    line-height: 50px;
  }
  .el-table{
    margin-bottom: 20px;
    .el-input__inner{
      line-height: 30px;
      height: 30px;
      padding: 0 10px;
    }
    .avatar-uploader-icon {
        font-size: 10px;
        width: 50px;
        height: 50px;
        line-height: 50px;
    }
    .avatar {
        width: 50px;
        height: 50px;
    }
  }
  .el-table td, .el-table th{
    padding: 10px 0;
  }
  
}
</style>

