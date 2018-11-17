<template>
    <div class="fl">
         <template v-for="(item,index) in config">
          <template v-if="item.type == 'input'">
            <el-input :placeholder="item.label" v-model="data.exchanged.search[item.prop]"></el-input>
          </template>

          <template v-if="item.type == 'select'">
            <el-select filterable :key="index"  v-model="data.exchanged.search[item.prop]" :placeholder="item.label" :multiple="item.multiple" clearable>
              <el-option v-for="(option,i) in data.received.search[item.prop]" :key="i" :label="option.label" :value="option.value"></el-option>
            </el-select>
          </template>

          <!-- <template v-if="item.type == 'range'">
            <el-select filterable :key="index"  v-model="data.exchanged.search[items.name]" :placeholder="items.placeholder" :multiple="items.multiple" clearable>
              <el-option v-for="(item,i) in data.received.search[items.name]" :key="i" :label="item.label" :value="item.value"></el-option>
            </el-select>
          </template>  -->

           <template v-if="item.type == 'datetimerange'">
            <el-date-picker
                v-model="data.exchanged[item.prop]"
                :type="item.type"
                :picker-options="pickerOptions2"
                range-separator="--"
                :start-placeholder="'开始'"
                :end-placeholder="'结束'"
                
                align="right">
            </el-date-picker>
          </template>
        </template> 
        <div class="el-input">
          <el-button type='primary'>搜索</el-button>
          <el-button type='warning'>清空</el-button>
        </div>
    </div>
</template>

<script>
export default {
  props: ['config', 'data'],
  data() {
    return {
      tempDate: null,
      pickerOptions2: {
        shortcuts: [
          {
            text: '最近一周',
            onClick(picker) {
              const end = new Date()
              const start = new Date()
              start.setTime(start.getTime() - 3600 * 1000 * 24 * 7)
              picker.$emit('pick', [start, end])
            }
          },
          {
            text: '最近一个月',
            onClick(picker) {
              const end = new Date()
              const start = new Date()
              start.setTime(start.getTime() - 3600 * 1000 * 24 * 30)
              picker.$emit('pick', [start, end])
            }
          },
          {
            text: '最近三个月',
            onClick(picker) {
              const end = new Date()
              const start = new Date()
              start.setTime(start.getTime() - 3600 * 1000 * 24 * 90)
              picker.$emit('pick', [start, end])
            }
          }
        ]
      }
    }
  },
  methods: {
    handleDateChange(date, item) {
      if (date === null) {
        this.data.exchanged.search[item.name] = ''
        return true
      }
      if (date === '') {
        return true
      }
      let start = new Date(date[0])
      let separator = item.separator
      let end = new Date(date[1])
      let startString =
        start.getFullYear() +
        '-' +
        (start.getMonth() + 1) +
        '-' +
        start.getDate() +
        ' ' +
        start.getHours() +
        ':' +
        start.getMinutes() +
        ':' +
        start.getSeconds()
      let endString =
        end.getFullYear() +
        '-' +
        (end.getMonth() + 1) +
        '-' +
        end.getDate() +
        ' ' +
        end.getHours() +
        ':' +
        end.getMinutes() +
        ':' +
        end.getSeconds()
      let resDate = startString + separator + endString
      this.data.exchanged.search[item.name] = resDate
      //                // 日期查询
    }
  }
}
</script>

<style scoped>
.el-input--small .el-input__inner {
  height: 30px;
  width: 200px;
}
.el-select {
  display: block;
  position: relative;
  float: left;
}
.el-input,
.el-input__inner {
  width: 217px !important;
}
.el-select > .el-input {
  display: block;
}
input.el-input__inner {
  width: 192px !important;
}
.el-select {
  display: inline-block !important;
  margin-top: 2px;
  margin-left: 5px !important;
}

.el-input {
  margin-top: 2px;
  margin-left: 5px !important;
  float:left;
}
.el-select > .el-input {
  width: 222px !important;
}
.el-date-editor {
  margin-top: 2px;
  margin-left: 5px !important;
  float:left;
}
</style>