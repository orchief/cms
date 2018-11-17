<template>
        <div>
            <div id="maindiv" style="">
                <div class="form-group" v-for="item in form">
                    <label class="form-inline">{{item.time}}</label>
                    <div class="col-xs-4">
                         <input name="" type="text" readonly="readonly" v-model="item.context" id="" class="form-control" content="">
                        <!-- <p class="helper">{{item.remark}}</p> -->
                    </div>
                </div>
                 <!-- <div class="form-group">
                    <div class="col-xs-offset-2 col-xs-10 marginl">
                        <input type="submit" name="" value="保存" @click="commit" id="" class="btn btn-success inputw100">
                    </div>
                </div> -->
             </div>
            </div>
</template>


<style lang="scss">
  @import './index.scss';
</style>

<script>
import http from 'assets/js/http'
export default {
    data(){
        return {
            id: null,
            form: null
        }
    },
    created(){
        var orderId =this.$route.params.id
        const data = {
            params: {
                orderId: orderId
            }
        }
        _g.openGlobalLoading()
        this.apiGet('admin/Express', data).then(res => {
            this.handelResponse(res, data => {
                this.form = data.data
                this.id = data.data
                console.log(this.id)
            })
      })
    },
    methods: {
        commit(){
            const data = {
                value: this.form
            }
            console.log(this.id)
            _g.openGlobalLoading()
            this.apiPut('admin/setting/', this.id, data).then(res => {
                this.handelResponse(res, data => {
                    _g.toastMsg('success', res.data.msg)
                })
            })
        }
    },
    mixins: [http]
}
</script>

