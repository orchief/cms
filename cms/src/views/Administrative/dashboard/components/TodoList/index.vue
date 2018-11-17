<template>

  <section class="todoapp">
   <!--  <header class="header">
      <input class="new-todo" autocomplete="off" placeholder="待办事项" @keyup.enter="addTodo">
    </header> 
    <section class="main" v-show="todos.length">
      <input class="toggle-all" id="toggle-all" type="checkbox" :checked="allChecked" @change="toggleAll({ done: !allChecked })">
      <label for="toggle-all"></label>
      <ul class="todo-list">
        <todo @toggleTodo='toggleTodo' @editTodo='editTodo' @deleteTodo='deleteTodo' v-for="(todo, index) in filteredTodos" :key="index"
          :todo="todo"></todo>
      </ul>
    </section>  
    <footer class="footer" v-show="todos.length">
      <span class="todo-count">
        <strong>{{ remaining }}</strong>
        {{ remaining | pluralize('事项') }} 剩余
      </span> 
    </footer> -->
      <div class="app">
            <div class="app-inner clearfix">
                
          
    <form name="aspnetForm" method="post" action="#" id="aspnetForm">
               
                <div class="data-shop">
                    <div class="datashop-top">
                        <ul class="nav nav-tabs">
                            <li class="active"><a class="dianpu" href="javascript:void(0)">店铺实时数据</a></li>
                        </ul>
                    </div>
                    <div class="data-list clearfix">
                        <div class="data-box fl">
                            <h4>待发货订单</h4>
                            <p><a href="#">{{data.pendingDeliveryOrderCounts}}</a></p>
                        </div>
                        <div class="data-box fl">
                            <h4>今日订单数</h4>
                            <p class="resetlh"><a href="#">{{data.todayOrderCounts}}</a></p>
                            <h4 class="resetbor">昨日订单数：{{data.yestodayOrderCounts}}</h4>
                        </div>
                        <div class="data-box fl">
                            <h4>今日成交额</h4>
                            <p class="resetlh">￥{{data.todayOrderTotalMoney}}</p>
                            <h4 class="resetbor">昨日成交额：{{data.yestodayOrderTotalMoney}}</h4>
                        </div>
                        <div class="data-box fl">
                            <h4>售后订单</h4>
                            <p>  
                                <a id="ctl00_ContentPlaceHolder1_lbServiceOrderQty" href="#" style="color:Green;">{{data.refundOrderCounts}}</a>
                            </p>
                            
                        </div>
                        <div class="shopnumber-list fl">
                            <ul>
                                <li><span>商品数：</span><a href="#">{{data.productsCounts}}</a></li>
                                <li><span>会员总数：</span><a href="#">{{data.membersCounts}}</a></li>
                                <li class="noborder"><span>分销商数：</span><a href="#">{{data.agentCounts}}</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="shop-chart">
                    <h3>店铺经营趋势</h3>
                    <div class="echarts-map" id="main"  style="width: 100%;height: 318px;">

                       </div>
                </div>
                <div class="shopdatatable clearfix">
                    <div class="shopdatatable-left fl">
                        <table class="table table-hover">
                            <caption>分销商佣金排名<p class="active"><span></span></p></caption>
                            <thead>
                                <tr>
                                    <th>店铺名称</th>
                                    <th>佣金</th>
                                    <th>排名</th>
                                </tr>
                            </thead>
                            <tbody>
                                    <tr v-for="value,index in data.rankAgent">
                                    <td>{{value.username}}</td>
                                    <td>{{value.interest}}</td>
                                    <td>{{index+1}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="shopdatatable-right fr">
                        <table class="table">
                            <caption>会员消费排名<p class="active"><span></span></p></caption>
                            <thead>
                                <tr>
                                <th>会员名</th>
                                <th>购买订单数</th>
                                <th>交易额</th>
                             
                                </tr>
                            </thead>
                            <tbody>

                                 <tr v-for="value in data.rankMembers">
                                        <!-- {{ parentMessage }} - {{ index }} - {{ item.message }} -->
                                    <td>{{value.username}}</td>
                                    <td>{{value.orderSum}}</td>
                                    <td>{{value.expend}}</td>
                                </tr>
                               
                                   
                                    

                            </tbody>
                        </table>
                    </div>

                </div>
         
  </form>

            </div>
        </div>
  </section>
</template>



<script>
import http from 'assets/js/http.js'
// 引入基本模板
let echarts = require('echarts/lib/echarts')
// 引入柱状图组件
require('echarts/lib/chart/line')
// 引入提示框和title组件
require('echarts/lib/component/tooltip')
require('echarts/lib/component/title')
export default {
  name: 'hello',
  data() {
    return {
      data :[],
      chatData : [],
      OrdersDailyArr:[],
      MembersDailyArr:[],
      AgentDailyArr:[],
      DateArr:[],
      option:{}
    }
  },
  mounted() {
      this.adminData()
      this.drawLine()
  },
  methods: {
       
    adminData() {
      const url = 'admin/counts'
      this.apiGet(url).then(res => {
        this.handelResponse(res, data => {
         this.data = data
         console.log(this.data)
          _g.closeGlobalLoading()

        })

      })
  
    },
    drawLine() {
        const url = 'admin/counts'
        this.apiGet(url).then(res => {
        this.handelResponse(res, data => {
        this.data = data
        // this.chatData={
        //     AgentDailyCount:data.AgentDaily.dataCount,AgentDailyDate:data.AgentDaily.list[0].createDate
        // }

        for (var i = 0; i <this.data.OrdersDaily.list.length; i++) {
            this.OrdersDailyArr.push(this.data.OrdersDaily.list[i].count);
        }
        console.log(this.OrdersDailyArr)
        for (var j = 0; j <this.data.MembersDaily.list.length; j++) {
            this.MembersDailyArr.push(this.data.MembersDaily.list[j].count);
        }
        console.log('会员数组'+this.MembersDailyArr)
        for (var k = 0; k <this.data.AgentDaily.list.length; k++) {
            this.AgentDailyArr.push(this.data.AgentDaily.list[k].count);
        }
        console.log('分销商数组'+this.AgentDailyArr)
         for (var z = 0; z <this.data.AgentDaily.list.length; z++) {
            this.DateArr.push(this.data.AgentDaily.list[z].createDate);
        }

        // console.log(this.chatData.AgentDailyDate)
        _g.closeGlobalLoading()

        })

     
        console.log('分销商数组'+this.AgentDailyArr)
      // 基于准备好的dom，初始化echarts实例
      let myChart = echarts.init(document.getElementById('main'))
       // console.log(this.data)
      // 绘制图表
      myChart.setOption({
        color: ['#D53A35', '#E98F6F', '#6AB0B8', '#334B5C'],
 
    tooltip: {
        trigger: 'axis',
     
    },
    legend: {
        data: ['分销商数量', '用户数量', '订单数量']
    },
    grid: {
        left: '3%',
        right: '4%',
        bottom: '3%',
        containLabel: true
    },
    toolbox: {
        feature: {
            saveAsImage: {}
        }
    },
        
        xAxis: {
        type: 'category',
        name: '日期',
        boundaryGap: false,
        data: this.DateArr
    },
    yAxis: {
        type: 'value',
        name: '数量',
    },

        series: [{
            name: '分销商新增数量',
            type: 'line',
            data: this.AgentDailyArr
            // [120, 132, 101, 134, 90, 230, 210]
        },
        {
            name: '会员新增数量',
            type: 'line',
            data: this.MembersDailyArr
            // [220, 182, 191, 234, 290, 330, 310]
        },
        {
            name: '订单新增数量',
            type: 'line',
            data: this.OrdersDailyArr
            // [150, 232, 201, 154, 190, 330, 410]
        },]

      });

       })
    },
  
  },
 
  
   created() {
   
  },
  mixins: [http]
}
</script>



<style lang="scss">
  @import './index.scss';
</style>
 