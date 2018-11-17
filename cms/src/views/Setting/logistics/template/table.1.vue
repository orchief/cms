<template>
    <div class="app-inner clearfix">


        <form name="aspnetForm" method="post" action="" id="aspnetForm">

            <!--分页功能-->

            <div class="form-group mar forced">
                <div class="checkbox">
                    <label style="width: auto;height: auto;vertical-align: initial;margin-right:30px"><input
                            type="checkbox" name="selall">全选</label>

                    <button type="button" class="btn resetSize btn-danger">批量删除</button>
                    　|　
                    <button type="button" @click="add" class="btn  resetSize btn-success">新建运费模板</button>
                </div>
            </div>

            <!--数据列表区域-->
            <div class="datalist">

                <table class="table table-hover mar table-bordered">
                    <tbody v-for="list in datalist">
                    <!-- DATAITEM -start-->
                    <tr class="rows_title">
                        <th colspan="4" class="tdleft"><input type="checkbox" name="CheckBoxGroup" value="17">&nbsp;&nbsp;&nbsp;{{list.name}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span
                                class="HassFree"><span class="HassFree"></span></span></th>
                        <th colspan="2" style="text-align:right;padding-right:10px">
                            <input  type="button" class="btn btn-info btn-xs" value="修改" @click="edit(list)">
                            <input type="button" name="ctl00$ContentPlaceHolder1$ListTemplates$ctl00$lkDelete"
                                   value="删除"
                                   @click="remove(list)"
                                   id="ctl00_ContentPlaceHolder1_ListTemplates_ctl00_lkDelete"
                                   class="btn btn-danger btn-xs">
                        </th>
                    </tr>

                    <tr>
                        <th width="90">运送方式</th>
                        <th style="width:500px">可运送至</th>
                        <th width="100">首(件)</th>
                        <th width="100">运费</th>
                        <th width="100">每增加(件)</th>
                        <th width="100">增加运费</th>
                    </tr>
                    <tr v-for="list in datalist">
                    <tr v-for="list2 in list.specifyAreaGroups">
                        <td>{{list2.modeId | modeId(expressMode)}}</td>

                        <td class="Regions">
                            <el-popover
                                    placement="bottom"
                                    width="400"
                                    trigger="click" title="地址详情">
                                <div v-html="areaIds3(list2.areaIds)"></div>
                                <el-button type="text" slot="reference" style="padding: 0">
                                    {{list2.areaIds | areaIds4(address)}}
                                </el-button>
                            </el-popover>
                        </td>
                        <td>{{list2.firstStep}}</td>
                        <td>{{list2.firstPrice | double}}</td>
                        <td>{{list2.stepLength}}</td>
                        <td>{{list2.everyUnitPrice | double}}</td>
                    </tr>
                    <tr>
                        <td colspan="6" style="border:1px solid #fff;border-bottom:1px solid #ddd"></td>
                    </tr>


                    <!-- DATAITEM -end-->

                    </tbody>
                </table>


                <!--数据列表底部功能区域-->
                <div class="pull-right">
                    <el-pagination
                            @size-change="handleSizeChange"
                            @current-change="handleCurrentChange"
                            :current-page="currentPage"
                            :page-sizes="[5, 10, 20, 50, 100]"
                            :page-size="pageSize"
                            layout="total, sizes, prev, pager, next, jumper"
                            :total="totalCount">
                    </el-pagination>
                </div>

                <div class="blank5 clearfix"></div>
            </div>

        </form>
        <!-- 弹框开始 -->


        <div>
            <div class="dialog-wrap">
                <div class="dialog-cover" v-if="isShow" @click="cancel"></div>
                <transition name="drop">
                    <div class="dialog-content" v-if="isShow">
                        <p class="dialog-close" @click="cancel">x</p>
                        <slot>


                            <!-- 模板名称 -->
                            <div class="form-group">
                                <label for="brand" class="col-xs-3 control-label">模板名称：</label>
                                <div class="col-xs-9">
                                    <input type="text" maxlength="50" class="form-control" placeholder="模板名称不可重复"
                                           v-model="templateName">
                                </div>
                                <!-- 计数方式 -->
                                <div class="form-group">
                                    <label for="brand" class="col-xs-3 control-label">计数方式：</label>
                                    <div class="col-xs-9">
                                        <label class="radio-inline">
                                            <input name="jishu" type="radio" checked="checked" :value="1"
                                                   v-model="munit">&nbsp;按件数
                                        </label>
                                        <label class="radio-inline">
                                            <input name="jishu" type="radio" :value="2" v-model="munit">&nbsp;按重量
                                        </label>
                                        <label class="radio-inline">
                                            <input name="jishu" type="radio" :value="3" v-model="munit">&nbsp;按体积
                                        </label>
                                    </div>
                                </div>

                                <!-- 是否包邮 -->
                                <div class="form-group">
                                    <label for="brand" class="col-xs-3 control-label">是否包邮：</label>
                                    <div class="col-xs-9">
                                        <label class="radio-inline">
                                            <input type="radio" name="baoyou" :value="0"
                                                   v-model="freeShip">&nbsp;自定义运费
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="baoyou" :value="1"
                                                   v-model="freeShip">&nbsp;卖家承担运费
                                        </label>
                                    </div>
                                </div>

                                <!-- 运送方式 -->
                                <div v-if="freeShip == 0">
                                    <div class="form-group">
                                        <label for="brand" class="col-xs-3 control-label">运送方式</label>
                                        <div style="border-bottom: 1px solid #ccc;padding-bottom: 10px;"
                                             class="col-xs-9">
                                            <p>除指定地区外，其余地区的运费采用“默认运费</p>
                                            <p class="checkbox-inline">
                                                <input @click="ifkuaidi" type="checkbox" v-model="iskuaidi">&nbsp;快递
                                            </p>
                                            <div v-show="iskuaidi" class="kuaidi">
                                                <!-- 弹出框 -->
                                                <div class="entity">
                                                    <div class="default">
                                                        <div class="form-inline">
                                                            <div class="form-group">
                                                                <label>默认运费：</label>
                                                                <input type="text" class="form-control"
                                                                       v-model="kuaidiDefault.firstStep">
                                                                <label>&nbsp;件内，</label>
                                                            </div>
                                                            <div class="form-group">
                                                                <input type="text" class="form-control"
                                                                       v-model="kuaidiDefault.firstPrice">
                                                                <label>&nbsp;元；</label>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>&nbsp;每增加：</label>
                                                                <input type="text" class="form-control"
                                                                       v-model="kuaidiDefault.stepLength">
                                                                <label>&nbsp;件&nbsp;</label>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>&nbsp;增加运费：</label>
                                                                <input type="text" class="form-control"
                                                                       v-model="kuaidiDefault.everyUnitPrice">
                                                                <label>&nbsp;元</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div v-show="iskddiqu" class="tbl-except">
                                                        <table class="table table-hover table-bordered">
                                                            <thead>
                                                            <tr>
                                                                <th width="260">运送到</th>
                                                                <th>首件(件)</th>
                                                                <th>首费(元)</th>
                                                                <th>续件(件)</th>
                                                                <th>续费(元)</th>
                                                                <th>操作</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <tr class="RegionItem" v-for="item in kuaidiData">
                                                                <td>
                                                                    <a href="javascript:void(0)"
                                                                       @click="selectArea(item)"
                                                                       class="exit-area">编辑</a>
                                                                    <div class="area-group">
                                                                        <p style="margin-top: 2px !important;">{{
                                                                            item.areaIds | areaIds2(address)}}</p></p>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <input type="text" value="" name=""
                                                                           data-field="start" v-model="item.firstStep">
                                                                </td>
                                                                <td>
                                                                    <input type="text" value="" name=""
                                                                           data-field="postage"
                                                                           v-model="item.firstPrice">
                                                                </td>
                                                                <td>
                                                                    <input type="text" value="" name=""
                                                                           data-field="plus" v-model="item.stepLength">
                                                                </td>
                                                                <td>
                                                                    <input type="text" value="" name=""
                                                                           data-field="postageplus"
                                                                           v-model="item.everyUnitPrice">
                                                                </td>
                                                                <td>
                                                                    <a class="delete" href="javascript:void(0)"
                                                                       @click="deleteItem(kuaidiData, item)">删除</a>
                                                                </td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="tbl-attach">
                                                        <a href="javascript:void(0)" @click="kddiqu"
                                                           class="designated-areas">为指定地区城市设置运费
                                                        </a>
                                                    </div>
                                                </div>
                                                <!-- 弹出框 -->
                                            </div>
                                            <p class="checkbox-inline">
                                                <input @click="ifems" type="checkbox" v-model="isems">&nbsp;EMS
                                            </p>
                                            <div v-show="isems" class="kuaidi">
                                                <!-- 弹出框 -->
                                                <div class="entity">
                                                    <div class="default">
                                                        <div class="form-inline">
                                                            <div class="form-group">
                                                                <label>默认运费：</label>
                                                                <input type="text" class="form-control"
                                                                       v-model="emsDefault.firstStep">
                                                                <label>&nbsp;件内，</label>
                                                            </div>
                                                            <div class="form-group">
                                                                <input type="text" class="form-control"
                                                                       v-model="emsDefault.firstPrice">
                                                                <label>&nbsp;元；</label>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>&nbsp;每增加：</label>
                                                                <input type="text" class="form-control"
                                                                       v-model="emsDefault.stepLength">
                                                                <label>&nbsp;件&nbsp;</label>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>&nbsp;增加运费：</label>
                                                                <input type="text" class="form-control"
                                                                       v-model="emsDefault.everyUnitPrice">
                                                                <label>&nbsp;元</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div v-show="isemsdiqu" class="tbl-except">
                                                        <table class="table table-hover table-bordered">
                                                            <thead>
                                                            <tr>
                                                                <th width="260">运送到</th>
                                                                <th>首件(件)</th>
                                                                <th>首费(元)</th>
                                                                <th>续件(件)</th>
                                                                <th>续费(元)</th>
                                                                <th>操作</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <tr class="RegionItem" v-for="item in emsData">
                                                                <td>
                                                                    <a href="javascript:void(0)"
                                                                       class="exit-area"
                                                                       @click="selectArea(item)">编辑</a>
                                                                    <div class="area-group">
                                                                        <p style="margin-top: 2px !important;">{{
                                                                            item.areaIds | areaIds2(address)}}</p>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <input type="text" value="" name=""
                                                                           data-field="start" v-model="item.firstStep">
                                                                </td>
                                                                <td>
                                                                    <input type="text" value="" name=""
                                                                           data-field="postage"
                                                                           v-model="item.firstPrice">
                                                                </td>
                                                                <td>
                                                                    <input type="text" value="" name=""
                                                                           data-field="plus" v-model="item.stepLength">
                                                                </td>
                                                                <td>
                                                                    <input type="text" value="" name=""
                                                                           data-field="postageplus"
                                                                           v-model="item.everyUnitPrice">
                                                                </td>
                                                                <td>
                                                                    <a class="delete" href="javascript:void(0)"
                                                                       @click="deleteItem(emsData, item)">删除</a>
                                                                </td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="tbl-attach">
                                                        <a href="javascript:void(0)" @click="emsdiqu"
                                                           class="designated-areas">为指定地区城市设置运费
                                                        </a>
                                                    </div>
                                                </div>
                                                <!-- 弹出框 -->
                                            </div>
                                            <p class="checkbox-inline">
                                                <input @click="ifshunfeng" type="checkbox" v-model="isshunfeng">&nbsp;顺丰
                                            </p>
                                            <div v-show="isshunfeng" class="kuaidi">
                                                <!-- 弹出框 -->
                                                <div class="entity">
                                                    <div class="default">
                                                        <div class="form-inline">
                                                            <div class="form-group">
                                                                <label>默认运费：</label>
                                                                <input type="text" class="form-control"
                                                                       v-model="shunfengDefault.firstStep">
                                                                <label>&nbsp;件内，</label>
                                                            </div>
                                                            <div class="form-group">
                                                                <input type="text" class="form-control"
                                                                       v-model="shunfengDefault.firstPrice">
                                                                <label>&nbsp;元；</label>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>&nbsp;每增加：</label>
                                                                <input type="text" class="form-control"
                                                                       v-model="shunfengDefault.stepLength">
                                                                <label>&nbsp;件&nbsp;</label>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>&nbsp;增加运费：</label>
                                                                <input type="text" class="form-control"
                                                                       v-model="shunfengDefault.everyUnitPrice">
                                                                <label>&nbsp;元</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tbl-except" v-show="isshunfengdiqu">
                                                        <table class="table table-hover table-bordered">
                                                            <thead>
                                                            <tr>
                                                                <th width="260">运送到</th>
                                                                <th>首件(件)</th>
                                                                <th>首费(元)</th>
                                                                <th>续件(件)</th>
                                                                <th>续费(元)</th>
                                                                <th>操作</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <tr class="RegionItem" v-for="item in shunfengData">
                                                                <td>
                                                                    <a href="javascript:void(0)"
                                                                       @click="selectArea(item)"
                                                                       class="exit-area">编辑</a>
                                                                    <div class="area-group">
                                                                        <p style="margin-top: 2px !important;">{{
                                                                            item.areaIds | areaIds2(address)}}</p></p>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <input type="text" value="" name=""
                                                                           data-field="start" v-model="item.firstStep">
                                                                </td>
                                                                <td>
                                                                    <input type="text" value="" name=""
                                                                           data-field="postage"
                                                                           v-model="item.firstPrice">
                                                                </td>
                                                                <td>
                                                                    <input type="text" value="" name=""
                                                                           data-field="plus" v-model="item.stepLength">
                                                                </td>
                                                                <td>
                                                                    <input type="text" value="" name=""
                                                                           data-field="postageplus"
                                                                           v-model="item.everyUnitPrice">
                                                                </td>
                                                                <td>
                                                                    <a class="delete" href="javascript:void(0)"
                                                                       @click="deleteItem(shunfengData, item)">删除</a>
                                                                </td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="tbl-attach">
                                                        <a href="javascript:void(0)" @click="shunfengdiqu"
                                                           class="designated-areas">为指定地区城市设置运费
                                                        </a>
                                                    </div>
                                                </div>
                                                <!-- 弹出框 -->
                                            </div>
                                            <p class="checkbox-inline">
                                                <input @click="ifpingyou" type="checkbox" v-model="ispingyou">&nbsp;平邮
                                            </p>
                                            <div v-show="ispingyou" class="kuaidi">
                                                <!-- 弹出框 -->
                                                <div class="entity">
                                                    <div class="default">
                                                        <div class="form-inline">
                                                            <div class="form-group">
                                                                <label>默认运费：</label>
                                                                <input type="text" class="form-control"
                                                                       v-model="pingyouDefault.firstStep">
                                                                <label>&nbsp;件内，</label>
                                                            </div>
                                                            <div class="form-group">
                                                                <input type="text" class="form-control"
                                                                       v-model="pingyouDefault.firstPrice">
                                                                <label>&nbsp;元；</label>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>&nbsp;每增加：</label>
                                                                <input type="text" class="form-control"
                                                                       v-model="pingyouDefault.stepLength">
                                                                <label>&nbsp;件&nbsp;</label>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>&nbsp;增加运费：</label>
                                                                <input type="text" class="form-control"
                                                                       v-model="pingyouDefault.everyUnitPrice">
                                                                <label>&nbsp;元</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tbl-except" v-show="ispingyoudiqu">
                                                        <table class="table table-hover table-bordered">
                                                            <thead>
                                                            <tr>
                                                                <th width="260">运送到</th>
                                                                <th>首件(件)</th>
                                                                <th>首费(元)</th>
                                                                <th>续件(件)</th>
                                                                <th>续费(元)</th>
                                                                <th>操作</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <tr class="RegionItem" v-for="item in pingyouData">
                                                                <td>
                                                                    <a href="javascript:void(0)"
                                                                       @click="selectArea(item)"
                                                                       class="exit-area">编辑</a>
                                                                    <div class="area-group">
                                                                        <p style="margin-top: 2px !important;">{{
                                                                            item.areaIds | areaIds2(address)}}</p>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <input type="text" value="" name=""
                                                                           data-field="start" v-model="item.firstStep">
                                                                </td>
                                                                <td>
                                                                    <input type="text" value="" name=""
                                                                           data-field="postage"
                                                                           v-model="item.firstPrice">
                                                                </td>
                                                                <td>
                                                                    <input type="text" value="" name=""
                                                                           data-field="plus" v-model="item.stepLength">
                                                                </td>
                                                                <td>
                                                                    <input type="text" value="" name=""
                                                                           data-field="postageplus"
                                                                           v-model="item.everyUnitPrice">
                                                                </td>
                                                                <td>
                                                                    <a class="delete" href="javascript:void(0)"
                                                                       @click="deleteItem(pingyouData, item)">删除</a>
                                                                </td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="tbl-attach">
                                                        <a href="javascript:void(0)" @click="pingyoudiqu"
                                                           class="designated-areas">为指定地区城市设置运费
                                                        </a>
                                                    </div>
                                                </div>
                                                <!-- 弹出框 -->
                                            </div>
                                        </div>
                                    </div>
                                    <!--<p class="checkbox-inline">-->
                                    <!--<input type="checkbox" value="">&nbsp;是否指定包邮（选填）-->
                                    <!--</p>-->
                                </div>
                            </div>

                            <div>
                                <el-button type="button" class="btn btn-primary" @click="save">保存</el-button>
                                <el-button type="button" class="btn btn-success" @click="cancel">取消</el-button>
                            </div>

                        </slot>
                    </div>
                </transition>
            </div>
        </div>


        <!-- 弹框结束 -->

        <!-- <el-dialog title="选择区域" :visible.sync="isSelectArea">
            <el-checkbox-group v-model="selectedAreas">
                <el-checkbox :label="i.areaId" v-for="i in address" @change="selectLevelOne(i)">
                    <el-popover
                            placement="bottom"
                            width="400"
                            trigger="click">
                        <el-checkbox-group v-model="i.selectedAreas">
                            <el-checkbox :label="i2.areaId" :key="i2.areaId" v-for="i2 in i.child">{{i2.areaName}}
                            </el-checkbox>
                        </el-checkbox-group>
                        <div slot="reference">
                            {{i.areaName}}
                            {{i.selectedAreas.length > 0 ? '(' + i.selectedAreas.length + ')' : ''}}
                            <el-button v-if="i.child != null && i.child.length > 0" type="text"
                                       icon="el-icon-arrow-down" circle></el-button>
                        </div>
                    </el-popover>
                </el-checkbox>
            </el-checkbox-group>

            <div slot="footer" class="dialog-footer">
                <el-button @click="cancelArea()">取 消</el-button>
                <el-button type="primary" @click="saveArea">确定</el-button>
            </div>
        </el-dialog> -->
    </div>


</template>

<script>
    import http from "assets/js/http.js";

    export default {
        data() {
            return {
                isShow: false,
                isWuliu: false,
                iskuaidi: false,
                isems: false,
                isshunfeng: false,
                ispingyou: false,
                iskddiqu: false,
                isemsdiqu: false,
                isshunfengdiqu: false,
                ispingyoudiqu: false,
                datalist: [],
                datalist2: [],
                pageSize: 10,
                currentPage: 1,
                totalCount: 0,
                templateName: "",
                expressMode: [],
                address: [],
                freeShip: 0,
                kuaidiDefault: {},
                emsDefault: {},
                shunfengDefault: {},
                pingyouDefault: {},
                kuaidiData: [],
                emsData: [],
                shunfengData: [],
                pingyouData: [],
                isSelectArea: false,
                selectedAreas: [],
                selectedAreas2: [],
                currentItemForArea: {}
            };
        },

        methods: {
            areaIds3(value) {
                if (value == null || value == "" || value.length == 0) return "全国";
                var address = this.address;
                return value.split(",").map(i => {
                    let a = address.find(_i => _i.areaId == i);
                    let c = a.child.map(_i => _i.areaName).join(",");
                    return `${a.areaName} 【${c}】`;
                }).join("<br><br>");
            },

            handleSizeChange(val) {
                this.pageSize = val;
                this.getList(val, 1);
            },
            handleCurrentChange(val) {
                this.currentPage = val;
                this.getList(this.pageSize, val);
            },

            save() {
                let n = {};
                if (this.templateName == null ||
                    this.templateName == "")
                {
                    this.$message.error('模板名称不能为空!')
                    return;
                }
                if (this.freeShip == 0 && this.iskuaidi == false && this.isems == false && this.isshunfeng == false && this.ispingyou == false) {
                    this.$message.error('至少选择一种运送方式!')
                    return;
                }
                n.name = this.templateName;
                n.freeShip = this.freeShip;
                n.munit = this.munit;
                n.specifyAreaGroups = [];
                if (this.iskuaidi) {
                    if (this.kuaidiDefault.firstStep == null ||
                        this.kuaidiDefault.firstStep == "")
                    {
                        this.$message.error('基础运费重量不能为空!')
                        return;
                    }
                    if (this.kuaidiDefault.firstPrice == null ||
                        this.kuaidiDefault.firstPrice == "")
                    {
                        this.$message.error('基础运费不能为空!')
                        return;
                    }
                    if (this.kuaidiDefault.stepLength == null ||
                        this.kuaidiDefault.stepLength == "")
                    {
                        this.$message.error('步长不能为空!')
                        return;
                    }
                    if (this.kuaidiDefault.everyUnitPrice == null ||
                        this.kuaidiDefault.everyUnitPrice == "")
                    {
                        this.$message.error('每步长增加运费不能为空!')
                        return;
                    }
                    let s = {};
                    s.modeId = 1;
                    s.firstPrice = this.kuaidiDefault.firstPrice;
                    s.firstStep = this.kuaidiDefault.firstStep;
                    s.stepLength = this.kuaidiDefault.stepLength;
                    s.everyUnitPrice = this.kuaidiDefault.everyUnitPrice;
                    s.default = 1;
                    if (this.kuaidiDefault.areaIds != null) {
                        s.areaIds = this.kuaidiDefault.areaIds;
                    }
                    n.specifyAreaGroups.push(s);
                    for (let d of this.kuaidiData) {
                        if (d.areaIds == null ||
                            d.areaIds.length == 0)
                        {
                            this.$message.error('地区不能为空!')
                            return;
                        }
                        if (d.firstStep == null ||
                            d.firstStep == "")
                        {
                            this.$message.error('基础运费重量不能为空!')
                            return;
                        }
                        if (d.firstPrice == null ||
                            d.firstPrice == "")
                        {
                            this.$message.error('基础运费不能为空!')
                            return;
                        }
                        if (d.stepLength == null ||
                            d.stepLength == "")
                        {
                            this.$message.error('步长不能为空!')
                            return;
                        }
                        if (d.everyUnitPrice == null ||
                            d.everyUnitPrice == "")
                        {
                            this.$message.error('每步长增加运费不能为空!')
                            return;
                        }
                        let s = {};
                        s.modeId = 1;
                        s.firstPrice = d.firstPrice;
                        s.firstStep = d.firstStep;
                        s.stepLength = d.stepLength;
                        s.everyUnitPrice = d.everyUnitPrice;
                        s.default = 0;
                        if (d.areaIds != null) {
                            s.areaIds = d.areaIds;
                        }
                        n.specifyAreaGroups.push(s);
                    }
                }
                if (this.isems) {
                    if (this.emsDefault.firstStep == null ||
                        this.emsDefault.firstStep == "")
                    {
                        this.$message.error('基础运费重量不能为空!')
                        return;
                    }
                    if (this.emsDefault.firstPrice == null ||
                        this.emsDefault.firstPrice == "")
                    {
                        this.$message.error('基础运费不能为空!')
                        return;
                    }
                    if (this.emsDefault.stepLength == null ||
                        this.emsDefault.stepLength == "")
                    {
                        this.$message.error('步长不能为空!')
                        return;
                    }
                    if (this.emsDefault.everyUnitPrice == null ||
                        this.emsDefault.everyUnitPrice == "")
                    {
                        this.$message.error('每步长增加运费不能为空!')
                        return;
                    }
                    let s = {};
                    s.modeId = 2;
                    s.firstPrice = this.emsDefault.firstPrice;
                    s.firstStep = this.emsDefault.firstStep;
                    s.stepLength = this.emsDefault.stepLength;
                    s.everyUnitPrice = this.emsDefault.everyUnitPrice;
                    s.default = 1;
                    if (this.emsDefault.areaIds != null) {
                        s.areaIds = this.emsDefault.areaIds;
                    }
                    n.specifyAreaGroups.push(s);
                    for (let d of this.emsData) {
                        if (d.areaIds == null ||
                            d.areaIds.length == 0)
                        {
                            this.$message.error('地区不能为空!')
                            return;
                        }
                        if (d.firstStep == null ||
                            d.firstStep == "")
                        {
                            this.$message.error('基础运费重量不能为空!')
                            return;
                        }
                        if (d.firstPrice == null ||
                            d.firstPrice == "")
                        {
                            this.$message.error('基础运费不能为空!')
                            return;
                        }
                        if (d.stepLength == null ||
                            d.stepLength == "")
                        {
                            this.$message.error('步长不能为空!')
                            return;
                        }
                        if (d.everyUnitPrice == null ||
                            d.everyUnitPrice == "")
                        {
                            this.$message.error('每步长增加运费不能为空!')
                            return;
                        }
                        let s = {};
                        s.modeId = 2;
                        s.firstPrice = d.firstPrice;
                        s.firstStep = d.firstStep;
                        s.stepLength = d.stepLength;
                        s.everyUnitPrice = d.everyUnitPrice;
                        s.default = 0;
                        if (d.areaIds != null) {
                            s.areaIds = d.areaIds;
                        }
                        n.specifyAreaGroups.push(s);
                    }
                }
                if (this.isshunfeng) {
                    if (this.shunfengDefault.firstStep == null ||
                        this.shunfengDefault.firstStep == "")
                    {
                        this.$message.error('基础运费重量不能为空!')
                        return;
                    }
                    if (this.shunfengDefault.firstPrice == null ||
                        this.shunfengDefault.firstPrice == "")
                    {
                        this.$message.error('基础运费不能为空!')
                        return;
                    }
                    if (this.shunfengDefault.stepLength == null ||
                        this.shunfengDefault.stepLength == "")
                    {
                        this.$message.error('步长不能为空!')
                        return;
                    }
                    if (this.shunfengDefault.everyUnitPrice == null ||
                        this.shunfengDefault.everyUnitPrice == "")
                    {
                        this.$message.error('每步长增加运费不能为空!')
                        return;
                    }
                    let s = {};
                    s.modeId = 3;
                    s.firstPrice = this.shunfengDefault.firstPrice;
                    s.firstStep = this.shunfengDefault.firstStep;
                    s.stepLength = this.shunfengDefault.stepLength;
                    s.everyUnitPrice = this.shunfengDefault.everyUnitPrice;
                    s.default = 1;
                    if (this.shunfengDefault.areaIds != null) {
                        s.areaIds = this.shunfengDefault.areaIds;
                    }
                    n.specifyAreaGroups.push(s);
                    for (let d of this.shunfengData) {
                        if (d.areaIds == null ||
                            d.areaIds.length == 0)
                        {
                            this.$message.error('地区不能为空!')
                            return;
                        }
                        if (d.firstStep == null ||
                            d.firstStep == "")
                        {
                            this.$message.error('基础运费重量不能为空!')
                            return;
                        }
                        if (d.firstPrice == null ||
                            d.firstPrice == "")
                        {
                            this.$message.error('基础运费不能为空!')
                            return;
                        }
                        if (d.stepLength == null ||
                            d.stepLength == "")
                        {
                            this.$message.error('步长不能为空!')
                            return;
                        }
                        if (d.everyUnitPrice == null ||
                            d.everyUnitPrice == "")
                        {
                            this.$message.error('每步长增加运费不能为空!')
                            return;
                        }
                        let s = {};
                        s.modeId = 3;
                        s.firstPrice = d.firstPrice;
                        s.firstStep = d.firstStep;
                        s.stepLength = d.stepLength;
                        s.everyUnitPrice = d.everyUnitPrice;
                        s.default = 0;
                        if (d.areaIds != null) {
                            s.areaIds = d.areaIds;
                        }
                        n.specifyAreaGroups.push(s);
                    }
                }
                if (this.ispingyou) {
                    if (this.pingyouDefault.firstStep == null ||
                        this.pingyouDefault.firstStep == "")
                    {
                        this.$message.error('基础运费重量不能为空!')
                        return;
                    }
                    if (this.pingyouDefault.firstPrice == null ||
                        this.pingyouDefault.firstPrice == "")
                    {
                        this.$message.error('基础运费不能为空!')
                        return;
                    }
                    if (this.pingyouDefault.stepLength == null ||
                        this.pingyouDefault.stepLength == "")
                    {
                        this.$message.error('步长不能为空!')
                        return;
                    }
                    if (this.pingyouDefault.everyUnitPrice == null ||
                        this.pingyouDefault.everyUnitPrice == "")
                    {
                        this.$message.error('每步长增加运费不能为空!')
                        return;
                    }
                    let s = {};
                    s.modeId = 4;
                    s.firstPrice = this.pingyouDefault.firstPrice;
                    s.firstStep = this.pingyouDefault.firstStep;
                    s.stepLength = this.pingyouDefault.stepLength;
                    s.everyUnitPrice = this.pingyouDefault.everyUnitPrice;
                    s.default = 1;
                    if (this.pingyouDefault.areaIds != null) {
                        s.areaIds = this.pingyouDefault.areaIds;
                    }
                    n.specifyAreaGroups.push(s);
                    for (let d of this.pingyouData) {
                        if (d.areaIds == null ||
                            d.areaIds.length == 0)
                        {
                            this.$message.error('地区不能为空!')
                            return;
                        }
                        if (d.firstStep == null ||
                            d.firstStep == "")
                        {
                            this.$message.error('基础运费重量不能为空!')
                            return;
                        }
                        if (d.firstPrice == null ||
                            d.firstPrice == "")
                        {
                            this.$message.error('基础运费不能为空!')
                            return;
                        }
                        if (d.stepLength == null ||
                            d.stepLength == "")
                        {
                            this.$message.error('步长不能为空!')
                            return;
                        }
                        if (d.everyUnitPrice == null ||
                            d.everyUnitPrice == "")
                        {
                            this.$message.error('每步长增加运费不能为空!')
                            return;
                        }
                        let s = {};
                        s.modeId = 4;
                        s.firstPrice = d.firstPrice;
                        s.firstStep = d.firstStep;
                        s.stepLength = d.stepLength;
                        s.everyUnitPrice = d.everyUnitPrice;
                        s.default = 0;
                        if (d.areaIds != null) {
                            s.areaIds = d.areaIds;
                        }
                        n.specifyAreaGroups.push(s);
                    }
                }


                this.isShow = false;
                _g.openGlobalLoading();
                if (this.currentItem == null) {
                    const url = "admin/ExpressTemplate";
                    this.apiPost(url, n).then(res => {
                        this.handelResponse(res, data => {
                            this.getList(this.pageSize, 1);
                        });
                    });
                }
                else {
                    const url = "admin/ExpressTemplate/";
                    this.apiPut(url, this.currentItem.templateId, n).then(res => {
                        this.handelResponse(res, data => {
                            this.getList(this.pageSize, 1);
                        });
                    });
                }
            },

            cancel() {
                this.isShow = false;
            },

            remove(item) {
                this.$confirm('是否确定删除该模板？', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning'
                }).then(() => {
                    _g.openGlobalLoading();
                    const url = "admin/ExpressTemplate/";
                    this.apidelete(url, item.templateId).then(res => {
                        this.handelResponse(res, data => {
                            this.getList(this.pageSize, 1);
                        });
                    });
                }).catch(() => {

                });
            },

            add() {
                this.isShow = true;
                this.currentItem = null;
                this.templateName = "";
                this.munit = 1;
                this.freeShip = 0;
                this.iskuaidi = false;
                this.isems = false;
                this.isshunfeng = false;
                this.ispingyou = false;
                this.kuaidiDefault = {};
                this.kuaidiData = [];
                this.emsDefault = {};
                this.emsData = [];
                this.shunfengDefault = {};
                this.shunfengData = [];
                this.pingyouDefault = {};
                this.pingyouData = [];
                this.iskddiqu = false;
                this.isemsdiqu = false;
                this.isshunfengdiqu = false;
                this.ispingyoudiqu = false;
                this.selectedAreas = [];
                this.address.forEach(i => i.selectedAreas = []);
            },
            edit(item) {
                this.isShow = true;
                this.currentItem = item;
                this.templateName = item.name;
                this.munit = item.munit;
                this.freeShip = item.freeShip;
                this.iskuaidi = item.specifyAreaGroups.some(i => i.modeId == 1);
                this.isems = item.specifyAreaGroups.some(i => i.modeId == 2);
                this.isshunfeng = item.specifyAreaGroups.some(i => i.modeId == 3);
                this.ispingyou = item.specifyAreaGroups.some(i => i.modeId == 4);
                this.kuaidiDefault = item.specifyAreaGroups.find(i => i.modeId == 1 && i.default == 1);
                if (this.kuaidiDefault == null) {
                    this.kuaidiDefault = {};
                }
                this.kuaidiData = item.specifyAreaGroups.filter(i => i.modeId == 1 && i.default == 0);
                this.emsDefault = item.specifyAreaGroups.find(i => i.modeId == 2 && i.default == 1);
                if (this.emsDefault == null) {
                    this.emsDefault = {};
                }
                this.emsData = item.specifyAreaGroups.filter(i => i.modeId == 2 && i.default == 0);
                this.shunfengDefault = item.specifyAreaGroups.find(i => i.modeId == 3 && i.default == 1);
                if (this.shunfengDefault == null) {
                    this.shunfengDefault = {};
                }
                this.shunfengData = item.specifyAreaGroups.filter(i => i.modeId == 3 && i.default == 0);
                this.pingyouDefault = item.specifyAreaGroups.find(i => i.modeId == 4 && i.default == 1);
                if (this.pingyouDefault == null) {
                    this.pingyouDefault = {};
                }
                this.pingyouData = item.specifyAreaGroups.filter(i => i.modeId == 4 && i.default == 0);
                this.iskddiqu = item.specifyAreaGroups.some(i => i.modeId == 1 && i.default == 0);
                this.isemsdiqu = item.specifyAreaGroups.some(i => i.modeId == 2 && i.default == 0);
                this.isshunfengdiqu = item.specifyAreaGroups.some(i => i.modeId == 3 && i.default == 0);
                this.ispingyoudiqu = item.specifyAreaGroups.some(i => i.modeId == 4  && i.default == 0);
                this.selectedAreas = [];
                this.address.forEach(i => i.selectedAreas = []);
            },
            ifkuaidi() {
                this.iskuaidi = !this.iskuaidi;
            },
            ifems() {
                this.isems = !this.isems;
            },
            ifshunfeng() {
                this.isshunfeng = !this.isshunfeng;
            },
            ifpingyou() {
                this.ispingyou = !this.ispingyou;
            },
            kddiqu() {
                this.iskddiqu = true;
                this.kuaidiData.push({});
            },
            emsdiqu() {
                this.isemsdiqu = true;
                this.emsData.push({});
            },
            shunfengdiqu() {
                this.isshunfengdiqu = true;
                this.shunfengData.push({});
            },
            pingyoudiqu() {
                this.ispingyoudiqu = true;
                this.pingyouData.push({});
            },
            deleteItem(l, i) {
                var index = l.indexOf(i);
                if (index > -1) {
                    l.splice(index, 1);
                }
            },
            getList(limit, page) {
                _g.openGlobalLoading();
                const url = "admin/ExpressTemplate";
                this.apiGet(url, {params: {limit: limit, page: page}}).then(res => {
                    this.handelResponse(res, data => {
                        this.totalCount = data.dataCount;
                        this.datalist = data.list;
                        this.currentPage = page;
                    });
                });
            },
            selectArea(item) {
                this.isSelectArea = true;
                this.selectedAreas = [];
                this.address.forEach(i => i.selectedAreas = []);
                this.currentItemForArea = item;
                this.selectedAreas = [];
                this.address.forEach(i => {
                    if (item.areaIds == null) return;
                    if (item.areaIds.split(",").some(_i => i.areaId == _i)) {
                        this.selectedAreas.push(i.areaId);
                        i.selectedAreas = i.child.map(a => a.areaId);
                    }
                    else if (i.child != null) {
                        i.selectedAreas = i.child.filter(a =>
                            item.areaIds.split(",").some(_i => a.areaId == _i)).map(a => a.areaId);
                    }
                });
            },
            saveArea() {
                this.isSelectArea = false;
                let areaIds = [];
                this.address.forEach(i => {
                    if (i.child == null || i.selectedAreas.length == i.child.length) {
                        if ((i.child == null && this.selectedAreas.some(_i => _i == i.areaId)) ||
                            i.child != null) {
                            areaIds.push(i.areaId);
                        }
                    }
                    else {
                        i.selectedAreas.forEach(_i => areaIds.push(_i));
                    }
                })
                this.currentItemForArea.areaIds = areaIds.join(",");
            },
            cancelArea() {
                this.isSelectArea = false;
            },
            selectLevelOne(i) {
                if (i.child == null) return;
                i.selectedAreas = i.child.map(_i => _i.areaId);
            }
        },
        created() {
            _g.openGlobalLoading();
            const url = "base/address";
            this.apiGet(url, {params: {level: "1,2", limit: -1}}).then(res => {
                this.handelResponse(res, data => {
                    data.list.forEach(i => i.selectedAreas = []);
                    this.address = data.list;
                    _g.openGlobalLoading();
                    const url = "admin/ExpressMode";
                    this.apiGet(url, {params: {limit: -1}}).then(res => {
                        this.handelResponse(res, data => {
                            this.expressMode = data.list;
                            this.getList(this.pageSize, 1);
                        });
                    });

                });
            });

        },
        mixins: [http],
        filters: {
            modeId: (value, expressMode) => {
                let m = expressMode.find(i => i.id == value);
                if (m == null) return null;
                return m.name;
            },
            areaIds4: (value, address) => {
                if (value == null || value == "" || value.length == 0) return "全国";
                return value.split(",").map(i => {
                    let a = address.find(_i => _i.areaId == i);
                    return `${a.areaName}(${a.child.length})`;
                }).join("，");
            },
            areaIds2: (value, address) => {
                if (value == null || value == "" || value.length == 0) return "未添加地区";
                return value.split(",").map(i => {
                    let a;
                    address.find(_i => {
                        if (_i.areaId == i) {
                            a = _i;
                            return true;
                        }
                        if (_i.child == null) return false;
                        let _a = _i.child.find(__i => __i.areaId == i);
                        if (_a != null) {
                            a = _a;
                            return true;
                        }
                        return false;
                    });
                    if (a == null) return "";
                    return a.areaName;
                }).join("、");
            },
            double: (value) => {
                if (value == null) return null;
                if (typeof value == "string") {
                    return Number.parseFloat(value).toFixed(2).toString() + "元";
                }
                return value.toFixed(2).toString() + "元";
            }
        }
    };
</script>

<style lang="scss">
    @import "./index.scss";
</style>

