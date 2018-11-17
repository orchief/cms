<template>
	<form name="" method="post" action="" id="" class="form-horizontal">
        <div class="blank">
            <button type="button" @click="oPenMyself" class="btn btn-primary">新增优惠券</button>
        </div>
        <div id="allProductsDiv">
            <div class="play-tabs">
              <div class="tab-pane active">
                     <div style="margin-top:10px;background-color:#fff">
                       
                         <div class="activediv" style="background-color: rgb(255, 255, 255);">
                              <div class="table-page">
                <ul class="nav nav-tabs" role="tablist">
                    <li id="" role="presentation" class="active">
                        <a href="">优惠券</a>
                    </li>
                    <li id="" role="presentation">
                        <a href="">已结束优惠券</a>
                    </li> 
                    <li id="" role="presentation">
                        <a href="">领用/使用记录</a>
                    </li>                                       
                </ul>

                 
                </div>
                        <div class="set-switch">
                        <div class="form-inline" id="searchDiv">
                           <input name="" type="text" id="" class="form-control resetSize" placeholder="优惠券名称" style="width:110px;">           
                            <input name="" type="text" id="" class="form-control resetSize" placeholder="面值" style="width:110px;">至
                            <input name="" type="text" id="" class="form-control resetSize ml20" placeholder="面值" style="width:110px;">
                            <input name="" type="text" id="" class="form-control resetSize" autocomplete="off" placeholder="有效期" style="width: 110px; margin:0px;">
                                    至
                            <input name="" type="text" id="" class="form-control resetSize" autocomplete="off" placeholder="有效期" style="width: 110px;">
                                    
                            <select name="" id="" class="form-control resetSize" style="width:120px;">
                                	<option selected="selected" value="">优惠券类型</option>
                                	<option value="1">手工发送</option>
                                	<option value="2">自助领取</option>
                                	<option value="3">活动赠送</option>

                            </select>
                            <input type="submit" name="" value="查询" id="" class="btn btn-primary resetSize">

                        </div>
                        </div>

                         <div class="form-inline" style="margin-bottom: 10px; margin-top:-10px;margin-left:19px; display:none;" id="">
                            <div class="checkbox"><input type="checkbox" id="selectAll" class="allselect"> <label for="selectAll">全选</label></div>

                          
                              <input type="button" name="" value="批量删除"  id="" class="btn resetSize btn-danger" style="margin-left:20px;">

                            <div style="display: none;">
                                <input type="submit" name="" value="" id="">
                                <input name="" type="text" id="">
                            </div>
                        </div>
                         </div>

                        </div>
                    </div>
                </div>

	<table class="table table-hover mar table-bordered" cellspacing="0" border="0" id="" style="width:100%;border-collapse:collapse;">
		<tbody>
            <tr class="table_title">
			<th scope="col" style="text-align: center;">
            选择
            </th>
            <th scope="col" style="text-align: center;">优惠券名称</th>
            <th scope="col" style="text-align: center;">面值</th>
            <th scope="col" style="text-align: center;">使用条件</th>
            <th scope="col" style="width: 170px; text-align: center;">使用期限</th>
            <th scope="col" style="width: 75px; text-align: center;">领取限制</th>
            <th scope="col" style="text-align: center;">发放总量</th>
            <th scope="col" style="text-align: center;">已领取</th>
            <th scope="col" style="text-align: center;">已使用</th>
            <th class="border_top border_bottom" scope="col" style="width: 200px; text-align: center;">操作</th>
		    </tr>
            <tr v-for="list in dataList">
			<td align="center" valign="middle">
                                        <input id="" type="checkbox" name="">
                                    </td><td align="center" valign="middle">
                                        <span title="[手工发送]">{{list.discountName}}</span>
                                    </td><td align="center" valign="middle">
                                        ￥{{list.denomination}}
                                    </td><td align="center" valign="middle" style="width:75px;">
                                        {{list.orderTotalPayment}}
                                    </td><td align="center" valign="middle" style="width:150px;">
                                       {{list.startDate}}至 
                                        {{list.endDate}}
                                    </td><td align="center" valign="middle" style="width:75px;">
                                        {{list.discountLimit}}/张每人
                                    </td><td align="center" valign="middle">
                                        {{list.amount}}张
                                    </td><td align="center" valign="middle">
                                        {{list.receiveTimes}}张
                                    </td>
                                    <td align="center" valign="middle">
                                        {{list.usedTimes}}张
                                    </td>
                                    <td class="spanD spanN" align="center" valign="middle">
                                        <input type="hidden" name="ball" value="False">
                                      
                                           
                                        </span>
                                        
                                        <span stitle="qrc" style="">
                                            <input type="text" id="urldata61" placeholder="" name="urldata61" value="" disabled="" style="display: none">
                                            
                                        </span>
                                        <span class="submit_jiage"><a class="btn btn-warning resetSize">编辑</a></span>
                                        <span stitle="FinishSpan" class="submit_jiage" style="">
                                              <input type="submit" name="" value="结束" onclick="return HiConform(&#39;&lt;strong&gt;结束优惠券&lt;p&gt;确定要结束优惠券，是否继续？&lt;/p&gt;&lt;/strong&gt;&#39;,this);" id="" class="btn btn-danger resetSize" isshow="true">
                                        </span>

                                        <span stitle="unFinishSpan" class="submit_jiage" style="display:none;"> 
                                            <input type="submit" name="" value="启用" onclick="return useCoupon(this, &quot;61&quot;,&quot;False&quot;);" id="" class="btn btn-success resetSize">
                                        </span>

                                        <span stitle="modifyProductSpan" class="submit_jiage" style="display: block;">
                                            <a href="">修改商品</a>
                                        </span>
                                        
                                         <!-- 删除 加的！！！！ -->
                                         <!-- <input type="submit" name="" value="删除" onclick="return HiConform(&#39;&lt;strong&gt;确定要删除选择的优惠券吗？&lt;/strong&gt;&lt;p&gt;删除优惠券不可恢复！&lt;/p&gt;&#39;,this);" id="" class="btn btn-danger resetSize" isshow="true"> -->
                                    </td>
		                          </tr>
                            	</tbody>
                            </table>
                            </div>
                        <div class="bottomPageNumber clearfix" style="padding-left: 35%;">
                            <div class="pageNumber">
                                <div class="pagination" style="width: auto">
                                    <span class="page-cur">1</span><span class="page-skip">第1/1页 共1记录<input type="text" class="text" value="1" size="3" id="txtGoto">页<input type="button" class="button" value="确定"></span>
                                </div>
                            </div>
                        </div>
                <!-- 弹框开始 -->


                <div>
                    <div class="dialog-wrap">
                      <div class="dialog-cover"  v-if="isShow" @click="closeMyself"></div>
                      <transition name="drop">
                        <div class="dialog-content"  v-if="isShow">
                          <p class="dialog-close" @click="closeMyself">x</p>
                          <slot>
                             <form name="" method="post" action="" id="" class="form-horizontal">
        <table>
            <tbody><tr>
                
                <td>
                    <div class="set-switch">
                        
                        <div class="graylineCss"></div>

                        <div class="form-group">
                            <label class="col-xs-3 control-label"><em>*</em>优惠券名称：</label>
                            <div class="col-xs-4">
                                <input name="" class="form-control" v-model="youhuiquanName">                          
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-3 control-label"><em>*</em>面值：</label>
                            <div class="form-inline">                               
                                <input name="" type="text" maxlength="9" id="" class="form-control" v-model="mianzhi">
                                <label>元</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-3 control-label"><em>*</em>使用条件：</label>
                            <div class="form-inline">
                                <input value="0" name="tiaojian" type="radio" id="" checked="checked" v-model="buxianzhi">
                                <label>不限制</label>
                            </div>
                            <div class="form-inline">
                                <input value="1" name="tiaojian" type="radio" id="" >
                                <label>订单满</label>
                                <input name="" type="text" id="" class="form-control" v-model="buxianzhi">
                                <label>元可用</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-3 control-label"><em>*</em>有效期限：</label>
                            <div class="form-inline">
                                <input name="" type="text" id="" class="form-control" autocomplete="off" v-model="qishishijian">

                                <label>至</label>
                                <input name="" type="text" id="" class="form-control" autocomplete="off" v-model="jieshushijian">

                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-3 control-label"><em>*</em>优惠券类型：</label>
                            <div class="form-inline" id="">
                               
                            <label class="middle"> <input type="radio" name="couponType" value="1" v-model="shoudong">手工发送</label><label class="middle">
                                 <input type="radio" name="couponType" value="2" v-model="shoudong">自助领取</label>
                                 <!-- <label class="middle">  -->
                                <!-- <input type="radio" name="couponType" value="3" v-model="shoudong">活动赠送</label> -->
                                </div>
                        </div>
                    </div>
                    <div class="set-switch" style="width: 95%;">
                    
                        <div class="graylineCss"></div>

                        <div class="form-group">
                            <label class="col-xs-3 control-label"><em>*</em>发放总量：</label>
                            <div class="form-inline">
                                <input name="" type="text" id="" class="form-control" v-model="zongliang">
                                <label>张</label>
                            </div>
                        </div>
                       

                        <div class="form-group">
                            <label class="col-xs-3 control-label">每人限领：</label>
                            <div>
                                <div class="col-xs-4">
                                <input name="" class="form-control" v-model="number">                          
                            </div>
                                <!-- <select name="" id="" class="form-control">
                                        <option value="1" v-model="yi">1张</option>
                                        <option value="2" v-model="er">2张</option>
                                        <option value="3" v-model="san">3张</option>
                                        <option value="4" v-model="si">4张</option>
                                        <option value="5" v-model="wu">5张</option>
                                        <option value="6" v-model="liu">6张</option>
                                        <option value="7" v-model="qi">7张</option>
                                        <option value="8" v-model="ba">8张</option>
                                        <option value="9" v-model="jiu">9张</option>
                                        <option value="10" v-model="shi">10张</option>
                                </select> -->
                                <p class="help-block" >每个用户自助领券上限，如不选，则默认为1张</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-3 control-label">活动商品：</label>
                            <div class="form-inline">
                                <input v-model="quanbu" type="radio" id="product_rd1" style="margin-left: 15px;" name="ProductsGroup" checked="checked">                
                                <label style="margin-left: 3px;">全部商品参与</label>
                                
                            </div>
                            <div class="form-inline">
                                <input v-model="bufen" type="radio" id="product_rd2" style="margin-left: 15px;" name="ProductsGroup">
                                <label style="margin-left: 3px; margin-right: 3px;">部分商品参与</label>
                                <label class="graylabel">&nbsp;&nbsp;已选商品(<em>0</em>)件</label>                                
                            </div>
                        </div>                        
                    </div>
                </td>
            </tr>
        </tbody></table>
        <div style="height:50px;"></div>

        <div class="footer-btn navbar-fixed-bottom autow">
            <button type="button" id="saveBtn" class="btn btn-success" @click="btnSubmit()">保存</button>
            <button type="button" id="nextBtn" class="btn btn-primary" style="display: none;">下一步，选择宝贝</button>
        </div>
    </form>
      </slot>
              </div>
               </transition>
              </div>
             </div>
               <!-- 弹框结束 -->
    </form>
</template>

<script>
import http from "assets/js/http.js";
export default {
  data() {
    return {
      isShow: false,
      youhuiquanName: "",
      mianzhi: "",
      buxianzhi: "",
      //   dingdanman:"",
      qishishijian: "",
      jieshushijian: "",
      shoudong: "",
      zizhu: "",
      huodong: "",
      zongliang: "",
      number: "",
      quanbu: "",
      bufen: "",
      dataList: []
    };
  },
  methods: {
    //新增优惠券
    btnSubmit() {
      const data = {
        discountName: this.youhuiquanName,
        denomination: this.mianzhi,
        orderTotalPayment: this.buxianzhi,
        startDate: this.qishishijian,
        endDate: this.jieshushijian,
        sendType: this.shoudong,
        amount: this.zongliang,
        discountLimit: this.number,
        // products: this.bufen
      };
      console.log(this.bufen);
      // let params = new URLSearchParams();
      // params.append("discountName",this.youhuiquanName);
      // params.append("denomination",this.mianzhi);
      // params.append("orderTotalPayment",this.buxianzhi);

      // params.append("startDate",this.qishishijian);
      // params.append("endDate",this.jieshushijian);

      // params.append("sendType",this.shoudong);
      // params.append("amount",this.zongliang);
      // // 每人限领
      // params.append("discountLimit",this.number);
      // params.append("products",this.bufen);

      // console.log(this.youhuiquanName);
      const url = "admin/GoodsDiscounts";
      this.apiPost(url, data).then(res => {
        this.handelResponse(res, data => {
          this.cateData = data;
          //   console.log(this.cateData);
          console.log(this.dataList);
          _g.closeGlobalLoading();
        });
      });
    },
    closeMyself() {
      this.isShow = false;
    },

    oPenMyself() {
      this.isShow = true;
    },
    getList() {
      const url = "admin/GoodsDiscounts";
      this.apiGet(url).then(res => {
        this.handelResponse(res, data => {
          this.cateData = data;
          //   console.log(this.cateData);
          this.dataList = data.list;
          console.log(this.dataList);
    _g.closeGlobalLoading();
});
});
}
},
  mounted() {
    this.getList();
  },

  //   created() {
  //     this.init();
  //     // 延迟绑定监听
  //     this.$watch("data.exchanged.search", {
  //       deep: true,
  //       handler: function() {
  //         router.push({ path: this.$route.path, query: this.getCondition() });
  //         _g.openGlobalLoading();
  //         this.tableData();
  //       }
  //     });
  //     this.$watch("data.exchanged.isDelete", {
  //       deep: true,
  //       handler: function() {
  //         _g.openGlobalLoading();
  //         this.tableData();
  //       }
  //     });
  //   }
  mixins: [http]
};
</script>



<style lang="scss">
@import "./index.scss";
</style>

