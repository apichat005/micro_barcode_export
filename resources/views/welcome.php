<!DOCTYPE html>
<html>

<head>
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@6.x/css/materialdesignicons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.min.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">
</head>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Fira+Code&family=Noto+Sans+Thai:wght@300&family=Sarabun:ital,wght@0,300;1,300&display=swap');

    * {
        font-family: 'Noto Sans Thai', sans-serif;
    }
</style>

<body>
    <div id="app">
        <v-app>
            <v-main>
                <v-container>
                    <h3><b>พิมพ์บาร์โค้ด</b></h3>
                    <v-row class="px-0">
                        <v-col class="col-12 col-lg-4">
                            <v-text-field label="รหัสสินค้า" ref="keyword" v-model="product_code" outlined dense color="primary" class="mt-3" hide-details></v-text-field>
                            <div style="display:flex;justify-content:space-between">
                                <div>
                                    <div class="mt-4 mb-2" style="font-size:14px"><b>สินค้าทั้งหมด {{prodcut_all.length}} รายการ</b></div>
                                </div>
                                <div>
                                    <v-select :items="['10','50','100','500','1000','2000','5000']" label="แสดง" v-model="page" :value="page" dense hide-details class="mt-5" style="width:100px" />
                                </div>
                            </div>

                            <v-list-item class="px-0" v-for="item in prodcut_all.filter((item,index)=> {
                                if(product_code.length == 0) {
                                    while(index < page ){
                                        return item
                                    }
                                }else{
                                    if(product_code.length >= 3){
                                        return item.pro_barcode.includes(product_code) || item.pro_name.includes(product_code)
                                    }
                                }
                            })" :key="item.pro_id">
                                <v-list-item-content>
                                    <v-row class="px-0">
                                        <v-col class="col-auto ml-3">
                                            <v-checkbox color="primary"
                                            hide-details dense :checked="item.check" @change="
                                            item.check = !item.check;"></v-checkbox>
                                        </v-col>
                                        <v-col>
                                            <v-list-item-subtitle>{{item.pro_barcode}}</v-list-item-subtitle>
                                            <v-list-item-title>{{item.pro_name}}</v-list-item-title>
                                        </v-col>
                                    </v-row>
                                </v-list-item-content>
                            </v-list-item>
                        </v-col>
                        <v-col class="col-12 col-lg-8">
                            <!-- รายการที่เลือก -->
                            <div style="display:flex;justify-content:space-between">
                                <div>
                                    <h4 class="mt-2 mb-4">รายการที่เลือก</h4>
                                    <div style="font-size: 12px;">
                                        <b>
                                            จำนวน {{
                                        prodcut_all.filter((item,index)=> item.check == true).length}}
                                            รายการ
                                        </b>
                                    </div>
                                </div>

                                <div>
                                    <v-btn elevation="0" rounded color="primary" class="mt-2 mb-4" style="width:150px" @click="print">
                                        <v-icon left>mdi-printer</v-icon>
                                        <b>พิมพ์บาร์โค้ด</b>
                                    </v-btn>
                                </div>
                            </div>

                            <v-row no-gutters class="px-0">
                                <v-col class="col-12 col-lg-4" v-for="item in prodcut_all.filter((item,index)=> item.check == true)" :key="item.pro_id">
                                    <v-sheet class="ma-2 px-3 py-0 pt-3" style="display:flex;justify-content:space-between;border-radius:5px;">
                                        <div style="position: absolute;">
                                            <span style="position:relative;top:-30px;right:-230px;cursor:pointer" @click="item.check = !item.check">
                                                <v-badge color="red" overlap>
                                                    <template v-slot:badge>
                                                        <v-icon color="white">mdi-close</v-icon>
                                                    </template>
                                                </v-badge>
                                            </span>
                                        </div>
                                        <div style="margin-top:2px;display:flex;justify-content:space-around">
                                            <div>
                                                <img :src="'https://chart.googleapis.com/chart?chs=150x150&cht=qr&chl='+item.pro_barcode" style="width:50px;height:50px;object-fit:conver;position:relative;left:-5px;top:-5px">
                                            </div>
                                            <div>
                                                <div style="font-size:12px;color:#5D5D5D">{{item.pro_barcode}}</div>
                                                <div :style="item.pro_name.length < 30 ? 'font-size:14px;' : 'font-size:12px;'"><b>
                                                    {{item.pro_name.length > 50
                                                    ? item.pro_name.substring(0,50)+'...'
                                                    : item.pro_name
                                                }}</b></div>
                                            </div>
                                        </div>
                                        <div>
                                            <div style="font-size:12px;color:#5D5D5D">ราคา</div>
                                            <div style="font-size:18px"><b>{{item.price}}.-</b></div>
                                        </div>
                                    </v-sheet>
                                </v-col>
                            </v-row>
                        </v-col>
                    </v-row>
                </v-container>
            </v-main>
        </v-app>
    </div>
</body>

<script src="https://cdn.jsdelivr.net/npm/vue@2.x/dist/vue.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.debug.js" integrity="sha384-NaWTHo/8YCBYJ59830LTz/P4aQZK1sS0SneOgAvhsIl3zBu8r9RevNg5lHCHAuQ/" crossorigin="anonymous"></script>
<script setup>
    const app = new Vue({
        el: '#app',
        vuetify: new Vuetify({
            theme: {
                dark: true,
                themes: {
                    dark: {
                        background: '#1a202c',
                    }
                }
             },
        }),
        data: {
            product_code: "",
            prodcut_all: [],
            page: 10
        },
        methods: {
            getProduct() {
                fetch('http://apichatapi.ddns.net/api/pos/item_all.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            database: "data_store_1"
                        })
                    }).then(res => res.json())
                    .then(res => {
                        var array = []
                        res.forEach(element => {
                            array.push({
                                pro_id: element.pro_id,
                                pro_barcode: element.pro_barcode,
                                pro_name: element.pro_name,
                                price: element.price,
                                check: false
                            })
                        });
                        this.prodcut_all = array
                    })
            },
            print() {
                var filename = "";
                var array = []
                this.prodcut_all.forEach(element => {
                    if (element.check == true) {
                        array.push(element.pro_id)
                    }
                });
                // encode base64
                var base64 = btoa(array)
                // encode base64
                var url = "export_pdf/" + base64
                window.open(url, '_blank');
            }
        },
        mounted() {
            this.getProduct()
        },
    })
</script>
</body>

</html>
